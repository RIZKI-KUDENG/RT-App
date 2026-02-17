<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ContributionType;
use App\Models\Expense;
use App\Models\House;
use App\Models\HouseOccupant;
use App\Models\Occupant;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $satpam = ContributionType::create([
            'name' => 'Satpam',
            'amount' => 100000
        ]);

        $kebersihan = ContributionType::create([
            'name' => 'iuran kebersihan',
            'amount' => 15000
        ]);
        for ($i = 1; $i <= 20; $i++) {
            $status = ($i <= 15) ? 'occupied' : 'empty';

            $blok = ($i <= 10) ? 'A' : 'B';
            $number = ($i <= 10) ? $i : $i - 10;

            $house = House::create([
                'address' => "blok $blok no $number",
                'status' => $status
            ]);
            if ($status === 'occupied') {
                $occupant = Occupant::factory()->create([
                    'status' => 'permanent'
                ]);
                $history = HouseOccupant::create([
                    'house_id' => $house->id,
                    'occupant_id' => $occupant->id,
                    'start_date' => Carbon::now()->subYear(2),
                    'end_date' => null
                ]);
                for ($bulan = 0; $bulan < 6; $bulan++) {
                    $periode = Carbon::now()->subMonths($bulan)->startOfMonth();

                    Transaction::create([
                        'house_occupant_id' => $history->id,
                        'contribution_type_id' => $satpam->id,
                        'amount' => $satpam->amount,
                        'payment_date' => Carbon::now()->subMonths($bulan)->addDays(rand(1, 5)), 
                        'period' => $periode,
                    ]);

                    Transaction::create([
                        'house_occupant_id' => $history->id,
                        'contribution_type_id' => $kebersihan->id,
                        'amount' => $kebersihan->amount,
                        'payment_date' => Carbon::now()->subMonths($bulan)->addDays(rand(1, 5)),
                        'period' => $periode,
                    ]);
                }
            } elseif ($i == 16) {
                $pastOccupant = Occupant::factory()->create([
                    'status' => 'contract'
                ]);
                HouseOccupant::create([
                    'house_id' => $house->id,
                    'occupant_id' => $pastOccupant->id,
                    'start_date' => Carbon::now()->subMonths(10),
                    'end_date' => Carbon::now()->subMonths(2),
                ]);
            }
        }
        Expense::factory(10)->create();
    }
}
