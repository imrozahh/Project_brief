<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;


class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'title' => 'Seminar Teknologi 2025',
            'description' => 'Sebuah seminar tentang teknologi terbaru di 2025',
            'venue' => 'Aula SOetrisno, Politeknik Negeri Jember',
            'start_datetime' => '2025-08-02 09:00:00',
            'end_datetime'   => '2025-08-02 10:00:00',
            'status' => 'published',
            'organizer_id' => 2, // Organizer One
        ]);
        Event::create([
            'title' => 'Wisuda 2025',
            'description' => 'Sebuah acara wisuda pada tahun 2025',
            'venue' => 'Aula SOetrisno, Politeknik Negeri Jember',
            'start_datetime' => '2025-08-26 09:00:00',
            'end_datetime'   => '2025-08-26 12:00:00',
            'status' => 'draft',
            'organizer_id' => 3, // Organizer One
        ]);
    }
}
