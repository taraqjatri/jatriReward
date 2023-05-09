<?php
namespace  App\Ticket;

interface FindTicketInterface{

    public function find():TicketDetailsModel|false;
}
