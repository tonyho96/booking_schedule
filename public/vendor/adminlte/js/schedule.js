var fields = [{
    id: "text",
    label: _name,
    sort: "str",
    width: 200,
    align: "left"
}, {
    id: "start_date",
    label: _start_date,
    template: function(d, b, c) {
        return dxHumanString(d)
    },
    sort: "date",
    width: 170,
    align: "left"
}, {
    id: "end_date",
    label: _end_date,
    template: function(d, b, c) {
        return dxHumanString(b)
    },
    width: 170,
    align: "left"
}, {
    id: "resource_name",
    label: _resources,
    width: 220,
    align: "left"
}, {
    id: "project_name",
    label: _project,
    width: 200,
    align: "left"
}, {
    id: "status_name",
    label: _status,
    width: 80,
    align: "left"
}];
var active_views = {
    timeline_week: "timeline_day",
    timeline_week_2: "timeline_day",
    timeline_week_3: "timeline_day",
    timeline_month: "timeline_day",
    timeline_month_2: "timeline_day",
    timeline_month_3: "timeline_day",
    timeline_day: "timeline_day",
    grid_week: "grid_day",
    week: "day",
    month: "day"
};
var j = jQuery.noConflict();

var start;
var end;
var bookingId = "";
var editor = j("#schedule-editor");
var schedule = j("#scheduler");
var scheduleCont = j("#scheduleContainer");
var dateFormat = "dd/mm/yyyy";
var timeFormat = false;
// DHTMLX related helpers
var dxDateFormat = "%d/%m/%Y";
var dxDateTextFormat = "%d %M %Y";
var dxTimeFormat = "%H:%i";

var _name = 'Name';
var _start_date = 'Start Date';
var _end_date = 'End Date';
var _resources = 'Resources';
var _project = 'Project';
var _status = 'Status';
var _client = 'Client';
var _unsaved_changes = 'Please save or close sidebar before adding or editing other bookings';
var _confirm_delete = 'Are you sure you want to delete this booking?';
var _timeline = 'Timeline';
var _calendar = 'Calendar';
var _saved_changes = 'Saved Changes';
var _changes_not_saved = 'Changes Not Saved';
var _error_saving_booking = 'Error Saving Booking';
var _loading = 'Loading';
var _booking_clashes = 'Booking Clashes';
var _continue_saving = 'Continue Saving';
var _abort_save = 'Abort Saving';
var _schedule_shortcuts = 'Schedule Keyboard Shortcuts';
var _excel_export = 'Excel Spreadsheet Export';
var _files = 'Files';
var _copy_booking_link = 'Copy Booking Link';

var resourceTypePriorityFlag = false;
var resourceTypePriority = [];

var scheduleId = 1896;
var colorMode = "resource";
var mondayStart = true;
var firstHour = '0';
var lastHour = '24';
var scrollHour = '1';
var timeStep = '60';

var fillCell = false;

// Scheduler
var dxDateString = scheduler.date.date_to_str(dxDateFormat);
var dxDateTextString = scheduler.date.date_to_str(dxDateTextFormat);
var dxTimeString = scheduler.date.date_to_str(dxTimeFormat);
var dxHumanString = scheduler.date.date_to_str("%j %M %Y " + dxTimeFormat);
var dxDateObject = scheduler.date.str_to_date("%d/%m/%Y %H:%i");
var dxDateDbObject = scheduler.date.str_to_date("%Y-%m-%d %H:%i");

var html = function(id) { return document.getElementById(id); }; //just a helper

scheduler.config.multi_day = true;
scheduler.config.fix_tab_position = false;
scheduler.config.details_on_create = true;
scheduler.config.details_on_dblclick = true;
scheduler.config.multisection = true;
scheduler.config.api_date = dxDateFormat + " " + dxTimeFormat;
scheduler.config.xml_date = "%Y-%m-%d %H:%i";
scheduler.locale.labels.confirm_deleting = _confirm_delete;
scheduler.locale.labels.timeline_tab = _timeline;
scheduler.locale.labels.calendar_tab = _calendar;
scheduler.locale.labels.icon_files = _files;
scheduler.config.scroll_hour = scrollHour;
scheduler.config.first_hour = firstHour;
scheduler.config.last_hour = lastHour;
scheduler.config.start_on_monday = mondayStart;
scheduler.config.show_loading = true;
scheduler.config.multisection_shift_all = false;
scheduler.config.time_step = timeStep;
scheduler.config.prevent_cache = true;
scheduler.config.icons_edit = ["icon_files"];
scheduler.config.show_quick_info = false;

