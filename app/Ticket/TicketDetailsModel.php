<?php

namespace App\Ticket;

class TicketDetailsModel
{

    public ?string $from_stoppage = null;
    public string $to_stoppage;
    public string $serial;
    public string $vehicle_no;
    public string $journey_date;
    public string $amount;
    public int $seller_id;
    public string $seller_type;
    public string $seller_name;
    public string $seller_mobile;
    public int $user_point = 0;
    public int $seller_point = 0;
    public int $company_id;
    public string $company_name;

    /**
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        throw new \Exception('Property "' . $name . '" does not exist');
    }

}
