<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\SyncService;
use GuzzleHttp\Client;
use App\Services\SchedulesService;
use App\Services\ResourcesService;
use App\Resource;
use Illuminate\Http\Request;

class SchedulesServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$query = '"select":"*","where":"id=' . $id . '"';
        $data = SchedulesService::getSchedulesTableRow();
        $schedules = $data["Result"];
        $data_resource = ResourcesService::getResourcesTableRow();
        $resources = $data_resource["Result"];
        return view('admin.schedules.index',compact('schedules','resources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ResourcesService::getResourcesTableRow();
        $resource = $data["Result"];
        return view('admin.schedules.create', compact('resource'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        //get all tag_list[]
        if(isset($requestData['tag_list'])){
            $r = $requestData['tag_list'];
            $resources_ids_string  = '';
            $i=0;
            //convert tag_list to string
            foreach($r as $val){
                if($i==0){
                    $resources_ids_string = $resources_ids_string."".$val;
                    $i++;
                }
                else{
                    $resources_ids_string = $resources_ids_string.",".$val;
                }
                
            }
            $resources_ids =  "[".$resources_ids_string."]";
            $requestData['resource_ids'] = $resources_ids;
        }
            
        //check input and set permission string to save database
        $admin='';
        $driver='';
        $bmanager='';
        if(isset($requestData["admin"]))
        {
            $admin = $requestData["admin"];
        }
        if(isset($requestData["driver"]))
        {
            $driver = $requestData["driver"];
        }
        if(isset($requestData["bmanager"]))
        {
            $bmanager = $requestData["bmanager"];
        }
        $list_per = SchedulesService::checkPermission($admin,$driver,$bmanager);
        if($list_per==NULL)
        {
            $requestData['permission_ids'] ='';
        }
        else{$requestData['permission_ids'] = "[".$list_per."]";}

        unset($requestData["tag_list"]);
        unset($requestData["_token"]);
        unset($requestData["admin"]);
        unset($requestData["driver"]);
        unset($requestData["bmanager"]);
       
        $requestData['created_at'] = SchedulesService::currentTime();
        $requestData['updated_at'] = SchedulesService::currentTime();
        $requestData = json_encode($requestData);
        SchedulesService::postToSchedulesTable($requestData);
        SyncService::SyncSchedulesTable();
        return redirect('admin/schedules-management')->with('flash_message', 'Schedule added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = '"select":"*","where":"id=' . $id . '"';
        $data = SchedulesService::getSchedulesTableRow($query);
        $schedules = $data["Result"];
        $data_resource = ResourcesService::getResourcesTableRow();
        $resources = $data_resource["Result"];
        return view('admin.schedules.show',compact('schedules','resources'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $query = '"select":"*","where":"id=' . $id . '"';
        $data = SchedulesService::getSchedulesTableRow($query);
        $schedule = $data["Result"];
        $data_resource = ResourcesService::getResourcesTableRow();
        $resources = $data_resource["Result"];

        return view('admin.schedules.edit', compact('schedule','formatted_tags','resources'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $query = '"select":"*","where":"id=' . $id . '"';

         //get all tag_list[]
        if(isset($requestData['tag_list'])){
            $r = $requestData['tag_list'];
            $resources_ids_string  = '';
            $i=0;
            //convert tag_list to string
            foreach($r as $val){
                if($i==0){
                    $resources_ids_string = $resources_ids_string."".$val;
                    $i++;
                }
                else{
                    $resources_ids_string = $resources_ids_string.",".$val;
                }
                
            }
            $resources_ids =  "[".$resources_ids_string."]";
            $requestData['resource_ids'] = $resources_ids;
            
        }
        
        //check input and set permission string to save database
        $admin='';
        $driver='';
        $bmanager='';
        if(isset($requestData["admin"]))
        {
            $admin = $requestData["admin"];
        }
        if(isset($requestData["driver"]))
        {
            $driver = $requestData["driver"];
        }
        if(isset($requestData["bmanager"]))
        {
            $bmanager = $requestData["bmanager"];
        }
        $list_per = SchedulesService::checkPermission($admin,$driver,$bmanager);
        if($list_per==NULL)
        {
            $requestData['permission_ids'] ='';
        }
        else{$requestData['permission_ids'] = "[".$list_per."]";}

        unset($requestData["tag_list"]);
        unset($requestData["_token"]);
        unset($requestData["admin"]);
        unset($requestData["driver"]);
        unset($requestData["bmanager"]);
        unset($requestData["_method"]);
  
        $requestData['updated_at'] = SchedulesService::currentTime();
        //dd($requestData);
        $requestData = json_encode($requestData);
        SchedulesService::updateSchedulesTable($requestData, $query);
        SyncService::SyncSchedulesTable();
        return redirect('admin/schedules-management')->with('flash_message', 'Schedule updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = '"select":"*","where":"id=' . $id . '"';
        SchedulesService::deleteSchedulesTableRow($query);
        return redirect('admin/schedules-management')->with('flash_message', 'Schedule deleted!');
    }
}
