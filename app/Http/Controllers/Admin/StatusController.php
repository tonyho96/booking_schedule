<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\SyncService;
use GuzzleHttp\Client;
use App\Services\StatusService;
use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = StatusService::getStatusTableRow();
        $status = $data["Result"];


//        $keyword = $request->get('search');
//        $perPage = 25;
//
//        if (!empty($keyword)) {
//            $status = Status::where('title', 'LIKE', "%$keyword%")
//                ->orWhere('content', 'LIKE', "%$keyword%")
//                ->orWhere('category', 'LIKE', "%$keyword%")
//                ->paginate($perPage);
//        } else {
//            $status = Status::paginate($perPage);
//        }

        return view('admin.status.index', compact('status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.status.create');
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
        StatusService::postToStatusTable($requestData);
//        Status::create($requestData);
        SyncService::SyncStatusTable();
        return redirect('admin/status')->with('flash_message', 'Status added!');
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
        $data = StatusService::getStatusTableRow($query);
        $status = $data["Result"][0];

        return view('admin.status.show', compact('status'));
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
        $query = '"select":"*","where":"id=' . $id . '"';
        $data = StatusService::getStatusTableRow($query);
        $status = $data["Result"][0];
        SyncService::SyncStatusTable();
        return view('admin.status.edit', compact('status'));
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
        $checkUpdate = StatusService::updateStatusTable($requestData, $query);
//		dd($x['RowsAffected']);
		if($checkUpdate['RowsAffected']==1){//sync only update has success
			SyncService::SyncStatusTable();
		}
        return redirect('admin/status')->with('flash_message', 'Status updated!');
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
        $query = '"select":"*","where":"id=' . $id . '"';
        StatusService::deleteStatusTableRow($query);

        return redirect('admin/status')->with('flash_message', 'Status deleted!');
    }
}
