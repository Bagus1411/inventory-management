<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\OutgoingTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OutgoingTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            OutgoingTransaction::create([
                'created_by' => 'Admin',
                'updated_by' => null,
                'code' => 'OUT-' . Str::upper(Str::random(6)),
                'note' => 'Sample outgoing note ' . $i,
                'date' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
