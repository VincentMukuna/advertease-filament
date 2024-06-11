<?php

namespace App\Jobs;

use App\Actions\Billboard\BillboardMaintenance;
use App\Models\Billboard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateMaintenanceStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $start_today = now()->startOfDay()->toDateTimeString();
        $end_today = now()->endOfDay()->toDateTimeString();

        //billboards with maintenance ending today
        $billboards = Billboard::query()
            ->whereHas('maintenances', function ($query) use ($start_today, $end_today) {
                $query->whereBetween('end_date', [$start_today, $end_today]);
            })
            ->get();

        $billboards->each(function ($billboard) {
            BillboardMaintenance::end($billboard);
        });

    }
}
