<?php

namespace Database\Seeders;

use App\Models\Remote;
use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RemoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing venues
        $venues = Venue::all();

        // Check if there are venues to assign to remotes
        if ($venues->isEmpty()) {
            $this->command->info('No venues available. Please seed venues first.'); 
            return;
        }

        // Create 20 remotes with varying venues
        for ($i = 1; $i <= 20; $i++) {
            Remote::create([
                'venue_id' => $venues->random()->id, // Randomly select a venue
            ]);
        }
    }
}
