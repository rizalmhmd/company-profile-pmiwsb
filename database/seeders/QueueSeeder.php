<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Counter;
use App\Models\QueueDisplaySetting;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $counters = [
            ['name' => 'Poli Umum', 'type' => 'poli', 'prefix' => 'A'],
            ['name' => 'Poli Gigi', 'type' => 'poli', 'prefix' => 'B'],
            ['name' => 'Poli Anak', 'type' => 'poli', 'prefix' => 'C'],
            ['name' => 'Poli KIA/KB', 'type' => 'poli', 'prefix' => 'D'], // Placeholder for the 4th
        ];

        foreach ($counters as $counter) {
            Counter::firstOrCreate(['name' => $counter['name']], $counter);
        }

        QueueDisplaySetting::firstOrCreate([
            'id' => 1
        ], [
            'video_url' => 'https://www.youtube.com/embed/ScMzIvxBSi4', // Placeholder youtube video
            'running_text' => 'Selamat Datang di PMI. Harap sabar menunggu giliran Anda. Kami melayani dengan setulus hati.'
        ]);
    }
}
