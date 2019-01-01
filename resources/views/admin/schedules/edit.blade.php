@extends('adminlte::page')

@section('content')
@section('css')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"> --}}

<link rel="stylesheet" href="<?php echo asset('js/select2.min.js')?>" type="text/css"> 
<style>
    .permisson{
        float: left;
        padding-right: 5px;
    }
    .li {
        color: black;
    }
    
</style>
@stop
<div class="row">
    @foreach ($schedule as $schedule)
   
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
            <h3 class="box-title">Edit Schedule {{$schedule['id']}}</h3>
            </div>
            <div class="box-body">
                <a href="{{route('schedules-management.index')}}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                <br>
                <br>
            {!! Form::open(['method' => 'PUT','class' => 'form-horizontal','files' => true, 'action' => ['Admin\\SchedulesServiceController@update','schedules_management'=>$schedule['id'] ]]) !!}
           
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
               
                <div class="form-group ">
                    <label for="schedulename" class="col-md-4 control-label">Schedule Name</label>
                    <div class="col-md-6">
                        <input class="form-control" name="name" type="text" value="{{$schedule['name']}}">
                    </div>
                </div>

                <div class="form-group ">
                    <label for="description " class="col-md-4 control-label">Description</label>
                    <div class="col-md-6">
                        <input class="form-control" name="description" type="text" value="{{$schedule['description']}}">
                    </div>
                </div>

                <div class="form-group ">
                    <label for="order" class="col-md-4 control-label">Order</label>
                    <div class="col-md-6">
                        <input class="form-control" name="order_pos" type="number" value="{{$schedule['order_pos']}}">
                    </div>
                </div>

                <div class="form-group ">
                    <label for="resource" class="col-md-4 control-label">Resource</label>

                    <div class="col-md-6">
                        <div class="col-md-4" style="width: 100%;padding-left:0px;padding-right:0px" >
                               
                            <select class="js-example-basic-multiple form-control" name="tag_list[]" multiple="multiple" required="required">
                                    <?php
                                    $array_ten = array();
                                    $re_a = str_replace( '[', '', $schedule['resource_ids'] );
                                    $re_b = str_replace( ']', '', $re_a );
                                    $array_ten = explode(',',  $re_b);
                                    $i=0;
                                    foreach($array_ten as $key=>$value2){
                                        foreach($resources as $re){
                                            if($re['id']==$value2){
                                                echo '<option value="';
                                                echo $re['id'];
                                                echo '" selected="selected">';
                                                echo $re['name'];
                                                echo "</option>";
                                            }
                                            if($re['id']!=$value2) {
                                                echo '<option value="';
                                                echo $re['id'];
                                                echo '">';
                                                echo $re['name'];
                                                echo "</option>";
                                            }
                                            
                                        }
                                        $i++;
                                        if($i%3==0){echo "<br>";}
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>

                   
                </div>

                <div class="form-group" >
                        <label for="permission" class="col-md-4 control-label"> Permission</label>
                        
                        <?php
                            $array_ten = array();
                            $re_a = str_replace( '[', '', $schedule['permission_ids'] );
                            $re_b = str_replace( ']', '', $re_a );
                            $array_ten = explode(',',  $re_b);
                            $admin ='';
                            $driver='';
                            $bmanager='';
                            foreach($array_ten as $key=>$value2){
                                if($value2=='0'){
                                    $admin=$value2;
                                }
                                if($value2=='1'){
                                    $driver=$value2;
                                }
                                if($value2=='2'){
                                    $bmanager=$value2;
                                }
                            }
                            $roleIsAdmin = config('user.role.admin');
                            $roleIsDriver = config('user.role.driver');
                            $roleIsBmanager = config('user.role.bmanager');
                            
                            if (strcmp($admin,$roleIsAdmin) ==0){
                              echo  '<div class="col-md-2">
                                        <input type="checkbox" name="admin" value="';echo config('user.role.admin');echo '" checked> <div class="permisson">Admin</div> 
                                    </div>';
                            }
                            else {
                                echo '<div class="col-md-2">
                                        <input type="checkbox" name="admin" value="';echo config('user.role.admin');echo '" > <div class="permisson">Admin</div> 
                                    </div>';
                            }
                            
                            if(strcmp($driver,$roleIsDriver) ==0){
                               echo '<div class="col-md-2">
                                    <input type="checkbox" name="driver" value="';echo config('user.role.driver');echo '" checked><div class="permisson"> Driver </div>
                                </div>';
                            }
                            else {
                              echo  '<div class="col-md-2">
                                    <input type="checkbox" name="driver" value="';echo config('user.role.driver');echo '"><div class="permisson"> Driver </div>
                                </div>';
                            }
                           
                            if (strcmp($bmanager,$roleIsBmanager) ==0) {
                               echo '<div class="col-md-2">
                                        <input type="checkbox" name="bmanager" value="';echo config('user.role.bmanager');echo '" checked><div class="permisson">Bmanager</div>  
                                    </div>';
                            } else {
                               echo '<div class="col-md-2">
                                        <input type="checkbox" name="bmanager" value="';echo config('user.role.bmanager');echo '"><div class="permisson">Bmanager</div>  
                                    </div>';
                            }
                            
                        ?>
                    </div>

                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4">
                        <input class="btn btn-primary" type="submit" value="Submit">
                    </div>
                </div>
           
            {!! Form::close() !!}
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
// $('#tag_list').select2({
//     width: '100%',
//     color: 'black',
//     placeholder: "Choose resources name and waiting for search...",
//     minimumInputLength: 1,
//     ajax: {
//         url: '/admin/resourcesfind/find-resources-select2',
//         dataType: 'json',
//         data: function (params) {
//             return {
//                 q: $.trim(params.term)
//             };
//         },
//         processResults: function (data) {
//             return {
//                 results: data
//             };
//         },
//         cache: true
//     }
// });
$(document).ready(function() {
   
   $('.js-example-basic-multiple').select2({
       placeholder: "Select a resource",
       allowClear: true
   });
});
</script>
@endpush