if( CURRENT_USER.role == ROLES.driver ) {
    scheduler.config.readonly = true;
    scheduler.config.readonly_form = true;
    var readOnly = true;
}
// scheduler.locale.labels.timeline_tab ="Timeline";

/**
 * Scheduler functions
 */
var showQuickInfo = scheduler.showQuickInfo;
scheduler.showQuickInfo = function(c) {
    var b = scheduler.getEvent(c);
    if (b.readonly || typeof readOnly != "undefined") {
        scheduler.config.icons_select = ["icon_details"];
    } else {
        scheduler.config.icons_select = ["icon_details", "icon_delete"];
    }
    if (scheduler._quick_info_box) {
        if (scheduler._quick_info_box.parentNode) {
            scheduler._quick_info_box.parentNode.removeChild(scheduler._quick_info_box)
        }
        scheduler._quick_info_box = null
    }
    showQuickInfo.apply(this, arguments)
};
scheduler.templates.quick_info_content = function(k, b, f) {
    var g = "";
    var h = [];
    var e = String(f.users).split(",");
    if (f.users != 0) {

        for (var d = 0; d < e.length; d++) {
            if (e[d] != 0) {
                var c = find_object_with_attr(allResources, {
                    key: "id",
                    val: e[d]
                });
                h[d] = typeof c[0] != 'undefined' ? c[0].text : '';
                h = h.filter(function() {
                    return true
                })
            }
        }
        g = makeUL(h).outerHTML
    }
    
    if (f.project_name && f.project_id) {
        var project = find_object_with_attr(allProjects, {
            key: "id",
            val: f.project_id
        });
        g += '<div>Staff: <a href="/admin/projects/' + f.project_id + '"><span class="badge project_' + f.project_id + '" style="background-color: '+ project[0].colorBg +'; color: '+ project[0].colorText +';">' + f.project_name + "</span></a></div>"
    }
    if (f.status_name && f.status_id) {
        var status = find_object_with_attr(allStatus, {
            key: "id",
            val: f.status_id
        });
        g += '<div>Status: <span class="badge status_' + f.status_id + ' status_'+ f.status_name +'" style="background-color: '+ status[0].colorBg +'; color: '+ status[0].colorText +';">' + f.status_name + "</span></div>"
    }
    if (f.notes) {
        g += "<div>" + f.notes + "</div>"
    }
    return g
};
scheduler.showLightbox = function(id) {
    var eventObj = scheduler.getEvent(id);
    var flag = false;
    for( var i = 0; i < $bookings.length; i++ ) {
        if( $bookings[i].id == eventObj.id ) 
            flag = true;
    }
    openEditForm(id);
    unlockEditForm();
    j(".dhx_cal_quick_info").remove();
    if (typeof readOnly !== "undefined") {
        lockEditForm();
    } else {
        if (flag) {
            if (eventObj.readonly == false) {
                unlockEditForm();
            } else {
                lockEditForm();
            }
        } else {
            unlockEditForm()
        }
    }
};

(function() {
    var b = null;
    scheduler.attachEvent("onClick", function(f, d) {
        var c = d.target || d.srcElement;
        while (c && c.hasAttribute && !c.hasAttribute("event_id")) {
            c = c.parentNode
        }
        b = c;
        scheduler.config.show_quick_info = true;
        scheduler.showQuickInfo(f);
        scheduler.config.show_quick_info = false;
        b = null;
        return true
    });
    scheduler.getRenderedEvent = function(f) {
        if (!f) {
            return
        }
        var d = scheduler._rendered;
        for (var e = 0; e < d.length; e++) {
            var c = d[e];
            if (c.getAttribute("event_id") == f && (!b || b == c)) {
                return c
            }
        }
        return null
    }
})();

/**
 * Scheduler trigger
 */
scheduler.attachEvent("onBeforeDrag", function(d, c, b) {
    if (b.shiftKey) {
        scheduler.config.multisection_shift_all = true
    }
    return true
});
scheduler.attachEvent("onDragEnd", function() {
    scheduler.config.multisection_shift_all = false;
});
scheduler.attachEvent("onBeforeLightbox", function (event_id){
    scheduler.resetLightbox();
    return true;
});
scheduler.attachEvent("onEventDeleted", function(booking_id, ev){
    if(scheduler.getState().new_event)
        return;
    j.ajax({
        headers: {
            'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
        },
        url: HOST_URL + '/admin/schedules/delete',
        dateType: 'json',
        type: 'POST',
        async: false,
        data: {
            id: booking_id
        },
        success: function( response ) {
            j.notify(response.message, 'success');
        },
        error: function (data, textStatus, errorThrown) {
            j.notify(textStatus, 'error');
        }
    });
});
scheduler.attachEvent("onEventChanged", function(id,ev){
    if( ev.start_date !== undefined && ev.end_date !== undefined ) {
        j.ajax({
            headers: {
                'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
            },
            url: HOST_URL + '/admin/schedules/create',
            dateType: 'json',
            type: 'POST',
            async: false,
            data: {
                id: id,
                name: ev.text,
                start_date_time: (ev.start_date.getMonth() + 1) + '/' + ev.start_date.getDate() + '/' +  ev.start_date.getFullYear() + ' ' + ev.start_date.getHours() + ':' + ev.start_date.getMinutes(),
                end_date_time: (ev.end_date.getMonth() + 1) + '/' + ev.end_date.getDate() + '/' +  ev.end_date.getFullYear() + ' ' + ev.end_date.getHours() + ':' + ev.end_date.getMinutes(),
                users: ev.users,
            },
            success: function() {
                j.notify( _saved_changes, 'success' );
            },
            error: function (data, textStatus, errorThrown) {
                j.notify(_error_saving_booking, 'error');
            }
        });
    }
});


var $bookings = [];
var $users = [];
var allResources = [];
var allProjects = [];
var allStatus = [];

// Build users
for ( var u in RESOURCES.Result ) {
    $users[u] = {
        key: RESOURCES.Result[u].id,
        label:"<div class=\"avatar-square\" style=\"background-image: url(http://via.placeholder.com/350x150);\"></div><h3>"+ RESOURCES.Result[u].name +"<small>"+ RESOURCES.Result[u].description +"</small></h3>",
    };
    allResources[u] = {
        id: RESOURCES.Result[u].id,
        text: RESOURCES.Result[u].name
    }
}

// Build projects
for ( var u in PROJECTS.Result ) {
    allProjects[u] = {
        id: PROJECTS.Result[u].id,
        name: PROJECTS.Result[u].name,
        code: PROJECTS.Result[u].code,
        text: PROJECTS.Result[u].name + ' ['+ PROJECTS.Result[u].code +']',
        colorText: PROJECTS.Result[u].color_text,
        colorBg: PROJECTS.Result[u].color_background,
        description: PROJECTS.Result[u].description,
    }
}

// Build status
for ( var u in STATUS.Result ) {
    allStatus[u] = {
        id: STATUS.Result[u].id,
        text: STATUS.Result[u].name,
        colorBg: STATUS.Result[u].color_background,
        colorText: STATUS.Result[u].color_text
    }
}

