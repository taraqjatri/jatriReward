<?php
namespace App\Ticket;

use App\Enum\ProductListEnum;

class FindTicket{
    public function getDetails(string $pnr) : TicketDetailsModel | false
    {
        $product_name = ProductListEnum::tryFrom(getDetailsFromAPNR($pnr)['product_code'])?->name;
        return match ($product_name) {
            ProductListEnum::INTRACITY_COUNTER_WISE->name => (new GetIntracityCounterServiceTicket($pnr))->find(),
            default => false,
        };
    }
}
