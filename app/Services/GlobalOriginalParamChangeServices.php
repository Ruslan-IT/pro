<?php

namespace App\Services;

use App\Models\GlobalOriginalParamChange;

class GlobalOriginalParamChangeServices
{
    public static function store(array $data): GlobalOriginalParamChange
    {
        return GlobalOriginalParamChange::create($data);

    }

    public static function update(GlobalOriginalParamChange $globalOriginalParamChanges, array $data): GlobalOriginalParamChange
    {
        $globalOriginalParamChanges->update($data);
        return $globalOriginalParamChanges->fresh();

    }
}
