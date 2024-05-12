<?php

namespace App\Enum\Billboard;

use Filament\Support\Contracts\HasLabel;

enum Size: string implements HasLabel
{
    case Small = 'small';
    case Medium = 'medium';
    case Large = 'large';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Small => 'Small',
            self::Medium => 'Medium',
            self::Large => 'Large',
        };
    }
}
