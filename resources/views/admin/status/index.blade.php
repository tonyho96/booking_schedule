@extends('adminlte::page')

@section('content')

        <div class="row">

            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Status</h3>

                        <a href="{{ url('/admin/status/create') }}" class="btn btn-success btn-sm" title="Add New Status">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <div class="box-tools">
                            {!! Form::open(['method' => 'GET', 'url' => '/admin/status', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
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


                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Color Background</th>
                                        <th>Color Text</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($status as $item)
                                    <tr>
                                        <td>{{ $item["id"] }}</td>
                                        <td>{{ $item["name"] }}</td>
                                        <td>
                                            {!! Form::model($item, [
                                                'method' => 'PATCH',
                                                'url' => ['/admin/status', $item["id"]],
                                                'class' => 'form-horizontal',
                                                'files' => true
                                            ]) !!}

                                            {!! Form::color('color_background', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                                            {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Update', ['class' => 'btn btn-primary']) !!}


                                            {!! Form::close() !!}
                                            {{--{{ $item['color_background'] }}--}}
                                        </td>
                                        <td>
                                            {!! Form::model($item, [
                                                'method' => 'PATCH',
                                                'url' => ['/admin/status', $item["id"]],
                                                'class' => 'form-horizontal',
                                                'files' => true
                                            ]) !!}

                                            {!! Form::color('color_text', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                                            {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Update', ['class' => 'btn btn-primary']) !!}


                                            {!! Form::close() !!}
                                            {{--{{ $item['color_text'] }}--}}
                                        </td>
                                        <td>
                                            <a href="{{ url('/admin/status/' . $item["id"]) }}" title="View Status"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/status/' . $item["id"] . '/edit') }}" title="Edit Status"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/admin/status', $item["id"]],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Status',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--<div class="pagination-wrapper"> {!! $status->appends(['search' => Request::get('search')])->render() !!} </div>--}}
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection
