<?php

namespace App\Models\IntracityCounterService;


class IntraCityCounterBooking extends BaseModel
{
    protected $guarded = [ 'id' ];

    public function vehicle(){
        return $this->belongsTo(IntraCityVehicle::class);
    }

    public function counterman(){
        return $this->belongsTo(IntraCityCounterman::class);
    }
    public function company(){
        return $this->belongsTo(IntraCityCompany::class);
    }
    public function scopeSearch($query, $counter_man_id, $ticket_serial)
    {
        $hours_to_seconds = config('app.pnr_query_time_in_hour') * 60 *60 ;
        $pnr_allowed_timestamp =  date( 'Y-m-d H:i:s',strtotime('now')- $hours_to_seconds);
        return $query->where([['serial', $ticket_serial], ['counterman_id', $counter_man_id]])
//            ->where('created_at', '>=', $pnr_allowed_timestamp)
            ->with(['counterman' => function ($q) {
                $q->select('id', 'name', 'phone', 'type', 'company_id', 'stoppage_id',);
            },
                'vehicle' => function ($q) {
                    $q->select('id', 'number', 'type', 'type', 'company_id');
                },
                'company' => function ($q) {
                    $q->select('id', 'name', 'model', 'reward_service_config');
                }
            ]);
    }
}
