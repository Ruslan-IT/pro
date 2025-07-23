<?php

namespace App\Services;

use App\Models\SuppliersTovars;

class SuppliersTovarsServices
{
    public static function store(array $data): SuppliersTovars
    {
        return SuppliersTovars::create($data);

    }

    public static function update(SuppliersTovars $tovars, array $data): SuppliersTovars
    {
        $tovars->update($data);
        return $tovars->fresh();

    }

}
