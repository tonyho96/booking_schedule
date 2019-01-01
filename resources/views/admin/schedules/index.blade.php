@extends('adminlte::page')

@section('content')

        <div class="row">
            @if (Session::has('flash_message'))
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <p><i class="icon fa fa-check"></i>{{Session::get('flash_message')}}</p>
                </div>
            @endif
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Schedules Management</h3>
                        
                        <a href="{{route('schedules-management.create')}}" class="btn btn-success btn-sm" title="Add New Schedule">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                        
                        <div class="box-tools">
                            {!! Form::open(['method' => 'GET', 'url' => '', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                    <div class="box-body">


                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Schedule Name</th>
                                        <th>Order </th>
                                        <th>Resource</th>
                                        <th>Permission</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($schedules as $schedules)
                                    <tr>
                                    <td>{{ $schedules['id']}}</td>
                                        <td>{{ $schedules['name']}}</td>
                                        <td>{{ $schedules['order_pos']}}</td>
                                        <td>
                                            <?php
                                            $array_ten = array();
                                            $re_a = str_replace( '[', '', $schedules['resource_ids'] );
                                            $re_b = str_replace( ']', '', $re_a );
                                            $array_ten = explode(',',  $re_b);
                                            
                                            $i=0;
                                            foreach($array_ten as $key=>$value2){
                                                foreach($resources as $re){
                                                    if($re['id']==$value2){
                                                        echo $re['name']."; ";
                                                    }
                                                    
                                                }
                                                $i++;
                                                if($i%3==0){echo "<br>";}
                                            }
                                            ?>
                                        </td>
                                        <td>
                                        <?php
                                            $array_ten = array();
                                            $re_a = str_replace( '[', '', $schedules['permission_ids'] );
                                            $re_b = str_replace( ']', '', $re_a );
                                            $array_ten = explode(',',  $re_b);
                                            foreach($array_ten as $key=>$value2){
                                                if($value2=='0'){echo "Admin; ";}
                                                if($value2=='1'){echo "Driver; ";}
                                                if($value2=='2'){echo "Bmanager; ";}
                                            }
                                        ?></td>
                         
                                        <td>
                                            <a href="{{route('schedules-management.show',['schedules_management}'=>$schedules['id']])}}" title="View Schedule"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{route('schedules-management.edit',['schedules_management}'=>$schedules['id']])}}" title="Edit Schedule"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{route('schedules-management.destroy',['schedules_management}'=>$schedules['id']])}}" accept-charset="UTF-8" style="display:inline">
                                                <input name="_method" type="hidden" value="DELETE">
                                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Schedule" onclick="return confirm(&quot;Confirm delete?&quot;)">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                </button>
                                            </form>
                                           
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper">  </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection
