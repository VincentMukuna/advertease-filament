<?php

namespace App\Enum\Billboard;

enum Type : string
{
    case Static = "static";
    case Backlit = "backlit";
    case Digital = "digital";
    case Mobile = "mobile";
}
