<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\SyncService;
use GuzzleHttp\Client;
use App\Project;
use App\Services\ProjectsService;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = ProjectsService::getProjectsTableRow();
        $projects = $data["Result"];		

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = ProjectsService::getProjectsTableRow();
        $projects = $data["Result"];

        // Find Max ID
        $max = $project_id = 0;
        foreach ($projects as $project) {
            if ( $project['id'] > $max )
                $max = $project['id'];
        }
        $project_id = $max + 1;

        return view('admin.projects.create', compact( 'project_id' ));
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
        ProjectsService::postToProjectsTable($requestData);
        SyncService::SyncProjectsTable();
        return redirect('admin/projects')->with('flash_message', 'Project added!');
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
        $data = ProjectsService::getProjectsTableRow($query);
        $project = $data["Result"][0];
        return view('admin.projects.show', compact('project'));
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
        $data = ProjectsService::getProjectsTableRow($query);
        $project = $data["Result"][0];
        SyncService::SyncProjectsTable();
        return view('admin.projects.edit', compact('project'));
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
        ProjectsService::updateProjectsTable($requestData, $query);

        return redirect('admin/projects')->with('flash_message', 'Project updated!');
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
        ProjectsService::deleteProjectsTableRow($query);

        return redirect('admin/projects')->with('flash_message', 'Project deleted!');
    }
}