// Build bookings
for ( var b in BOOKINGS.Result ) {
    var start_date_time = new Date(BOOKINGS.Result[b].start_date_time);
    var end_date_time = new Date(BOOKINGS.Result[b].end_date_time);
    var project_id = BOOKINGS.Result[b].project_id;
    var notes = BOOKINGS.Result[b].notes;
    var client_personal_id = BOOKINGS.Result[b].client_personal_id;
    var readOnlyTmp = false;

    if( CURRENT_USER.role == ROLES.bmanager && CURRENT_USER.id != client_personal_id )
        var readOnlyTmp = true;
    
    var project_code = '';
    var project_name = '';
    if (project_id != 0 && project_id != null) {
        var e = find_object_with_attr(allProjects, {
            key: 'id',
            val: project_id
        });
        project_name = e[0] !== undefined ? e[0].text : '';
        project_code = e[0] !== undefined ? e[0].code : '';
    }

    var status_id = BOOKINGS.Result[b].status_id;
    var status_name = '';
    var status_bg_color = '';
    var status_text_color = '';
    if (status_id != 0 && status_id != null) {
        var e = find_object_with_attr(allStatus, {
            key: 'id',
            val: status_id
        });
        status_name = e[0] !== undefined ? e[0].text : '';
        status_bg_color = e[0] !== undefined ? e[0].colorBg : '';
        status_text_color = e[0] !== undefined ? e[0].colorText : '';
    }
    var users = [];
    if( BOOKING_RESOURCES[BOOKINGS.Result[b].id] !== undefined )
        users = BOOKING_RESOURCES[BOOKINGS.Result[b].id];

    var F = [];
    for ( var i = 0; i < users.length; i++ ) {
        var c = find_object_with_attr(allResources, {
            key: "id",
            val: users[i]
        });
        if( c.length > 0 )
            F[i] = c[0] !== undefined ? c[0].text : '';
    }

    $bookings[b] = {
        id: BOOKINGS.Result[b].id,
        start_date: start_date_time,
        end_date: end_date_time,
        text: BOOKINGS.Result[b].name,
        users: users,
        project_id: project_id,
        project_name: project_name,
        project_code: project_code,
        status_id: status_id,
        status_name: status_name,
        notes: notes,
        resource_name: F.join(", "),
        client_personal_id: client_personal_id,
        readonly: readOnlyTmp,
        color: status_bg_color,
        textColor: status_text_color
    }
}

/**
 * Create timelineview
 */
scheduler.createTimelineView({
    name: 'timeline_day',
    x_unit: 'hour',
    x_date: dxTimeFormat,
    x_step: 1,
    x_size: lastHour - firstHour,
    x_length: 24,
    x_start: firstHour,
    section_autoheight: false,
    resize_events: false,
    y_unit: $users,
    y_property: 'users',
    render: 'tree',
    folder_dy: 20,
    event_dy: 56,
    dy: 60,
    dx: 230,
    second_scale: {
        x_unit: 'day',
        x_date: '%l'
    }
});
scheduler.createTimelineView({
    name: "timeline_week",
    x_unit: "day",
    x_date: "%D, %F %j",
    x_step: 1,
    x_size: 7,
    x_length: 7,
    section_autoheight: false,
    resize_events: false,
    y_unit: $users,
    y_property: "users",
    render: "tree",
    folder_dy: 20,
    event_dy: 56,
    dy: 60,
    dx: 230,
    round_position: fillCell,
    first_hour: firstHour,
    last_hour: lastHour
});
scheduler.createTimelineView({
    name: "timeline_month",
    x_unit: "day",
    x_date: "%D %d",
    x_step: 1,
    x_size: 31,
    x_start: 0,
    x_length: 31,
    section_autoheight: false,
    resize_events: false,
    y_unit: $users,
    y_property: "users",
    render: "tree",
    folder_dy: 20,
    event_dy: 56,
    dy: 60,
    dx: 230,
    round_position: fillCell,
    first_hour: firstHour,
    last_hour: lastHour
});

scheduler.attachEvent("onBeforeViewChange", function(o, k, l, h) {
    if( typeof h == 'undefined' ) return true;
    var p = h.getFullYear();
    if (l == "timeline_month") {
        var m = (h.getMonth() + 1);
        var n = new Date(p, m, 0);
        var r = n.getDate();
        scheduler.matrix.timeline_month.x_size = r
    }
    return true
});

function correctMonthTimelineStep(b, d, c) {
    if (d > 0) {
        d = c
    } else {
        if (d < 0) {
            d = -c
        }
    }
    return scheduler.date.add(b, d, "month")
}
scheduler.date.add_timeline_month = function(b, c) {
    return correctMonthTimelineStep(b, c, 1)
};

scheduler.date.timeline_week_start = scheduler.date.week_start;
scheduler.date.timeline_month_start = scheduler.date.month_start;

scheduler.createGridView({
    name: "grid_day",
    fields: fields,
    unit: "day",
    step: 1,
    paging: true
});
scheduler.createGridView({
    name: "grid_week",
    fields: fields,
    unit: "week",
    step: 1,
    paging: true
});
scheduler.createGridView({
    name: "grid_month",
    fields: fields,
    unit: "month",
    step: 1,
    paging: true
});

