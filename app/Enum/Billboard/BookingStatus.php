<?php

namespace App\Enum\Billboard;

enum BookingStatus: string
{
    case Available = 'available';
    case Booked  = 'booked';

}
