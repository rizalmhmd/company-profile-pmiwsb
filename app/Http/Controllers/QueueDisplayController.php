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

        // 5 antrian terakhir (selain yang sedang dipanggil) dari berbagai poli
        $recentQueuesQuery = Queue::with('counter')
            ->where('status', '!=', 'waiting')
            ->latest('updated_at');
        
        if ($callingQueue) {
            $recentQueuesQuery->where('id', '!=', $callingQueue->id);
        }

        $recentQueues = $recentQueuesQuery->take(5)->get();

        return response()->json([
            'calling' => $callingQueue,
            'recent' => $recentQueues,
            'settings' => QueueDisplaySetting::first(),
        ]);
    }
}