scheduler.attachEvent("onTemplatesReady", function() {
    scheduler.templates.hour_scale = function(b) {
        return dxTimeString(b)
    };
    scheduler.templates.event_header = function(e, b, d) {
        var c = scheduler.getEvent(d.id);
        return dxTimeString(c.start_date) + " - " + dxTimeString(c.end_date)
    };
    scheduler.templates.day_scale_date = function(b) {
        return scheduler.date.date_to_str("%l, %j %M %y")(b)
    };
    scheduler.templates.event_bar_date = function(d, b, c) {
        return "<b>" + dxTimeString(d) + "</b> "
    };
    scheduler.templates.timeline_day_date = function(c, b) {
        return dxDateTextString(c)
    };
    scheduler.templates.timeline_week_date = function(c, b) {
        return dxDateTextString(c) + " - " + dxDateTextString(b)
    };
    scheduler.templates.timeline_month_date = function(c, b) {
        return scheduler.date.date_to_str("%F %Y")(c)
    };
    scheduler.templates.timeline_month_2_date = function(c, b) {
        return dxDateTextString(c) + " - " + dxDateTextString(b)
    };
    scheduler.templates.timeline_month_3_date = function(c, b) {
        return dxDateTextString(c) + " - " + dxDateTextString(b)
    };
    scheduler.templates.day_date = function(c, b) {
        return dxDateTextString(c)
    };
    scheduler.templates.week_date = function(c, b) {
        return dxDateTextString(c) + " - " + dxDateTextString(b)
    };
    scheduler.templates.month_date = function(c, b) {
        return scheduler.date.date_to_str("%F %Y")(c)
    }
    scheduler.templates.event_bar_text = function(d, b, c) {
        if (c.project_code) {
            return "[" + c.project_code + "] " + c.text
        } else {
            if (c.project_name) {
                return c.text + " [" + c.project_name + "]"
            } else {
                return c.text
            }
        }
    };
    scheduler.templates.event_text = function(d, b, c) {
        if (c.project_code) {
            return "[" + c.project_code + "] " + c.text
        } else {
            if (c.project_name) {
                return c.text + " [" + c.project_name + "]"
            } else {
                return c.text
            }
        }
    };
});

function block_readonly(b) {
    if (!b) {
        return true
    }
    return !this.getEvent(b).readonly
}
scheduler.attachEvent("onBeforeDrag", block_readonly);
scheduler.attachEvent("onClick", block_readonly);
scheduler.attachEvent("onXLE", function() {
    fixTimelineWidth()
});

scheduler.attachEvent("onViewChange", function(b, c) {
    j(".state").removeClass("active");
    j(".view").removeClass("active");
    a = b.split("_");
    a.forEach(function(d) {
        j(".dhx_" + d).addClass("active")
    });
    if (a.length == 1) {
        j(".dhx_calendar").addClass("active");
        type = "calendar";
        state = a[0]
    } else {
        if (a.length == 2) {
            type = a[0];
            state = a[1]
        } else {
            if (a.length == 3) {
                type = a[0];
                state = a[1] + "_" + a[2]
            }
        }
    }
    j("#state_select").val(state);
    j("#view_select").val(type);
    if (type != "timeline") {
        j("#weekDropdownMenu .dropdown-menu li, #monthDropdownMenu .dropdown-menu li").addClass("disabled")
    } else {
        j("#weekDropdownMenu .dropdown-menu li, #monthDropdownMenu .dropdown-menu li").removeClass("disabled")
    }
});
scheduler.attachEvent("onViewChange", function(b, c) {
    scheduler.config.active_link_view = active_views[b] || "day"
});
scheduler.attachEvent("onBeforeDrag", function(d, c, b) {
    if (b.shiftKey) {
        scheduler.config.multisection_shift_all = true
    }
    return true
});
scheduler.attachEvent("onDragEnd", function() {
    scheduler.config.multisection_shift_all = false
});

/**
 * Parse booking datas
 */
scheduler.parse($bookings, 'json');

/**
 * Init Scheduler
 */
scheduler.init("scheduler", new Date(), "timeline_week");
scheduler.setLoadMode("month");

