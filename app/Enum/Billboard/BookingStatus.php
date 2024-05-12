<?php

namespace App\Enum\Billboard;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum BookingStatus: string implements HasColor, HasIcon, HasLabel
{
    case Available = 'available';
    case Booked = 'booked';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Available => 'Available',
            self::Booked => 'Booked',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Available => 'success',
            self::Booked => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Available => 'heroicon-o-check-circle',
            self::Booked => 'heroicon-o-x-circle',
        };
    }
}
