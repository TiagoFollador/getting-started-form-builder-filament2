<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class Mostrar extends ViewRecord
{
    protected static string $view = PatientResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('mostrar.index');
    }
}
