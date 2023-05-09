<?php

namespace App\Models\IntracityCounterService;


class IntraCityVehicle extends BaseModel
{
    public function company(){
        return $this->belongsTo(IntraCityCompany::class);
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
