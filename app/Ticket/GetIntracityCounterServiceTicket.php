<?php

namespace App\Ticket;

use App\Constants\SellerType;
use App\Models\IntracityCounterService\IntraCityCounterBooking;

class GetIntracityCounterServiceTicket implements FindTicketInterface
{

    protected int $counter_man_id;
    protected int $ticket_serial;

    public function __construct($pnr)
    {
        $pnr_details = getDetailsFromAPNR($pnr);
        $this->counter_man_id = $pnr_details['counter_man_id'];
        $this->ticket_serial = $pnr_details['ticket_serial'];
    }

    public function find(): TicketDetailsModel|false
    {
        $ticketDetailsModel = new  TicketDetailsModel();
        $find_ticket = IntraCityCounterBooking::query()
            ->Search(ticket_serial: $this->ticket_serial, counter_man_id: $this->counter_man_id)
            ->orderBy('created_at', 'desc')
            ->first();
        if ($find_ticket) {
            $ticketDetailsModel->seller_id      = $find_ticket->counterman_id;
            $ticketDetailsModel->company_id     = $find_ticket->company_id;
            $ticketDetailsModel->from_stoppage  = $find_ticket->from_stoppage;
            $ticketDetailsModel->to_stoppage    = $find_ticket->to_stoppage;
            $ticketDetailsModel->serial         = $find_ticket->serial;
            $ticketDetailsModel->amount = $find_ticket->amount;
            if ($find_ticket->vehicle) {
                $ticketDetailsModel->vehicle_no = $find_ticket->vehicle->number;
            }
            $ticketDetailsModel->journey_date = $find_ticket->created_at;
            if ($find_ticket->company) {
                $ticketDetailsModel->company_name = $find_ticket->company->name;
            }
            if ($find_ticket->counterman) {
                if ($find_ticket->counterman->type == 'COUNTER') $ticketDetailsModel->seller_type = SellerType::COUNTER_MAN;
                else if ($find_ticket->counterman->type == 'CHECKER') $ticketDetailsModel->seller_type = SellerType::CHECKER;

                $ticketDetailsModel->seller_name = $find_ticket->counterman->name;
                $ticketDetailsModel->seller_mobile = $find_ticket->counterman->phone;
            }
            if ($reward_service_config = json_decode($find_ticket->company->reward_service_config)) {
                if ($reward_service_config->is_enabled) {
                    $point = $reward_service_config->rewarad_points;
                    $ticketDetailsModel->user_point = $point->user_point;
                    if ($find_ticket->counterman?->type == "COUNTER") $ticketDetailsModel->seller_point = $point->counter_point;
                    else $ticketDetailsModel->seller_point = $point->checker_point;
                }
            }
            return $ticketDetailsModel;
        }
        return false;

    }

}
