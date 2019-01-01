@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.standalone.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    @if(config('adminlte.plugins.dhtmlx_schedule'))
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/dhtmlxScheduler_v4.4.0/codebase/dhtmlxscheduler.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/schedule.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <style type="text/css">
        .content-header,
        .content {
            background: #ffffff !important;
        }

        .message {
            color: white;
            background-color: #4d4d4d;
            text-align: center;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 35vh;
        }

        .box-body {
            background-color: #919191;
            height: 80vh;
        }

    </style>
    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Schedules</h3>
                </div>
                <div class="box-body">
                    <h1 class="message">No Schedule Available</h1>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
@endsection
