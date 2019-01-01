<?php
/**
 * Created by PhpStorm.
 * Date: 8/4/18
 * Time: 2:57 AM
 */

namespace App\Services;
use App\Resource;
use App\Schedules;
use App\Status;
use App\Project;
class SyncService
{
    public static function SyncResourcesTable(){
        //sync resources
        $data_resources = ResourcesService::getResourcesTableRow();
        $resources = $data_resources["Result"];
        foreach ($resources as $resource){
            $resource_local = Resource::where('id','=',$resource['id'])->first();
            if(isset($resource_local)){//update again
                ResourcesService::update_sync($resource,$resource_local);
            }
            else{//add new
                ResourcesService::create_sync($resource);
            }
        }
    }

    public static function SyncSchedulesTable(){
        //sync schedules
        $data_schedules = SchedulesService::getSchedulesTableRow();
        $schedules = $data_schedules["Result"];
        foreach ($schedules as $schedule){
            $schedule_local = Schedules::where('id','=',$schedule['id'])->first();
            if(isset($schedule_local)){//update again
                SchedulesService::update_sync($schedule,$schedule_local);
            }
            else{//add new
                SchedulesService::create_sync($schedule);
            }
        }
    }

    public static function SyncStatusTable(){
        //sync statuses
        $data_statuses = StatusService::getStatusTableRow();
        $statuses = $data_statuses["Result"];
        foreach ($statuses as $status){
            $status_local = Status::where('id','=',$status['id'])->first();
            if(isset($status_local)){//update again
                StatusService::update_sync($status,$status_local);
            }
            else{//add new
                StatusService::create_sync($status);
            }
        }
    }

    public static function SyncProjectsTable(){
        //sync projects
        $data_projects = ProjectsService::getProjectsTableRow();
        $projects = $data_projects["Result"];
        foreach ($projects as $project){
            $project_local = Project::where('id','=',$project['id'])->first();
            if(isset($project_local)){//update again
                if($project['private']==TRUE){
                    $project['private']='Yes';
                }
                else
                {
                    $project['private']='No';
                }
                ProjectsService::update_sync($project,$project_local);
            }
            else{//add new
                if($project['private']==TRUE){
                    $project['private']='Yes';
                }
                else
                {
                    $project['private']='No';
                }
                ProjectsService::create_sync($project);
            }
        }
    }
}