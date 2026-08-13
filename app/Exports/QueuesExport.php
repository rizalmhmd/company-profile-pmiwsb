<?php

namespace App\Exports;

use App\Models\Queue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class QueuesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Queue::with('counter')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('id', 'asc')
            ->get();
    }

    public function map($queue): array
    {
        return [
            $queue->patient_name,
            $queue->counter ? $queue->counter->name : '',
            $queue->queue_number,
            $queue->status,
            $queue->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Poli',
            'Nomor Antrian',
            'Status',
            'Waktu Masuk',
        ];
    }
}
