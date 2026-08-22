<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Queue;
use App\Models\Counter;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QueuesImport;
use App\Exports\QueuesExport;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
class QueueController extends Controller
{
    public function index(Request $request)
    {
        $counters = Counter::all();

        $queues = Queue::with('counter')
            ->where('created_at', '>=', \Carbon\Carbon::today())
            ->when($request->search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('patient_name', 'like', "%{$search}%")
                      ->orWhere('queue_number', 'like', "%{$search}%");
                });
            })
            ->when($request->counter_id, function ($query, $counter_id) {
                $query->where('counter_id', $counter_id);
            })
            ->when($request->status, function ($query, $status) {
                if ($status === 'skipped') {
                    $query->where('status', 'finished')->where('is_skipped', true);
                } elseif ($status === 'finished') {
                    $query->where('status', 'finished')->where('is_skipped', false);
                } else {
                    $query->where('status', $status);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->withQueryString();

        $todayQueues = Queue::with('counter')->where('created_at', '>=', \Carbon\Carbon::today());
        $totalToday = (clone $todayQueues)->count();
        $finishedToday = (clone $todayQueues)->where('status', 'finished')->count();
        $globalCalling = (clone $todayQueues)->where('status', 'calling')->orderBy('updated_at', 'desc')->first();
        $globalNext = (clone $todayQueues)->where('status', 'waiting')->orderBy('id', 'asc')->first();

        return Inertia::render('Admin/Queue/Index', [
            'counters' => $counters,
            'queues' => $queues,
            'dashboard_stats' => [
                'total' => $totalToday,
                'finished' => $finishedToday,
                'progress_percentage' => $totalToday > 0 ? round(($finishedToday / $totalToday) * 100) : 0,
                'global_calling' => $globalCalling,
                'global_next' => $globalNext,
            ],
            'filters' => $request->only(['search', 'counter_id', 'status']),
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new QueuesImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data antrian berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new QueuesExport, 'Data_Antrian_' . date('Y-m-d') . '.xlsx');
    }

    public function exportToSheets()
    {
        try {
            $sheetId = env('GOOGLE_SHEET_ID');
            $credentialsPath = base_path(env('GOOGLE_CREDENTIALS_PATH'));

            if (!$sheetId || !file_exists($credentialsPath)) {
                return redirect()->back()->with('error', 'Konfigurasi Google Sheets belum lengkap atau file kredensial tidak ditemukan.');
            }

            $client = new Client();
            $client->setApplicationName('PMI Queue Export');
            $client->setScopes([Sheets::SPREADSHEETS]);
            $client->setAuthConfig($credentialsPath);
            $client->setAccessType('offline');

            $service = new Sheets($client);

            // Ambil data antrian hari ini
            $queues = Queue::with('counter')
                ->whereDate('created_at', Carbon::today())
                ->orderBy('id', 'asc')
                ->get();

            if ($queues->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data antrian hari ini untuk diekspor.');
            }

            $values = [];
            
            // Header
            $values[] = [
                'Nama',
                'Poli',
                'Nomor Antrian',
                'Status',
                'Waktu Masuk',
            ];

            // Data
            foreach ($queues as $queue) {
                $values[] = [
                    $queue->patient_name,
                    $queue->counter ? $queue->counter->name : '',
                    $queue->queue_number,
                    $queue->status,
                    $queue->created_at->format('Y-m-d H:i:s'),
                ];
            }

            $body = new ValueRange([
                'values' => $values
            ]);

            $params = [
                'valueInputOption' => 'USER_ENTERED'
            ];

            // Nama sheet berdasarkan tanggal hari ini
            $sheetTitle = Carbon::today()->format('d-m-Y');
            
            // Cek apakah sheet dengan nama tersebut sudah ada
            $spreadsheet = $service->spreadsheets->get($sheetId);
            $sheets = $spreadsheet->getSheets();
            $sheetExists = false;
            foreach ($sheets as $s) {
                if ($s->getProperties()->getTitle() == $sheetTitle) {
                    $sheetExists = true;
                    break;
                }
            }

            // Jika belum ada, buat sheet baru
            if (!$sheetExists) {
                $addSheetRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                    'requests' => [
                        'addSheet' => [
                            'properties' => [
                                'title' => $sheetTitle
                            ]
                        ]
                    ]
                ]);
                $service->spreadsheets->batchUpdate($sheetId, $addSheetRequest);
            }

            // Range untuk menulis (di sheet yang sesuai dengan tanggal hari ini)
            $range = "'" . $sheetTitle . "'!A1"; 
            
            // Bersihkan data lama di sheet tersebut (jika ada yang klik 2 kali di hari yang sama)
            $service->spreadsheets_values->clear($sheetId, $range, new \Google\Service\Sheets\ClearValuesRequest());
            
            // Tulis data baru
            $result = $service->spreadsheets_values->update($sheetId, $range, $body, $params);

            $sheetUrl = "https://docs.google.com/spreadsheets/d/" . $sheetId . "/edit";

            return redirect()->back()
                ->with('success', 'Data antrian berhasil dikirim ke tab baru di Google Sheets.')
                ->with('url', $sheetUrl);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim ke Google Sheets: ' . $e->getMessage());
        }
    }

    public function manualAdd(Request $request)
    {
        $request->validate([
            'counter_id' => 'required|exists:counters,id',
            'patient_name' => 'required|string|max:255',
        ]);

        $counter = Counter::findOrFail($request->counter_id);

        \Illuminate\Support\Facades\DB::transaction(function () use ($counter, $request) {
            $lastQueue = Queue::where('counter_id', $counter->id)
                ->where('created_at', '>=', Carbon::today())
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;
            if ($lastQueue) {
                $parts = explode('-', $lastQueue->queue_number);
                if (count($parts) == 2) {
                    $nextNumber = (int)$parts[1] + 1;
                } else {
                    $nextNumber = Queue::where('counter_id', $counter->id)->where('created_at', '>=', Carbon::today())->count() + 1;
                }
            }

            $prefix = $counter->prefix ?? 'Q';
            $queueNumber = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            Queue::create([
                'counter_id' => $counter->id,
                'queue_number' => $queueNumber,
                'patient_name' => $request->patient_name,
                'status' => 'waiting',
            ]);
        });

        return redirect()->back()->with('success', 'Pasien berhasil ditambahkan secara manual.');
    }

    public function callNext(Counter $counter)
    {
        // Set all currently 'calling' for this counter to 'finished' and mark as skipped
        Queue::where('counter_id', $counter->id)
            ->where('created_at', '>=', \Carbon\Carbon::today())
            ->where('status', 'calling')
            ->update(['status' => 'finished', 'is_skipped' => true]);

        // Find the oldest 'waiting'
        $nextQueue = Queue::where('counter_id', $counter->id)
            ->where('created_at', '>=', \Carbon\Carbon::today())
            ->where('status', 'waiting')
            ->orderBy('id', 'asc')
            ->first();

        if ($nextQueue) {
            $nextQueue->update(['status' => 'calling', 'is_skipped' => false]);
            return redirect()->back()->with('success', 'Memanggil antrian pasien: ' . $nextQueue->patient_name);
        }

        return redirect()->back()->with('error', 'Tidak ada antrian yang menunggu di ' . $counter->name);
    }

    public function call(Queue $queue)
    {
        // Set all other 'calling' to 'finished' first if we want only one active at a time,
        // or just let them be and TV display takes the latest.
        // Let's set the current one to calling.
        $queue->update(['status' => 'calling', 'is_skipped' => false]);
        $queue->touch(); // Force update timestamp so display can detect recall

        return redirect()->back()->with('success', 'Memanggil antrian pasien: ' . $queue->patient_name);
    }

    public function finish(Queue $queue)
    {
        $queue->update(['status' => 'finished', 'is_skipped' => false]);

        return redirect()->back()->with('success', 'Antrian selesai');
    }

    public function update(Request $request, Queue $queue)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'counter_id' => 'required|exists:counters,id',
        ]);

        $queue->update([
            'patient_name' => $request->patient_name,
            'counter_id' => $request->counter_id,
        ]);

        return redirect()->back()->with('success', 'Data antrian berhasil diperbarui.');
    }

    public function callNextGlobal()
    {
        $updated = Queue::where('created_at', '>=', \Carbon\Carbon::today())
            ->where('status', 'calling')
            ->update(['status' => 'finished', 'is_skipped' => true]);

        $nextQueue = Queue::where('created_at', '>=', \Carbon\Carbon::today())
            ->where('status', 'waiting')
            ->orderBy('id', 'asc')
            ->first();

        if ($nextQueue) {
            $nextQueue->update(['status' => 'calling', 'is_skipped' => false]);
            return redirect()->back()->with('success', 'Memanggil antrian pasien: ' . $nextQueue->patient_name);
        }

        if ($updated) {
            return redirect()->back()->with('success', 'Pasien berhasil dilewati (Skip). Tidak ada antrian selanjutnya.');
        }

        return redirect()->back()->with('error', 'Tidak ada antrian yang menunggu.');
    }

    public function finishAndCallNextGlobal()
    {
        Queue::where('created_at', '>=', \Carbon\Carbon::today())
            ->where('status', 'calling')
            ->update(['status' => 'finished', 'is_skipped' => false]);

        $nextQueue = Queue::where('created_at', '>=', \Carbon\Carbon::today())
            ->where('status', 'waiting')
            ->orderBy('id', 'asc')
            ->first();

        if ($nextQueue) {
            $nextQueue->update(['status' => 'calling', 'is_skipped' => false]);
            return redirect()->back()->with('success', 'Memanggil antrian pasien: ' . $nextQueue->patient_name);
        }

        return redirect()->back()->with('success', 'Antrian selesai. Tidak ada antrian yang menunggu.');
    }

    public function destroy(Queue $queue)
    {
        $queue->delete();
        return redirect()->back()->with('success', 'Riwayat antrian berhasil dihapus.');
    }

    public function destroyBulk(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:queues,id'
        ]);

        Queue::whereIn('id', $request->ids)->delete();
        return redirect()->back()->with('success', 'Riwayat antrian terpilih berhasil dihapus.');
    }

    public function clear()
    {
        Queue::query()->delete();
        return redirect()->back()->with('success', 'Semua riwayat antrian berhasil dihapus.');
    }
}
