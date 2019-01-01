<?php

namespace App\Services;


use App\Status;
use GuzzleHttp\Client;
use App\Services\CaspioService;
use DB;

class StatusService
{

    public static function getStatusTableRow($query= '')
    {
        return CaspioService::getTableRow(config('caspio.table.status'),$query);
    }

    public static function postToStatusTable($data = '')
    {
        return  CaspioService::postToTable(config('caspio.table.status'),$data);
    }

    public static function updateStatusTable($data = '',$query = '')
    {
        return CaspioService::updateToTable(config('caspio.table.status'),$data,$query);
    }

    public static function deleteStatusTableRow($query = '')
    {
        return CaspioService::deleteTableRow(config('caspio.table.status'),$query);
    }

	public static function create_sync($input) {
		DB::beginTransaction();

		try {
			$status = Status::create( [
				'id' => $input['id'],
				'name' => $input['name'],
				'color_background' => $input['color_background'],
				'color_text' => $input['color_text']
			] );

			DB::commit();

			return $status;
		} catch (\Exception $e) {
			DB::rollback();
			die($e->getMessage());
			return false;
		}
	}

	public static function update_sync($input, $status) {
		DB::beginTransaction();
		try {
			$statusData = [
				'name' => $input['name'],
				'color_background' => $input['color_background'],
				'color_text' => $input['color_text']
			];
			$status->update($statusData);
			DB::commit();
			return $status;
		} catch ( \Exception $e ) {
			DB::rollback();
			return false;
		}
	}


}
