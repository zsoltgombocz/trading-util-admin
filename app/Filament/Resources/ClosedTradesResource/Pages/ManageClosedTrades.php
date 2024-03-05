<?php

namespace App\Filament\Resources\ClosedTradesResource\Pages;

use App\Filament\Resources\ClosedTradesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClosedTrades extends ManageRecords
{
    protected static string $resource = ClosedTradesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
