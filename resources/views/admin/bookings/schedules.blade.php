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
        </style>
        <div class="row">

            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Schedules</h3>
                    </div>
                    <div class="box-body">

                        <div id="scheduleContainer" class="left col">
                            <div id="scheduler" class="dhx_cal_container" style='height:100vh;'>
                                <div class="dhx_cal_navline">
                                    <div class="button-nav-group" id="dhx_menu_controls">
                                        <div class="dhx_cal_prev_button">&nbsp;</div>
                                        <div class="dhx_cal_next_button">&nbsp;</div>
                                        <div class="dhx_cal_today_button"></div>
                                        <div class="dhx_normal_buttons">
                                            <div id="stateBtnGroup" class="btn-group state-menu" role="group">
                                                <div class="btn btn-default dhx_day state" onclick="changeState('day');">Day</div>
                                                <div id="weekDropdownMenu" class="btn-group dhx_week state" role="group">
                                                    <div class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Week
                                                    </div>
                                                </div>
                                                <div id="monthDropdownMenu" class="btn-group dhx_month state" role="group">
                                                    <div class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Month
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="my_dhx_cal_tab wide_tab dhx_cal_tab_first dhx_timeline view" name="timeline_tab" onclick="changeView('timeline');"></div>
                                            <div class="my_dhx_cal_tab wide_tab dhx_calendar view" name="calendar_tab" onclick="changeView('calendar');"></div>
                                            <div class="my_dhx_cal_tab dhx_cal_tab_last dhx_grid view" name="grid_tab" onclick="changeView('grid');"></div>

                                        </div>
                                        <div class="dhx_mini_cal">

                                            <div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>

                                        </div>
                                    </div>
                                    <div class="button-nav-group" id="dhx_menu_date_display">
                                        <div class="dhx_cal_date"></div>
                                    </div>
                                    <div class="button-nav-group" id="dhx_menu_extra_buttons">
                                        <div class="dhx_mobile_setting_panel_button">
                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#mobileSettingModal">
                                                <span class="glyphicon glyphicon-cog text-primary" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                        <div class="dhx_colour">
                                            <select id="scheduleColor" class="form-control">
                                                <option value="resource" selected="selected" >Color by Resource</option>
                                                <option value="status" >Color by Status</option>
                                            </select>
                                        </div>
                                        <div class="dhx_schedule">
                                            {!! Form::open(['method' => 'GET', 'url' => '/admin/schedules', 'id' => 'scheduleSelectionForm'])  !!}
                                            <select id="scheduleSelect" name="scheduleSelect" class="form-control" onchange="this.form.submit()">
                                                @foreach($schedules as $schedule)
                                                    <option value="{{$schedule['id']}}" @if($schedule['id'] == $scheduleSelectId) selected="selected" @endif>{{$schedule['name']}}</option>
                                                @endforeach
                                            </select>
                                            {!! Form::close() !!}
                                        </div>
                                        {{--<div class="dhx_options">--}}
                                            {{--<!-- Single button -->--}}
                                            {{--<div class="btn-group">--}}
                                                {{--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">--}}
                                                    {{--<span class="glyphicon glyphicon-cog text-primary" aria-hidden="true"></span>--}}
                                                {{--</button>--}}
                                                {{--<ul class="dropdown-menu dropdown-menu-right" role="menu">--}}
                                                    {{--<li class="menu-item dropdown dropdown-submenu left">--}}
                                                        {{--<a href="#" class="menu-item" data-toggle="dropdown">Export view<span class="caret caret-left"></span></a>--}}
                                                        {{--<ul class="dropdown-menu">--}}
                                                            {{--<li class="menu-item "><a href="javascript:void(0)" onclick="exportSchedulePDF();">PDF</a></li>--}}
                                                            {{--<li class="menu-item "><a href="javascript:void(0)" onclick="showExcelExport();">Excel Spreadsheet</a></li>--}}
                                                        {{--</ul>--}}
                                                    {{--</li>--}}
                                                    {{--<li class="menu-item dropdown dropdown-submenu left">--}}
                                                        {{--<a href="#" class="menu-item" data-toggle="dropdown">Row Height<span class="caret caret-left"></span></a>--}}
                                                        {{--<ul id="rowHeightMenu" class="dropdown-menu">--}}
                                                            {{--<li id="rowHeight40" class="menu-item "><a href="javascript:void(0)" onclick="setTimelineRowHeight(40);">Small</a></li>--}}
                                                            {{--<li id="rowHeight60" class="menu-item "><a href="javascript:void(0)" onclick="setTimelineRowHeight(60);">Medium</a></li>--}}
                                                            {{--<li id="rowHeight120" class="menu-item "><a href="javascript:void(0)" onclick="setTimelineRowHeight(120);">Large</a></li>--}}
                                                        {{--</ul>--}}
                                                    {{--</li>--}}
                                                    {{--<li role="separator" class="divider"></li>--}}
                                                    {{--<li><a href="javascript:void(0)" onclick="toggleFilterPanel();">Filter Bookings</a></li>--}}
                                                    {{--<li role="separator" class='divider'></li>--}}
                                                    {{--<li><a href="javascript:void(0)" onclick="showShortcuts();">Keyboard Shortcuts</a></li>--}}
                                                {{--</ul>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                                <div class="dhx_cal_header"></div>
                                <div class="dhx_cal_data"></div>
                            </div>

                            <div id="schedule-editor" class="right col cb_slide_panel panel_right">
                                <div id="schedule-editor-header">
                                    <div class="btn-group right-pad-5">
                                        <button type="button" id="saveButton" class="btn btn-primary" onclick="save_form()">Save</button>
                                        <!-- <button type="button" id="saveCloseButton" class="btn btn-primary dropdown-toggle" onclick="getFormData(true);">
                                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        </button> -->
                                    </div>
                                    <div class="right-pad-5">
                                        <!-- <button id="fileAttachBtn" type="button" class="btn btn-default" data-toggle="modal" data-target="#ajaxModalTwo">
                                            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
                                        </button>
                                        <button id="linkBtn" type="button" class="btn btn-default">
                                            <span class="glyphicon glyphicon-link" aria-hidden="true"></span>
                                        </button> -->
                                    </div>
                                    <div class="btn-group flex-pull-right">
                                        <button type="button" class="btn btn-default" onclick="closeEditForm()">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="clear-float"></div>
                                <div class="alert-group">
                                    <div class="alert alert-warning" id="masterBookingAlert"><b>Master Booking</b>
                                    <p>Editing this master booking will apply the same edits to all slave bookings</p></div>
                                    <div class="alert alert-info" id="slaveBookingAlert"><b>Slave Booking</b>
                                        <p>Editing this slave booking will convert the booking to a normal standalone booking</p></div>
                                </div>
                                <div class="panel-group" id="accordion">
                                    <div id="bookingDetails" class="panel panel-default">
                                        <div class="panel-heading" data-toggle="collapse" data-target="#collapseOne" data-parent="#accordion" aria-expanded="true">
                                            <h4 class="panel-title">Details</h4>
                                            <span id="statusLabel" class="badge alert-danger pull-right"></span>
                                            <div class="clear-float"></div>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="bookingName">Booking Name</label>
                                                    <input type="text" class="form-control watch" id="bookingName" placeholder="The name for your booking" tabindex="1"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bookingResources">Resources</label>
                                                    <select id="bookingResource" name="bookingResource" class="select2 sm">
                                                    </select>
                                                </div>
                                                <div class="form-group clear-float-wrapper">
                                                    <label class="full-width">Start Date / Time</label>
                                                    <div class="input-group start-date date pull-left xsm" id="booStartDate">
                                                        <input type="text" id="startDate" name="startDate" class="form-control" tabindex="3"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                    </div>
                                                    <div class="input-group pull-right xxsm">
                                                        <input id="startTime" name="startTime" type="text" class="timepicker form-control" tabindex="4">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group">
                                                    <label class="full-width" for="duration">Direction / Duration</label>
                                                    <div id="directionButtons" class="btn-group btn-toggle" data-toggle="buttons">
                                                        <label id="startAlign" class="btn btn-md btn-default active">
                                                            <input type="radio" name="options" value="startAlign"><i class="itype icon-arrow-thin-right"></i>
                                                        </label>
                                                        <label id="endAlign" class="btn btn-md btn-default">
                                                            <input type="radio" name="options" value="endAlign"><i class="itype icon-arrow-thin-left"></i>
                                                        </label>
                                                    </div>
                                                    <div class="pull-right xxxsm duration-field">
                                                        <input type="text" class="form-control duration-input" id="durationMin" name="duration" tabindex="5">
                                                        <label for="durationMinute" class="duration-field-desc">Minutes</label>
                                                    </div>
                                                    <div class="pull-right xxxsm duration-field">
                                                        <input type="text" class="form-control duration-input" id="durationHour" name="duration" tabindex="6">
                                                        <label for="durationHour" class="duration-field-desc">Hours</label>
                                                    </div>
                                                    <div class="pull-right xxxsm duration-field">
                                                        <input type="text" class="form-control duration-input" id="durationDay" name="duration" tabindex="7">
                                                        <label for="durationDay" class="duration-field-desc">Days</label>
                                                    </div>
                                                </div> -->
                                                <div class="form-group clear-float-wrapper">
                                                    <label for="endDate" class="full-width">End Date / Time</label>
                                                    <div class="input-group end-date date pull-left xsm" id="booEndDate">
                                                        <input type="text" id="endDate" name="endDate" class="form-control" tabindex="8"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                    </div>
                                                    <div class="input-group pull-right xxsm">
                                                        <input id="endTime" name="endTime" type="text" class="timepicker form-control" tabindex="9">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="customAjaxParent" class="panel panel-default">
                                        <div class="panel-heading" data-toggle="collapse" data-target="#collapseTwo" data-parent="#accordion">
                                            <h4 class="panel-title">Staff / Status / Client / Custom</h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="bookingProject">Staff</label>
                                                    <select id="bookingProject" class="select2 sm">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bookingStatus">Status</label>
                                                    <select id="bookingStatus" class="select2 sm">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <!-- <div class="form-group">
                                                    <label for="bookingClient">Client</label>
                                                    <input type="text" id="bookingClient" placeholder="Select Client" class="select2 sm"/>
                                                </div>
                                                <form id="customFieldForm">
                                                    <div id="customAjaxPanel"></div>
                                                </form> -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="panel panel-default repeat-panel">
                                        <div class="panel-heading" data-toggle="collapse" data-target="#collapseThree" data-parent="#accordion">
                                            <h4 class="panel-title">Repeat</h4>
                                            <span id="repeatLabel" class="badge alert-warning pull-right"></span>
                                            <div class="clear-float"></div>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group clear-float-wrapper">
                                                    <div class="input-group pull-left xsm">
                                                        <label class="full-width" for="repeatFreq">Repeat Booking</label>
                                                        <select id="repeatFreq" name="repeatFreq" class="form-control">
                                                            <option value="0">No Repeat</option>
                                                            <option value="hourly">Hourly</option>
                                                            <option value="daily">Daily</option>
                                                            <option value="weekly">Weekly</option>
                                                            <option value="monthly">Monthly</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group pull-right xxsm">
                                                        <label class="full-width" for="repeatInterval" id="repeatIntervalLabel"><span id="freqLabel">Repeat Interval</span></label>
                                                        <input type="number" id="repeatInterval" name="repeatInterval" class="form-control slave-rep-field" disabled min="1" value="1"/>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="repByDayCont" style="display:none;">
                                                    <label class="full-width" for="repeatByDay">Repeat weekly on:</label>
                                                    <select id="repeatByDay" class="form-control slave-rep-field" multiple="multiple" size="7">
                                                        <option value="1">Monday</option>
                                                        <option value="2">Tuesday</option>
                                                        <option value="3">Wednesday</option>
                                                        <option value="4">Thursday</option>
                                                        <option value="5">Friday</option>
                                                        <option value="6">Saturday</option>
                                                        <option value="0">Sunday</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="full-width" for="repeatEnd">End Repeat</label>
                                                    <select id="repeatEndType" class="form-control slave-rep-field">
                                                        <option value="date">Specify end date / time</option>
                                                        <option value="count">Specify occurrences</option>
                                                    </select>
                                                </div>
                                                <div id="repeatEndCountCont" class="form-group" style="display:none;">
                                                    <label class="full-width" for="repeatEndCount">Number of Occurrences</label>
                                                    <input type="number" id="repeatEndCount" name="repeatCount" class="form-control slave-rep-field"/>
                                                </div>
                                                <div id="repeatEndDateCont" class="form-group">
                                                    <label for="repeatEndDate" class="full-width">End Date / Time</label>
                                                    <div class="input-group pull-left xsm">
                                                        <div class="input-group repeat-end-date date pull-left xsm">
                                                            <input type="text" id="repeatEndDate" name="repeatEndDate" class="form-control slave-rep-field"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group pull-right xxsm">
                                                        <input id="repeatEndTime" name="endTime" type="text" class="timepicker form-control slave-rep-field">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="invAjaxParent" class="panel panel-default">
                                        <div class="panel-heading" data-toggle="collapse" data-target="#collapseFive" data-parent="#accordion">
                                            <h4 class="panel-title">Quotes / Invoices</h4>
                                        </div>
                                        <div id="collapseFive" class="panel-collapse collapse">
                                            <div id="invAjaxPanel" class="panel-body"></div>
                                        </div>
                                    </div> -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading" data-toggle="collapse" data-target="#collapseFour" data-parent="#accordion">
                                            <h4 class="panel-title">Meta</h4>
                                        </div>
                                        <div id="collapseFour" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="full-width" for="repeatInterval">Booking Notes</label>
                                                    <textarea id="bookingNotes" rows="6" class="form-control"></textarea>
                                                </div>
                                                <!-- <div class="form-group">
                                                    <label class="full-width">Booking Metadata</label>
                                                    <dl class="dl-horizontal">
                                                        <dt>Unique Identifer (UID):</dt>
                                                        <dd id="uid"></dd>
                                                        <dt>Created By:</dt>
                                                        <dd id="createdBy"></dd>
                                                        <dt>Created On:</dt>
                                                        <dd id="createdOn"></dd>
                                                        <dt>Last Updated By:</dt>
                                                        <dd id="updatedBy"></dd>
                                                        <dt>Last Updated On:</dt>
                                                        <dd id="updatedOn"></dd>
                                                    </dl>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script src="{{ asset('vendor/adminlte/js/notify.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    @if(config('adminlte.plugins.dhtmlx_schedule'))
        <script src="{{ asset('vendor/adminlte/vendor/dhtmlxScheduler_v4.4.0/codebase/dhtmlxgantt.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/vendor/dhtmlxScheduler_v4.4.0/codebase/dhtmlxscheduler.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/vendor/dhtmlxScheduler_v4.4.0/codebase/scheduler.date-dst.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/vendor/dhtmlxScheduler_v4.4.0/codebase/dhtmlxscheduler_plugins.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/vendor/dhtmlxScheduler_v4.4.0/codebase/dhtmlxscheduler_minical.js') }}"></script>
    @endif
    
    <script type="text/javascript">
        var HOST_URL = {!! json_encode(url('/')) !!};
        var BOOKINGS = {!! json_encode($bookings) !!};
        var RESOURCES = {!! json_encode($resources) !!};
        var PROJECTS = {!! json_encode($projects) !!};
        var STATUS = {!! json_encode($status) !!};
        var BOOKING_RESOURCES = {!! json_encode($booking_resources) !!};
        var CURRENT_USER = {!! json_encode( $current_user ) !!};
        var ROLES = {
            admin: {!! config('user.role.admin') !!},
            driver: {!! config('user.role.driver') !!},
            bmanager: {!! config('user.role.bmanager') !!},
        }
    </script>
    <script src="{{ asset('vendor/adminlte/js/schedule.js') }}"></script>

@endsection
