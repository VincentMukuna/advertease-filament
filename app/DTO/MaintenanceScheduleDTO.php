<?php

namespace App\DTO;

class MaintenanceScheduleDTO
{
    public function __construct(
        public $start_date,
        public $end_date,
    ) {
    }
}