j(document).ready(function($) {
    // j(".input-group.start-date.date").datepicker('setDate', new Date());
    j(".input-group.start-date.date").datepicker({
        autoclose: true,
        format: dateFormat,
        todayBtn: "linked",
        weekStart: +mondayStart
    }).on("changeDate", function(c) {
        // updateEventStart();
        var b = j(".input-group.end-date.date").data("datepicker");
        endDate = b.getDate();
        endStamp = endDate.getTime();
        startStamp = c.date.getTime();
        if (startStamp > endStamp) {
            j(".input-group.end-date.date").datepicker("update", c.date);
            j(".input-group.repeat-end-date").datepicker("update", c.date);
            // updateEventStart(c.Date);
            // updateEventEnd(endDate);
            // updateDuration()
        }
    }).datepicker("update", new Date());

    // j(".input-group.end-date.date").datepicker('setDate', new Date());
    j(".input-group.end-date.date").datepicker({
        autoclose: true,
        format: dateFormat,
        todayBtn: "linked",
        weekStart: +mondayStart,
    }).on("changeDate", function(b) {
        // updateEventEnd();
    }).on("show", function(b) {
        startDate = j(".input-group.start-date.date").data("datepicker").getDate();
        j(this).data("datepicker").setStartDate(startDate)
    }).datepicker("update", new Date());

    j("#startTime").timepicker({
        showMeridian: timeFormat
    }).on("changeTime.timepicker", function(b) {
        // updateEventStart()
    });

    j("#endTime").timepicker({
        showMeridian: timeFormat
    }).on("changeTime.timepicker", function(b) {
        // updateEventEnd()
    });

    j("#bookingResource").select2({
        minimumInputLength: 0,
        multiple: true,
        allowClear: true,
        placeholder: 'Select Resources',
        width: '100%',
        data: allResources,
    }).bind("change", updateEventResources);

    j("#bookingProject").select2({
        minimumInputLength: 0,
        multiple: false,
        allowClear: true,
        placeholder: 'Select Project',
        width: '100%',
        data: allProjects
    }).bind("change", updateEventProject);

    j("#bookingStatus").select2({
        minimumInputLength: 0,
        multiple: false,
        allowClear: true,
        placeholder: 'Select Project',
        width: '100%',
        data: allStatus
    }).bind("change", updateEventStatus);

    j("#weekDropdownMenu div").mousedown(function(c) {
        switch (c.which) {
            case 1:
                j(this).removeAttr("data-toggle");
                changeState("week");
                break;
            case 3:
                j(this.parentElement).toggleClass("open");
                break;
            default:
        }
    });
    j("#monthDropdownMenu div").mousedown(function(c) {
        switch (c.which) {
            case 1:
                j(this).removeAttr("data-toggle");
                changeState("month");
                break;
            case 3:
                j(this.parentElement).toggleClass("open");
                break;
            default:
        }
    });

    // Switch color mode
    switchColorMode(j("#scheduleColor").val());
    j("#scheduleColor").on("change", function() {
        switchColorMode(this.value);
    });
});

function switchColorMode(c) {
    scheduler.color_mode = c;
    colorMode = c;
    var b = scheduler.getEvents();
    if (colorMode == "status") {
        scheduler.templates.event_class = function(f, d, e) {
            var ev = e;
            var status_id = ev.status_id;
            var status_name = '';
            var status_bg_color = '';
            var status_text_color = '';
            if (status_id != 0 && status_id != null) {
                var s = find_object_with_attr(allStatus, {
                    key: 'id',
                    val: status_id
                });
                // status_name = e[0] !== undefined ? e[0].text : '';
                status_bg_color = s[0] !== undefined ? s[0].colorBg : '';
                status_text_color = s[0] !== undefined ? s[0].colorText : '';
            }
            ev.color = status_bg_color;
            ev.textColor = status_text_color;
            return false
        }
    } else {
        scheduler.templates.event_class = function(f, d, e) {
            e.color = '';
            e.textColor = '';
            return false
        }
    }
    scheduler.setCurrentView();
}

function fixTimelineWidth() {
    if (j(window).width() <= 835) {
        scheduler.matrix.timeline_day.dx = 130;
        scheduler.matrix.timeline_week.dx = 130;
        scheduler.matrix.timeline_month.dx = 130;
        // scheduler.updateView()
    } else {
        scheduler.matrix.timeline_day.dx = 230;
        scheduler.matrix.timeline_week.dx = 230;
        scheduler.matrix.timeline_month.dx = 230;
        // scheduler.updateView()
    }
}

