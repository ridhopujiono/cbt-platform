<?php

namespace Database\Seeders;

use App\Models\Passage;
use Illuminate\Database\Seeder;

class PassageSeeder extends Seeder
{
    public function run(): void
    {
        Passage::create([
            'content' => 'Perhatikan pernyataan berikut untuk menjawab soal nomor 1 sampai 5.',
            'media_url' => null,
        ]);
    }
}
