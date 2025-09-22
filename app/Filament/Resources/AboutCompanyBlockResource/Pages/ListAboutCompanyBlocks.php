<?php

namespace App\Filament\Resources\AboutCompanyBlockResource\Pages;

use App\Filament\Resources\AboutCompanyBlockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutCompanyBlocks extends ListRecords
{
    protected static string $resource = AboutCompanyBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