function block_readonly(b) {
    if (!b) {
        return true
    }
    return !this.getEvent(b).readonly
}
function show_minical(){
    if (scheduler.isCalendarVisible())
        scheduler.destroyCalendar();
    else
        scheduler.renderCalendar({
            position:"dhx_minical_icon",
            date:scheduler._date,
            navigation:true,
            handler:function(date,calendar){
                scheduler.setCurrentView(date);
                scheduler.destroyCalendar()
            }
        });
}

function changeState(b) {
    state = b;
    changeView(type)
}

function changeView(c) {
    setType(c);
    var b = state.split("_");
    switch (c) {
        case "calendar":
            scheduler.setCurrentView(scheduler.getState().date, b[0]);
            state = b[0];
            break;
        case "timeline":
            scheduler.setCurrentView(scheduler.getState().date, "timeline_" + state);
            j("#weekDropdownMenu, #monthDropdownMenu").removeClass("open");
            break;
        case "grid":
            scheduler.setCurrentView(scheduler.getState().date, "grid_" + b[0]);
            state = b[0];
            break
    }
}

function setState(b) {
    state = b
}

function setType(b) {
    type = b
}

function openEditForm(b) {
    bookingId = b;
    editor.addClass("visible").animate({
        right: "0"
    }, 100);
    scheduleCont.animate({
        right: "350px",
    }, 100, function() {
        scheduler.updateView()
    });
    j("#dhx_menu_extra_buttons").css("display", "none");
    var ev = scheduler.getEvent(b);

    var flag = false;
    for( var i = 0; i < $bookings.length; i++ ) {
        if( $bookings[i].id == ev.id ) 
            flag = true;
    }

    if( ! flag ) {
        var $dateFrom = ev.start_date;
        $dateFrom.setHours(0);

        var $dateTo = ev.end_date;
        $dateTo.setHours(0);

        $dateTo.setDate( $dateTo.getDate() + 1 );
        var timeDiff = Math.abs($dateTo - $dateFrom);
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        if( diffDays > 1 ) {
            $dateTo.setDate( $dateTo.getDate() - diffDays + 1 );
        }
        ev.start_date = $dateFrom;
        ev.end_date = $dateTo;
    }

    j('#bookingName').val(ev.text);
    
    j(".input-group.start-date.date").datepicker('setDate', ev.start_date);
    j(".input-group.end-date.date").datepicker('setDate', ev.end_date);
    j("#startTime").timepicker('setTime', ev.start_date);
    j("#endTime").timepicker('setTime', ev.end_date);

    j('#bookingNotes').val('');
    j('#bookingResource').val('').trigger('change');
    j("#bookingProject").val('').trigger('change');
    j("#bookingStatus").val('').trigger('change');

    if( ev.notes !== undefined )
        j('#bookingNotes').val(ev.notes);
    if( ev.users !== undefined )
        j('#bookingResource').val(ev.users).trigger('change');
    if( ev.project_id !== undefined )
        j("#bookingProject").val(ev.project_id).trigger('change');
    if( ev.status_id !== undefined )
        j("#bookingStatus").val(ev.status_id).trigger('change');
    scheduler.startLightbox(b, html("schedule-editor"));
}

function closeEditForm(check = false) {
    bookingId = '';
    editor.removeClass("visible").animate({
        right: "-500px"
    });
    scheduleCont.animate({
        right: "0"
    }, 100, function() {
        scheduler.updateView()
    });
    j("#dhx_menu_extra_buttons").css("display", "inline-block");
    lockEditForm();
    j("body input, body select, body textarea").removeClass("changed-input");
    scheduler.endLightbox(check, html("schedule-editor"));
}

function lockEditForm(b) {
    j(".panel-group input, .panel-group textarea, .panel-group select, #saveButton, #saveCloseButton, #directionButtons").prop("disabled", true);
    return true
}

function unlockEditForm(b) {
    j(".panel-group input, .panel-group textarea, .panel-group select, #saveButton, #saveCloseButton, #directionButtons").prop("disabled", false);
    return true
}

