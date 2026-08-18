<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum OpportunityStage: int implements HasLabel, HasColor
{
    case NuevoProspecto = 1;
    case Diagnostico = 2;
    case Presentacion = 3;
    case Propuesta = 4;
    case Negociacion = 5;
    case Aprobacion = 6;
    case Cobranza = 7;
    case ClienteActivo = 8;
    case Renovacion = 9;
    case Referidos = 10;

    public function getLabel(): string
    {
        return match ($this) {
            self::NuevoProspecto => 'Nuevo Prospecto',
            self::Diagnostico => 'Diagnostico',
            self::Presentacion => 'Presentacion',
            self::Propuesta => 'Propuesta',
            self::Negociacion => 'Negociacion',
            self::Aprobacion => 'Aprobacion',
            self::Cobranza => 'Cobranza',
            self::ClienteActivo => 'Cliente Activo',
            self::Renovacion => 'Renovacion',
            self::Referidos => 'Referidos',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::NuevoProspecto => 'gray',
            self::Diagnostico => 'info',
            self::Presentacion => 'info',
            self::Propuesta => 'warning',
            self::Negociacion => 'warning',
            self::Aprobacion => 'warning',
            self::Cobranza => 'warning',
            self::ClienteActivo => 'success',
            self::Renovacion => 'success',
            self::Referidos => 'success',
        };
    }
}