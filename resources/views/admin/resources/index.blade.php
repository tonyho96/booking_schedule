@extends('adminlte::page')

@section('content')

    <div class="loader-container">
        <div class="loader"></div>
    </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Resources</h3>

                        <a href="{{ url('/admin/resources/create') }}" class="btn btn-success btn-sm" title="Add New Resource">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <div class="box-tools">
                            {!! Form::open(['method' => 'GET', 'url' => '/admin/resources', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search" value="{{ request('search') }}">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="alert alert-success alert-dismissible change-order-success" style="display: none">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Successfully</strong> change order
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless" id="resource-listing">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        {{--<th>Type_ID</th>--}}
                                        {{--<th>Parent_ID</th>--}}
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($resources as $item)
                                    <tr>
                                        <td>{{ $item["id"] }}</td>
                                        <td class="handle order-controller">{{ $item["name"] }}</td>
                                        <td>{{ $item["description"] }}</td>
                                        {{--<td>{{ $item["type_id"] }}</td>--}}
                                        {{--<td>{{ $item["parent_id"] }}</td>--}}
                                        <td>
                                            <a href="{{ url('/admin/resources/' . $item["id"]) }}" title="View Resource"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/resources/' . $item["id"] . '/edit') }}" title="Edit Resource"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/admin/resources', $item["id"]],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Resource',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--<div class="pagination-wrapper"> {!! $resources->appends(['search' => Request::get('search')])->render() !!} </div>--}}
                        </div>


                    </div>
                </div>
            </div>
        </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            var el = document.getElementById('resource-listing');
            var dragger = tableDragger(el, {
                mode: 'row',
                dragHandler: '.handle',
                onlyBody: true
//                animation: 300
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            dragger.on('drop',function(from, to){
                console.log(from);
                console.log(to);
                formData = JSON.stringify({
                    from: from,
                    to: to
                });
                $('.loader-container').css('display', 'block');
                $('.change-order-success').css('display', 'none');

                var url = '/admin/resources/order';
                $.ajax({
                    url: url,
                    type: 'POST',
                    contentType: 'application/json',
                    data: formData,
                    success: function(response){
                        result = JSON.parse(response);
                        console.log(result.data);
                        $('.loader-container').css('display', 'none');
                        $('.change-order-success').css('display', 'block');
                    },
                    error: function (req, status, err) {
                        console.log('Something went wrong', status, err);
                    }
                });
            });
        });
    </script>
@endsection

@section('css')
<style>
    .loader-container {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 9999;
        background-color: rgba(0,0,0,0.3);
        display: none;
    }
    .loader {
        position: fixed;
        top: 50%;
        left: 50%;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection