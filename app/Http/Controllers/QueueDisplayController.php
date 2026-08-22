<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Queue;
use App\Models\QueueDisplaySetting;
use App\Models\SiteSetting;

class QueueDisplayController extends Controller
{
    public function index()
    {
        return Inertia::render('Antrian/Display', [
            'settings' => QueueDisplaySetting::first(),
            'siteSetting' => SiteSetting::first(),
        ]);
    }

    public function data()
    {
        $callingQueue = Queue::with('counter')
            ->where('status', 'calling')
            ->latest('updated_at')
            ->first();

        // 2 antrian sebelumnya (selain yang sedang dipanggil)
        $previousQueuesQuery = Queue::with('counter')
            ->where('status', '!=', 'waiting')
            ->where('created_at', '>=', \Carbon\Carbon::today())
            ->latest('updated_at');
        
        if ($callingQueue) {
            $previousQueuesQuery->where('id', '!=', $callingQueue->id);
        }

        $previousQueues = $previousQueuesQuery->take(2)->get();

        // 2 antrian selanjutnya (yang sedang menunggu)
        $nextQueues = Queue::with('counter')
            ->where('status', 'waiting')
            ->where('created_at', '>=', \Carbon\Carbon::today())
            ->orderBy('id', 'asc')
            ->take(2)
            ->get();

        return response()->json([
            'calling' => $callingQueue,
            'previous' => $previousQueues,
            'next' => $nextQueues,
            'settings' => QueueDisplaySetting::first(),
        ]);
    }
}
