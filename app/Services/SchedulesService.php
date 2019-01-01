<?php

namespace App\Services;


use App\Schedules;
use GuzzleHttp\Client;
use App\Services\CaspioService;
use DB;
class SchedulesService
{

    public static function getSchedulesTableRow($query= '')
    {
        return CaspioService::getTableRow(config('caspio.table.schedules'),$query);
    }

    public static function postToSchedulesTable($data = '')
    {
        return CaspioService::postToTable(config('caspio.table.schedules'),$data);
    }

    public static function updateSchedulesTable($data = '',$query = '')
    {
        return CaspioService::updateToTable(config('caspio.table.schedules'),$data,$query);
    }

    public static function deleteSchedulesTableRow($query = '')
    {
        return CaspioService::deleteTableRow(config('caspio.table.schedules'),$query);
    }

    public static function checkPermission($admin,$driver,$bmanager)
    {
        if($admin!='' && $driver!='' && $bmanager!='')
        {
            $list_per = $admin.",".$driver.",".$bmanager;
        }

        if($admin!='' && $driver!='' && $bmanager=='')
        {
            $list_per = $admin.",".$driver;
        }

        if($admin!='' && $driver=='' && $bmanager!='')
        {
            $list_per = $admin.",".$bmanager;
        }

        if($admin=='' && $driver!='' && $bmanager!='')
        {
            $list_per = $driver.",".$bmanager;
        }
        if($admin!='' && $driver=='' && $bmanager=='')
        {
            $list_per = $admin;
        }
        if($admin=='' && $driver!='' && $bmanager=='')
        {
            $list_per = $driver;
        }
        if($admin=='' && $driver=='' && $bmanager!='')
        {
            $list_per = $bmanager;
        }
        if($admin=='' && $driver=='' && $bmanager=='')
        {
            $list_per = NULL;
        }
        return $list_per;
    }

    public static function currentTime()
    {
        $format = "%H:%M:%S %d-%B-%Y";
        $timestamp = time();
        $strTime = strftime($format, $timestamp );
        return  $strTime;
    }

	public static function create_sync($input) {
		DB::beginTransaction();
		try {
			$schedule = Schedules::create( [
				'id' => $input['id'],
				'name' => $input['name'],
				'description' => $input['description'],
				'order_pos' => $input['order_pos'],
				'resource_ids' => $input['resource_ids'],
				'permission_ids' => $input['permission_ids'],
				'created_at' => $input['created_at'],
				'updated_at' => $input['updated_at'],
			] );

			DB::commit();

			return $schedule;
		} catch (\Exception $e) {
			DB::rollback();
			die($e->getMessage());
			return false;
		}
	}

	public static function update_sync($input, $schedule) {
		DB::beginTransaction();
		try {
			$scheduleData = [
				'name' => $input['name'],
				'description' => $input['description'],
				'order_pos' => $input['order_pos'],
				'resource_ids' => $input['resource_ids'],
				'permission_ids' => $input['permission_ids'],
				'created_at' => $input['created_at'],
				'updated_at' => $input['updated_at'],
			];
			$schedule->update($scheduleData);
			DB::commit();
			return $schedule;
		} catch ( \Exception $e ) {
			DB::rollback();
			return false;
		}
	}

}
