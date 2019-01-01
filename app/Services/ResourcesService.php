<?php

namespace App\Services;


use App\Resource;
use GuzzleHttp\Client;
use App\Services\CaspioService;
use DB;

class ResourcesService
{

    public static function getResourcesTableRow($query= '')
    {
        return CaspioService::getTableRow(config('caspio.table.resources'),$query);
    }

    public static function postToResourcesTable($data = '')
    {
        return CaspioService::postToTable(config('caspio.table.resources'),$data);
    }

    public static function updateResourcesTable($data = '',$query = '')
    {
        return CaspioService::updateToTable(config('caspio.table.resources'),$data,$query);
    }

    public static function deleteResourcesTableRow($query = '')
    {
        return CaspioService::deleteTableRow(config('caspio.table.resources'),$query);
    }

	public static function create_sync($input) {
		DB::beginTransaction();

		try {
			$resource = Resource::create( [
				'id' => $input['id'],
				'name' => $input['name'],
				'description' => $input['description'],
				'type_id' => $input['type_id'],
				'parent_id' => $input['parent_id'],
				'order_pos' => $input['order_pos']
			] );

			DB::commit();

			return $resource;
		} catch (\Exception $e) {
			DB::rollback();
			die($e->getMessage());
			return false;
		}
	}

	public static function update_sync($input, $resource) {
		DB::beginTransaction();
		try {
			$resourceData = [
				'name' => $input['name'],
				'description' => $input['description'],
				'type_id' => $input['type_id'],
				'parent_id' => $input['parent_id'],
				'order_pos' => $input['order_pos']
			];
			$resource->update($resourceData);
			DB::commit();
			return $resource;
		} catch ( \Exception $e ) {
			DB::rollback();
			return false;
		}
	}

}
