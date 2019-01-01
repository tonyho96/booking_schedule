<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\SyncService;
use GuzzleHttp\Client;
use App\Services\ResourcesService;
use App\Resource;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = ResourcesService::getResourcesTableRow();
        $resources = $data["Result"];

//        $keyword = $request->get('search');
//        $perPage = 25;
//
//        if (!empty($keyword)) {
//            $resources = Resource::where('id', 'LIKE', "%$keyword%")
//                ->orWhere('name', 'LIKE', "%$keyword%")
//                ->orWhere('description', 'LIKE', "%$keyword%")
//                ->orWhere('type_id', 'LIKE', "%$keyword%")
//                ->orWhere('parent_id', 'LIKE', "%$keyword%")
//                ->paginate($perPage);
//        } else {
//            $resources = Resource::paginate($perPage);
//        }

        $index = 1;
        foreach ($resources as $resource){
            if ($resource['order_pos'] == 0){
                $data = ['order_pos' => $index];
                $query = '"select":"*","where":"id=' . $resource['id'] . '"';
                $data = json_encode($data);
                ResourcesService::updateResourcesTable($data, $query);
            }
            $index++;
        }

        usort($resources, function($a, $b){
            return $a['order_pos'] >  $b['order_pos'];
        });
//        dd($resources);

        return view('admin.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.resources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        unset($requestData["_token"]);
        $requestData = json_encode($requestData);
        ResourcesService::postToResourcesTable($requestData);
        SyncService::SyncResourcesTable();
        return redirect('admin/resources')->with('flash_message', 'Resource added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $query = '"select":"*","where":"id=' . $id . '"';
        $data = ResourcesService::getResourcesTableRow($query);
        $resource = $data["Result"][0];
        //$resource = Resource::findOrFail($id);

        return view('admin.resources.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        //$resource = Resource::findOrFail($id);
        $query = '"select":"*","where":"id=' . $id . '"';
        $data = ResourcesService::getResourcesTableRow($query);
        $resource = $data["Result"][0];
        SyncService::SyncResourcesTable();
        return view('admin.resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        $query = '"select":"*","where":"id=' . $id . '"';
        unset($requestData["_token"]);
        unset($requestData["_method"]);
        $requestData = json_encode($requestData);
        ResourcesService::updateResourcesTable($requestData, $query);
//        $resource = Resource::findOrFail($id);
//        $resource->update($requestData);

        return redirect('admin/resources')->with('flash_message', 'Resource updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        //Resource::destroy($id);
        $query = '"select":"*","where":"id=' . $id . '"';
        ResourcesService::deleteResourcesTableRow($query);
        return redirect('admin/resources')->with('flash_message', 'Resource deleted!');
    }

    public function storeOrder(Request $request){
        $requestData = json_decode($request->getContent(), true);
        $queryFrom = '"select":"*","where":"order_pos=' . $requestData['from'] . '"';

        $queryTo = '"select":"*","where":"order_pos=' . $requestData['to'] . '"';

        $queryTemp = '"select":"*","where":"order_pos=' . -1 . '"';

        //set "to" to -1
        $inputTemp = json_encode([
            'order_pos' => -1
        ]);
        //set "from" to from
        $inputFrom = json_encode([
            'order_pos' => $requestData['to']
        ]);

        //Set "to" where == -1 to "to"
        $inputTo = json_encode([
            'order_pos' => $requestData['from']
        ]);

        ResourcesService::updateResourcesTable($inputTemp, $queryTo);
        ResourcesService::updateResourcesTable($inputFrom, $queryFrom);
        ResourcesService::updateResourcesTable($inputTo, $queryTemp);

        echo json_encode(['data' => $requestData]);
        die;
    }

    // public function findResourcesSelect2(Request $request){

    //     $key = strtolower(trim($request->q));

    //     if (empty($key)) {
    //         return \Response::json([]);
    //     }
   
    //     $data = ResourcesService::getResourcesTableRow();
    //     $resource = $data["Result"];
    //    // dd($resource);
    //     $formatted_tags = [];
    //     //load all tu server caspio, sau do filter bang php va tra ve ket qua
    //     // foreach ($resource as  $value) {
    //     //     if(strstr(strtolower($value['name']),$key)){
    //     //         //  echo "key is : ".$key." ";
    //     //         //  echo " name is:". $value['name']."<br>";
    //     //         $formatted_tags[] = ['id' => $value['id'], 'text' => $value['name']];
    //     //     }
                
    //     // }
       
    //     return \Response::json($formatted_tags);

    // }

}
