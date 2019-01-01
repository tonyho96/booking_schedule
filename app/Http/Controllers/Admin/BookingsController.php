<?php

namespace App\Http\Controllers\Admin;

use App\Schedules;
use App\Services\SchedulesService;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

use App\Services\BookingsService;
use App\Booking;

use App\Services\ResourcesService;
use App\Resource;

use App\Services\ProjectsService;
use App\Project;

use App\Services\StatusService;
use App\Status;

use App\Services\BookingResources;

use Illuminate\Http\Request;
use Auth;

use DB;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $bookings = Booking::where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->orWhere('category', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $bookings = Booking::paginate($perPage);
        }

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.bookings.create');
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

        Booking::create($requestData);

        return redirect('admin/bookings')->with('flash_message', 'Booking added!');
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
        $booking = Booking::findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
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
        $booking = Booking::findOrFail($id);

        return view('admin.bookings.edit', compact('booking'));
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
        
        $booking = Booking::findOrFail($id);
        $booking->update($requestData);

        return redirect('admin/bookings')->with('flash_message', 'Booking updated!');
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
        Booking::destroy($id);

        return redirect('admin/bookings')->with('flash_message', 'Booking deleted!');
    }

    public function showSchedulesPage(){

        $current_user = Auth::user();
        // dd($current_user->role);
        $page = 1;
        $flag = true;
        $bookings = [];
        $bookings['Result'] = [];
        $date_get_booking = strtotime(date( 'Y-m-d H:i:s', strtotime( '- 6 MONTH' )));
        $bookingsquery = '"select":"*","where": "created >= '.$date_get_booking.'"';
        $tmp = BookingsService::getBookingsTableRow($bookingsquery);
        $bookings['Result'] = $tmp['Result'];
        //var_dump($bookings['Result']);
//        do {
//            $tmp = BookingsService::getBookingsTableRow('"pageSize":"1000", "pageNumber":"'. $page .'"');
//            if( empty( $tmp['Result'] ) ) {
//                $flag = false;
//                continue;
//            }
//
//            $bookings['Result'] = array_merge( $bookings['Result'], $tmp['Result'] );
//            $page++;
//        } while( $flag );

        $users = User::all();
//		schedule before change to mysql
//        $scheduleQuery = '"select":"*","orderby":"order_pos ASC"';
//        $schedules_a = SchedulesService::getSchedulesTableRow($scheduleQuery);
//        $schedules_a = $schedules_a['Result'];
//        //check permission and create new array pass condition
//        $schedules = [];
//        foreach($schedules_a as $key => $schedules_a){
//
//            $array_ten = array();
//            $re_a = str_replace( '[', '', $schedules_a['permission_ids'] );
//            $re_b = str_replace( ']', '', $re_a );
//            $array_ten = explode(',',  $re_b);
//
//            $check = in_array($current_user->role, $array_ten);
//            if($check && $schedules_a['permission_ids']!=''){
//                $schedules[] = ['id' => $schedules_a['id'],
//                                    'name' => $schedules_a['name'],
//                                    'description' => $schedules_a['description'],
//                                    'order_pos' => $schedules_a['order_pos'],
//                                    'resource_ids' => $schedules_a['resource_ids'],
//                                    'permission_ids' => $schedules_a['permission_ids'],
//                                    'created_at' => $schedules_a['created_at'],
//                                    'updated_at' => $schedules_a['updated_at']
//                                    ];
//            }
//
//        }
//
//		schedule after change to mysql
		$schedule_sqls = Schedules::orderBy('order_pos','ASC')->get();
		//check permission and create new array pass condition
		$schedules = [];
		foreach($schedule_sqls as $key => $schedule_sql){

			$array_ten = array();
			$re_a = str_replace( '[', '', $schedule_sql->permission_ids);
			$re_b = str_replace( ']', '', $re_a );
			$array_ten = explode(',',  $re_b);

			$check = in_array($current_user->role, $array_ten);
			if($check && $schedule_sql->permission_ids!=''){
				$schedules[] = ['id' => $schedule_sql->id,
					'name' => $schedule_sql->name,
					'description' => $schedule_sql->description,
					'order_pos' => $schedule_sql->order_pos,
					'resource_ids' => $schedule_sql->resource_ids,
					'permission_ids' => $schedule_sql->permission_ids,
					'created_at' => $schedule_sql->created_at,
					'updated_at' => $schedule_sql->updated_at
				];
			}

		}

        //Return no schedule available
        if (count($schedules) == 0){
            return view('admin.bookings.no-schedule-found');
        }

        //Check permissions
//        foreach ($schedules as $key => $schedule){
//            $permission_ids = json_decode($schedule['permission_ids']);
//            if (count($permission_ids) == 0){
//                continue;
//            }
//            if (array_search($current_user->role, $permission_ids) === false){
//                array_splice($schedules, $key, 1);
//            }
//        }

        //Get a schedule having smallest order_pos
        $scheduleSelectId = $schedules[0]['id'];
        if (isset($_GET['scheduleSelect']) && $_GET['scheduleSelect'] > 0){
            $scheduleSelectId = $_GET['scheduleSelect'];
        }

        foreach ($schedules as $schedule){
               if($scheduleSelectId == $schedule['id']){
                   $resource_ids = json_decode($schedule['resource_ids']);
               }
        }


//        $scheduleSelectedQuery = '"select":"*","where":"id=' . $scheduleSelectId . '","limit":"1"';
//        $scheduleSelect = SchedulesService::getSchedulesTableRow($scheduleSelectedQuery);
//        $scheduleSelect = $scheduleSelect["Result"][0];
//        $resource_ids = json_decode($scheduleSelect['resource_ids']);


        $whereCond = '';
        for ($i = 0; $i < count($resource_ids); $i++){
            if ($i == count($resource_ids) - 1){
                $whereCond .=  'id=' . $resource_ids[$i];
                continue;
            }
            $whereCond .=  'id=' . $resource_ids[$i]. 'or ';
        }
		$whereCond = str_replace( 'or', ' or', $whereCond);//bug id=1234or id=3213 -> error => fix with replace: id=1234 or id=3213

//         resource before change to mysql
//        $resourceQuery = '"select":"*","where":"'. $whereCond .'","orderby":"order_pos ASC"';
//        $resources = ResourcesService::getResourcesTableRow($resourceQuery);dd($resources);
//		resource after change to mysql
		$resources_mysqls = DB::select('SELECT * FROM resources WHERE '.$whereCond.' order by order_pos ASC');
		//change to array (because schedules view use array)
		$resources=[];
		$i=0;
		foreach ($resources_mysqls as $resources_mysqls){
			$resources['Result'][$i] = [
				'id'=>$resources_mysqls->id,
				'name'=>$resources_mysqls->name,
				'description'=>$resources_mysqls->description,
				'type_id'=>$resources_mysqls->type_id,
				'parent_id'=>$resources_mysqls->parent_id,
				'order_pos'=>$resources_mysqls->order_pos,
			];
			$i++;
		}


//		project before change to mysql
//        $projects = ProjectsService::getProjectsTableRow();dd($projects);
//
//		project after change to mysql
		$projects_mysqls = Project::get();
		$projects=[];//change to array (because schedules view use array)
		$i=0;
		foreach ($projects_mysqls as $projects_mysql)
		{
			$projects['Result'][$i] = [
				'id'=>$projects_mysql->id,
				'name'=>$projects_mysql->name,
				'code'=>$projects_mysql->code,
				'description'=>$projects_mysql->description,
				'status_id'=>$projects_mysql->status_id,
				'start_timestamp'=>$projects_mysql->start_timestamp,
				'end_timestamp'=>$projects_mysql->end_timestamp,
				'private'=>$projects_mysql->private,
				'parent_folder_id'=>$projects_mysql->parent_folder_id,
				'client_person_id'=>$projects_mysql->client_person_id,
				'client_organization_id'=>$projects_mysql->client_organization_id,
				'project_order'=>$projects_mysql->project_order,
				'color_background'=>$projects_mysql->color_background,
				'color_text'=>$projects_mysql->color_text,
				'created_id'=>$projects_mysql->created_id,
				'created'=>$projects_mysql->created,
				'updated_id'=>$projects_mysql->updated_id,
				'updated'=>$projects_mysql->updated,
			];
			$i++;
		}


//		before change status to mysql
//      $status = StatusService::getStatusTableRow();dd($status);
//		after change status to mysql
		$i=0;
		$status_mysqls = Status::get();
		$status =[];//change to array (because schedules view use array)
		foreach ($status_mysqls as $status_mysql){
			$status['Result'][$i] = [
				'id'=>$status_mysql->id,
				'name'=>$status_mysql->name,
				'color_background'=>$status_mysql->color_background,
				'color_text'=>$status_mysql->color_text
			];
			$i++;
		}


        $page = 1;
        $flag = true;
        $booking_resources_tmp = [];
        do {
            $tmp = BookingResources::getBookingResourcesTableRow('"pageSize":"1000", "pageNumber":"'. $page .'"');
            if( empty( $tmp['Result'] ) ) {
                $flag = false;
                continue;
            }

            $booking_resources_tmp = array_merge( $booking_resources_tmp, $tmp['Result'] );
            $page++;
        } while( $flag );

        $booking_resources = [];
        if( ! empty( $booking_resources_tmp ) ) {
            foreach ($booking_resources_tmp as $value) {
                $booking_resources[(string)$value['booking_id']][] = $value['resource_id']; 
            }
        }



        return view('admin.bookings.schedules', [
            'scheduleSelectId' => $scheduleSelectId,
            'schedules'         => $schedules,
            'bookings'          => $bookings,
            'resources'         => $resources,
            'projects'          => $projects,
            'status'            => $status,
            'booking_resources' => $booking_resources,
            'current_user'              => Auth::user()
        ]);
    }

    public function createSchedule(Request $request) {
        $requestData = $request->all();
        $requestData['start_timestamp'] = strtotime($requestData['start_date_time']);
        $requestData['end_timestamp'] = strtotime($requestData['end_date_time']);
        $requestData['client_personal_id'] = Auth::user()->id;

        $users = $requestData['users'];
        if( ! is_array($users) ) {
            $users = explode(',', $users);
        }
        unset($requestData["_token"]);
        unset($requestData["users"]);
        $query = '"select":"*","where":"id='. $requestData['id'] .'"';
        $booking = BookingsService::getBookingsTableRow($query);
        if( ! empty( $booking['Result'] ) ) {
            BookingsService::updateBookingsTable(json_encode($requestData), $query);
        } else {
            BookingsService::postToBookingsTable(json_encode($requestData));
        }

        $query = '"select":"*","where":"booking_id='. $requestData['id'] .'"';
        BookingResources::deleteBookingResourcesTableRow($query);
        if( ! empty( $users ) ) {
            foreach ($users as $user) {
                $data_tmp = [
                    'booking_id' => $requestData['id'],
                    'resource_id' => $user
                ];
                BookingResources::postToBookingResourcesTable(json_encode($data_tmp));
            }
        }

        return response()->json(1);
    }

    public function deleteSchedule( Request $request ) {
        $requestData = $request->all();
        $booking_id = isset( $requestData['id'] ) ? $requestData['id'] : 0;
        unset($requestData["_token"]);
        $query = '"select":"*","where":"id='. $booking_id .'"';
        BookingsService::deleteBookingsTableRow($query);
        $query = '"select":"*","where":"booking_id='. $booking_id .'"';
        BookingResources::deleteBookingResourcesTableRow($query);
        return response()->json(['message' => 'Booking Deleted!']);
    }
}
