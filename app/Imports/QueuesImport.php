<?php

namespace App\Imports;

use App\Models\Queue;
use App\Models\Counter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QueuesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Cache counters
        $counters = Counter::all()->keyBy('name');

        foreach ($rows as $row) {
            $nama = $row['nama'] ?? $row['name'] ?? null;
            $poli = $row['poli'] ?? null;

            if (!$nama || !$poli) {
                continue;
            }

            $counter = $counters->get($poli);
            if (!$counter) {
                $counter = Counter::whereRaw('LOWER(name) = ?', [strtolower(trim($poli))])->first();
                if ($counter) {
                    $counters->put($poli, $counter);
                }
            }

            if ($counter) {
                // DB Transaction & Lock for safety
                DB::transaction(function () use ($counter, $nama) {
                    $lastQueue = Queue::where('counter_id', $counter->id)
                        ->whereDate('created_at', Carbon::today())
                        ->orderBy('id', 'desc')
                        ->lockForUpdate()
                        ->first();

                    $nextNumber = 1;
                    if ($lastQueue) {
                        $parts = explode('-', $lastQueue->queue_number);
                        if (count($parts) == 2) {
                            $nextNumber = (int)$parts[1] + 1;
                        } else {
                            $nextNumber = Queue::where('counter_id', $counter->id)->whereDate('created_at', Carbon::today())->count() + 1;
                        }
                    }

                    $prefix = $counter->prefix ?? 'Q';
                    $queueNumber = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                    Queue::create([
                        'counter_id' => $counter->id,
                        'queue_number' => $queueNumber,
                        'patient_name' => $nama,
                        'status' => 'waiting',
                    ]);
                });
            }
        }
    }
}
