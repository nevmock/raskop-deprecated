<?php

namespace App\Filament\Resources\PendingReservasiResource\Pages;

use App\Filament\Resources\PendingReservasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendingReservasis extends ListRecords
{
    protected static string $resource = PendingReservasiResource::class;
    protected static ?string $title = 'Pending Reservasi List';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
