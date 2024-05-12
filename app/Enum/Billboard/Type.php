<?php

namespace App\Enum\Billboard;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Type: string implements HasColor, HasLabel
{
    case Static = 'static';
    case Backlit = 'backlit';
    case Digital = 'digital';
    case Mobile = 'mobile';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Static => 'Static',
            self::Backlit => 'Backlit',
            self::Digital => 'Digital',
            self::Mobile => 'Mobile',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Static => 'success',
            self::Backlit => 'pink',
            self::Digital => 'warning',
            self::Mobile => 'info',
        };
    }
}
