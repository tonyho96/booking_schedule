@extends('adminlte::page')

@section('content')
<div class="row">

    <div class="col-md-12">
        @foreach($schedules as $schedules)    
        <div class="box">
            <div class="box-header">
            <h3 class="box-title">Schedule {{$schedules['id']}}</h3>
            </div>
            <div class="box-body">
                <a href="{{route('schedules-management.index')}}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                <a href="{{route('schedules-management.edit',['schedules_management}'=>$schedules['id']])}}" title="Edit Schedule"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                <br><br>

                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                        
                            <tr><th> Schedule ID</th><td>{{ $schedules['id']}}</td></tr>
                            <tr><th> Schedule Name </th><td>{{ $schedules['name']}}</td></tr>
                            <tr><th> Description </th><td>{{ $schedules['description']}}</td></tr>
                            <tr><th> Order </th><td>{{ $schedules['order_pos']}}</td></tr>

                            <tr><th> Resource </th><td> 
                                <?php
                                    $array_ten = array();
                                    $re_a = str_replace( '[', '', $schedules['resource_ids'] );
                                    $re_b = str_replace( ']', '', $re_a );
                                    $array_ten = explode(',',  $re_b);
                                    $i=0;
                                    foreach($array_ten as $key=>$value2){
                                        foreach($resources as $re){
                                            if($re['id']==$value2)
                                            echo $re['name']."; ";
                                        }
                                    }
                                ?>
                            
                            </td></tr>

                            <tr><th> Permission </th><td>
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
                                ?>
                            </td></tr>
                      
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
