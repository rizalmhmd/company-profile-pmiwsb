<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Queue;
use App\Models\Counter;

class QueueController extends Controller
{
    public function index()
    {
        $counters = Counter::all();
        $queues = Queue::with('counter')->latest()->paginate(20);

        return Inertia::render('Admin/Queue/Index', [
            'counters' => $counters,
            'queues' => $queues
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'counter_id' => 'required|exists:counters,id',
            'queue_number' => 'required|string|max:50',
            'patient_name' => 'nullable|string|max:255',
        ]);

        Queue::create($request->all());

        return redirect()->back()->with('success', 'Antrian berhasil ditambahkan');
    }

    public function call(Queue $queue)
    {
        // Set all other 'calling' to 'finished' first if we want only one active at a time,
        // or just let them be and TV display takes the latest.
        // Let's set the current one to calling.
        $queue->update(['status' => 'calling']);

        return redirect()->back()->with('success', 'Memanggil antrian ' . $queue->queue_number);
    }

    public function finish(Queue $queue)
    {
        $queue->update(['status' => 'finished']);

        return redirect()->back()->with('success', 'Antrian selesai');
    }
}