function save_form() {
    var booking_id = scheduler.getState().lightbox_id;
    var ev = scheduler.getEvent(booking_id);

    var startDatepicker = j(".input-group.start-date.date").data("datepicker").getDate();
    var endDatepicker = j(".input-group.end-date.date").data("datepicker").getDate();
    if( startDatepicker === undefined && endDatepicker === undefined ) 
        return false;
    var startDate = (startDatepicker.getMonth() + 1) + '/' + startDatepicker.getDate() + '/' +  startDatepicker.getFullYear() + " " + document.getElementById("startTime").value;
    var endDate = (endDatepicker.getMonth() + 1) + '/' + endDatepicker.getDate() + '/' +  endDatepicker.getFullYear() + " " + document.getElementById("endTime").value;
    var bookingName = document.getElementById("bookingName").value;
    var project_id = document.getElementById("bookingProject").value;
    var bookingResource = j("#bookingResource").select2('val');
    var bookingNotes = document.getElementById("bookingNotes").value;

    if( bookingResource.length == 0 )
        bookingResource = [0];

    project_id = project_id == '' ? null : parseInt(project_id);
    var project_code = '';
    var project_name = '';
    if (project_id != 0 && project_id != null) {
        var e = find_object_with_attr(allProjects, {
            key: 'id',
            val: project_id
        });
        project_name = e[0].text;
        project_code = e[0].code
    }
    var status_id = document.getElementById("bookingStatus").value;
    status_id = status_id == '' ? null : parseInt(status_id);
    var status_name = '';
    var status_bg_color = '';
    var status_text_color = '';
    if (status_id != 0 && status_id != null) {
        var e = find_object_with_attr(allStatus, {
            key: 'id',
            val: status_id
        });
        status_name = e[0].text;
        status_bg_color = e[0].colorBg;
        status_text_color = e[0].colorText;
    }

    j.ajax({
        headers: {
            'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
        },
        url: HOST_URL + '/admin/schedules/create',
        dateType: 'json',
        type: 'POST',
        async: false,
        data: {
            id: booking_id,
            name: bookingName,
            start_date_time: startDate,
            end_date_time: endDate,
            users: bookingResource,
            project_id: project_id,
            status_id: status_id,
            notes: bookingNotes
        },
        success: function( response ) {
            ev.text = bookingName;
            var F = [];
            for ( var i = 0; i < bookingResource.length; i++ ) {
                var c = find_object_with_attr(allResources, {
                    key: "id",
                    val: bookingResource[i]
                });
                if( c.length > 0 )
                    F[i] = c[0].text;
            }

            ev.start_date = new Date(startDate);
            ev.end_date = new Date(endDate);
            ev.project_id = project_id;
            ev.project_code = project_code;
            ev.project_name = project_name;
            ev.status_id = status_id;
            ev.status_name = status_name;
            ev.users = bookingResource;
            ev.resource_name = F.join(", ");
            ev.notes = bookingNotes;
            ev.color = status_bg_color;
            ev.textColor = status_text_color;
            closeEditForm(true);
            j.notify( _saved_changes, 'success' );
        },
        error: function (data, textStatus, errorThrown) {
            j.notify( _error_saving_booking, 'error' );
        }
    });
    return false;
}

function updateEventResources() {
    var b = j("#bookingResource").select2("val");
    if (b.length > 0) {
        // scheduler.getEvent(bookingId).users = b.join(",");
        // scheduler.updateEvent(bookingId)
        // scheduler.getEvent(bookingId).users = b;
    }
}

function updateEventProject() {
}

function updateEventStatus() {
}

function find_object_with_attr(d, b) {
    var e = [];
    for (var c in d) {
        if (!d.hasOwnProperty(c)) {
            continue
        }
        if (d[c] && typeof d[c] == "object") {
            e = e.concat(find_object_with_attr(d[c], b))
        } else {
            if (c == b.key && d[b.key] == b.val) {
                e.push(d)
            }
        }
    }
    return e
}

function makeUL(e) {
    var d = document.createElement("div");
    for (var b = 0; b < e.length; b++) {
        var c = document.createElement("span");
        c.className = "label label-primary";
        c.appendChild(document.createTextNode(e[b]));
        d.appendChild(c)
    }
    return d
}