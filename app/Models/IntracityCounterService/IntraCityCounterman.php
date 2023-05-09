<?php

namespace App\Models\IntracityCounterService;

class IntraCityCounterman extends BaseModel
{
    protected $guarded  = [ 'id' ];
    protected $hidden   = [ 'password' ];

    public function company(){
        return $this->belongsTo(IntraCityCompany::class);
    }
    public function stoppage(){
        return $this->belongsTo(IntraCityStoppage::class);
    }
    public function vehicle(){
        return $this->belongsTo(IntraCityVehicle::class);
    }
}
