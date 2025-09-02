<?php

namespace App\Filament\Resources\PaymentDeliveryResource\Pages;

use App\Filament\Resources\PaymentDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentDeliveries extends ListRecords
{
    protected static string $resource = PaymentDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
