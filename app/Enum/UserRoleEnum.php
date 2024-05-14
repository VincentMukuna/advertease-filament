<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum UserRoleEnum: string implements HasColor, HasIcon, HasLabel
{
    case Advertiser = 'advertiser';
    case BillboardOwner = 'billboard_owner';
    case SuperAdmin = 'super_admin';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Advertiser => 'info',
            self::BillboardOwner => 'primary',
            self::SuperAdmin => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Advertiser => 'heroicon-o-user',
            self::BillboardOwner => 'billboard',
            self::SuperAdmin => 'administrator',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Advertiser => 'Advertiser',
            self::BillboardOwner => 'Billboard Owner',
            self::SuperAdmin => 'Super Admin',
        };
    }
}
