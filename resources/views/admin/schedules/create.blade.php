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
    .per {
        padding-top: 7px;
    }
    
</style>
@stop
<div class="row" >
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Create New Schedule</h3>
            </div>
            <div class="box-body">
                <a href="{{route('schedules-management.index')}}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                <br>
                <br>
            <form method="POST" action="{{ action('Admin\\SchedulesServiceController@store') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" >
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                <div class="form-group ">
                    <label for="schedulename" class="col-md-4 control-label">Schedule Name</label>
                    <div class="col-md-6">
                        <input class="form-control" name="name" type="text" required="required">
                    </div>
                </div>

                <div class="form-group ">
                    <label for="description " class="col-md-4 control-label">Description</label>
                    <div class="col-md-6">
                        <input class="form-control" name="description" type="text" required="required">
                    </div>
                </div>

                <div class="form-group ">
                    <label for="order" class="col-md-4 control-label">Order</label>
                    <div class="col-md-6">
                        <input class="form-control" name="order_pos" type="number" required="required">
                    </div>
                </div>

                <div class="form-group ">
                    <label for="resource" class="col-md-4 control-label">Resource</label>
                    {{-- <div class="col-md-6">
                        <div class="col-md-4" style="width: 100%;padding-left:0px;padding-right:0px" >
                            <select  id="tag_list" name="tag_list[]" class="form-control" multiple ></select>
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="col-md-4" style="width: 100%;padding-left:0px;padding-right:0px" >
                            <select class="js-example-basic-multiple form-control" name="tag_list[]" multiple="multiple" required="required">
                                @foreach($resource as $resource)
                                    <option value="{{$resource['id']}}">{{$resource['name']}}</option> 
                                @endforeach
                            </select>
                        </div>
                    </div>

                <div class="form-group" >
                  
                    <label for="permission" class="col-md-4 control-label"> Permission</label>
                    <div class="col-md-2 per">
                        <input type="checkbox" name="admin" value="{{config('user.role.admin')}}" > <div class="permisson">Admin</div> 
                    </div>
                    <div class="col-md-2 per">
                        <input type="checkbox" name="driver" value="{{config('user.role.driver')}}"><div class="permisson"> Driver </div>
                    </div>
                    <div class="col-md-2 per">
                        <input type="checkbox" name="bmanager" value="{{config('user.role.bmanager')}}"><div class="permisson">Bmanager</div>  
                    </div>
                   
                </div>

                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4" >
                        <input class="btn btn-primary" type="submit" value="Create">
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>


// $('#tag_list').select2({
//     width: '100%',
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