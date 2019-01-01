<?php

namespace App\Services;


use App\Booking;
use GuzzleHttp\Client;
use App\Services\CaspioService;

class BookingsService
{

    public static function getBookingsTableRow($query= '')
    {
        return CaspioService::getTableRow(config('caspio.table.bookings'),$query);
    }

    public static function postToBookingsTable($data = '')
    {
        return CaspioService::postToTable(config('caspio.table.bookings'),$data);
    }

    public static function updateBookingsTable($data = '',$query = '')
    {
        return CaspioService::updateToTable(config('caspio.table.bookings'),$data,$query);
    }

    public static function deleteBookingsTableRow($query = '')
    {
        return CaspioService::deleteTableRow(config('caspio.table.bookings'),$query);
    }



}
