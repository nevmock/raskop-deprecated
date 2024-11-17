<?php

namespace App\Filament\Resources\ReservasiResource\Pages;

use App\Filament\Resources\ReservasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReservasis extends ListRecords
{
    protected static string $resource = ReservasiResource::class;
    protected static ?string $title = 'Reservasi List';
    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
