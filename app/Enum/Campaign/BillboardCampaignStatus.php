<?php

namespace App\Enum\Campaign;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum BillboardCampaignStatus: string implements HasColor, HasIcon, HasLabel
{
    case Printing = 'printing';
    case Installing = 'installing';
    case Active = 'active';
    case Maintenance = 'maintenance';
    case Completed = 'completed';

    //
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Printing => 'warning',
            self::Installing => 'primary',
            self::Active => 'success',
            self::Completed => 'info',
            self::Maintenance => 'danger'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Printing => 'heroicon-o-printer',
            self::Installing => 'heroicon-o-cog',
            self::Active => 'heroicon-o-rocket-launch',
            self::Completed => 'heroicon-o-clipboard-document-check',
            self::Maintenance => 'heroicon-o-wrench'
        };

    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Printing => 'Printing',
            self::Installing => 'Installing',
            self::Active => 'Active',
            self::Completed => 'Completed',
            self::Maintenance => 'Maintenance'
        };
    }
}
