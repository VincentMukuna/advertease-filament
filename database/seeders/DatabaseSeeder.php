<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Billboard;
use App\Models\BillboardOwner;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::raw('SET time_zone=\'+00:00\'');

        // Clear images
        Storage::deleteDirectory('public');

        $this->command->callSilently('shield:generate', ['--all' => true]);

        //Admin
        $this->command->warn(PHP_EOL.'Creating admin user...');
        $user = $this->withProgressBar(1, fn () => User::factory(1)->create([
            'name' => 'Admin',
            'email' => 'admin@localhost.com',
        ]));
        $this->command->callSilently('shield:super-admin', ['--user' => $user->first()->id]);
        $this->command->info('Admin user created.');

        $this->call(RolesPermissionsSeeder::class);

        //Create users
        $this->command->warn(PHP_EOL.'Creating users...');

        $brands = $this->withProgressBar(5, fn () => Brand::factory(1)
            ->hasAttached(Address::factory()->count(rand(1, 3)))
            ->create());
        $this->command->info(PHP_EOL.'Users created.');

        $this->command->warn(PHP_EOL.'Creating billboards owners...');
        $billboardOwners = $this->withProgressBar(5, fn () => BillboardOwner::factory(1)->hasAttached(Address::factory()->count(rand(1, 3)))->create());
        $this->command->info(PHP_EOL.'Billboard owners created.');

        $this->command->warn(PHP_EOL.'Creating campaigns...');
        $campaigns = $this->withProgressBar(10, fn () => Campaign::factory(1)
            ->sequence(fn ($sequence) => ['brand_id' => $brands->random(1)->first()->id])
            ->has(Payment::factory()->count(rand(3, 5)))
            ->hasAttached(Billboard::factory()
                ->count(rand(5, 10))
                ->state(
                    ['is_visible' => true, 'booking_status' => 'available']
                )
                ->sequence(fn ($sequence) => [
                    'billboard_owner_id' => $billboardOwners->random(1)->first()->id,
                ]))
            ->create()
        );
        $this->command->info(PHP_EOL.'Campaigns created.');

        $this->command->warn(PHP_EOL.'Creating billboards...');
        $this->withProgressBar(30, fn () => Billboard::factory(1)
            ->sequence(fn ($sequence) => ['billboard_owner_id' => $billboardOwners->random(1)->first()->id])
            ->state(
                ['is_visible' => true, 'booking_status' => 'available']
            )
            ->withinNairobi()
            ->create()
        );
        $this->command->info(PHP_EOL.'Billboards created.');
        $this->command->info(PHP_EOL.'Seeding complete.');
    }

    protected function withProgressBar(int $amount, \Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection();

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
