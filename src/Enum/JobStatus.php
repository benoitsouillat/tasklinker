<?php

namespace App\Enum;

enum JobStatus: string
{
    case cdi = "CDI";
    case cdd = "CDD";
    case freelance = "Freelance";
    case interim = "Interim";

    public function getLabel(): string
    {
        return match ($this) {
            self::cdi => "CDI",
            self::cdd => "CDD",
            self::freelance => "Freelance",
            self::interim => "Interim",
        };
    }

}