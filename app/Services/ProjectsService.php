<?php

namespace App\Services;


use App\Project;
use GuzzleHttp\Client;
use App\Services\CaspioService;
use DB;
class ProjectsService
{

    public static function getProjectsTableRow($query= '')
    {
        return CaspioService::getTableRow(config('caspio.table.projects'),$query);
    }

    public static function postToProjectsTable($data = '')
    {
        return CaspioService::postToTable(config('caspio.table.projects'),$data);
    }

    public static function updateProjectsTable($data = '',$query = '')
    {
        return CaspioService::updateToTable(config('caspio.table.projects'),$data,$query);
    }

    public static function deleteProjectsTableRow($query = '')
    {
        return CaspioService::deleteTableRow(config('caspio.table.projects'),$query);
    }

	public static function create_sync($input) {
		DB::beginTransaction();

		try {
			$project = Project::create( [
				'id' => $input['id'],
				'name' => $input['name'],
				'code' => $input['code'],
				'description' => $input['description'],
				'status_id' => $input['status_id'],
				'start_timestamp' => $input['start_timestamp'],
				'end_timestamp' => $input['end_timestamp'],
				'private' => $input['private'],
				'parent_folder_id' => $input['parent_folder_id'],
				'client_person_id' => $input['client_person_id'],
				'client_organization_id' => $input['client_organization_id'],
				'project_order' => $input['project_order'],
				'color_background' => $input['color_background'],
				'color_text' => $input['color_text'],
				'created_id' => $input['created_id'],
				'created' => $input['created'],
				'updated_id' => $input['updated_id'],
				'updated' => $input['updated']
			] );

			DB::commit();

			return $project;
		} catch (\Exception $e) {
			DB::rollback();
			die($e->getMessage());
			return false;
		}
	}

	public static function update_sync($input, $project) {
		DB::beginTransaction();
		try {
			$projectData = [
				'name' => $input['name'],
				'code' => $input['code'],
				'description' => $input['description'],
				'status_id' => $input['status_id'],
				'start_timestamp' => $input['start_timestamp'],
				'end_timestamp' => $input['end_timestamp'],
				'private' => $input['private'],
				'parent_folder_id' => $input['parent_folder_id'],
				'client_person_id' => $input['client_person_id'],
				'client_organization_id' => $input['client_organization_id'],
				'project_order' => $input['project_order'],
				'color_background' => $input['color_background'],
				'color_text' => $input['color_text'],
				'created_id' => $input['created_id'],
				'created' => $input['created'],
				'updated_id' => $input['updated_id'],
				'updated' => $input['updated']
			];
			$project->update($projectData);
			DB::commit();
			return $project;
		} catch ( \Exception $e ) {
			DB::rollback();
			return false;
		}
	}


}
