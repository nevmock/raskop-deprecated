<?php

namespace App\Filament\Resources\PendingReservasiResource\Pages;

use App\Filament\Resources\PendingReservasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendingReservasi extends EditRecord
{
    protected static string $resource = PendingReservasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
