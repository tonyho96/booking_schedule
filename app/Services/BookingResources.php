<?php

namespace App\Services;


use GuzzleHttp\Client;
use App\Services\CaspioService;

class BookingResources
{

    public static function getBookingResourcesTableRow($query= '')
    {
        return CaspioService::getTableRow(config('caspio.table.booking_resources'),$query);
    }

    public static function postToBookingResourcesTable($data = '')
    {
        return  CaspioService::postToTable(config('caspio.table.booking_resources'),$data);
    }

    public static function updateBookingResourcesTable($data = '',$query = '')
    {
        return CaspioService::updateToTable(config('caspio.table.booking_resources'),$data,$query);
    }

    public static function deleteBookingResourcesTableRow($query = '')
    {
        return CaspioService::deleteTableRow(config('caspio.table.booking_resources'),$query);
    }

}
