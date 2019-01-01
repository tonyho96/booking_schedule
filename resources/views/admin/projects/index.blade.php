@extends('adminlte::page')

@section('content')

        <div class="row">

            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Projects</h3>

                        <a href="{{ url('/admin/projects/create') }}" class="btn btn-success btn-sm" title="Add New Project">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <div class="box-tools">
                            {!! Form::open(['method' => 'GET', 'url' => '/admin/projects', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search" class="form-control pull-right" placeholder="Search" value="{{ request('search') }}">

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
                                        <th>Initials</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        {{--<th>Start_Timestamp</th>--}}
                                        {{--<th>End_Timestamp</th>--}}
                                        {{--<th>Private</th>--}}
                                        {{--<th>Parent_Folder_ID</th>--}}
                                        {{--<th>Client_Person_ID</th>--}}
                                        {{--<th>Client_Organization_ID</th>--}}
                                        {{--<th>Project_Order</th>--}}
                                        <th>Color Background</th>
                                        <th>Color Text</th>
                                        {{--<th>Color_Text</th>--}}
                                        {{--<th>Created_ID</th>--}}
                                        {{--<th>Created</th>--}}
                                        {{--<th>Updated_ID</th>--}}
                                        {{--<th>Updated</th>--}}
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <td>{{ $project['id'] }}</td>
                                        <td>{{ $project['name'] }}</td>
                                        <td>{{ $project['code'] }}</td>
                                        <td>{{ $project['description'] }}</td>
                                        <td>{{ $project['status_id'] ? 'Active' : 'Inactive' }}</td>
                                        {{--<td>{{ $project['start_timestamp'] }}</td>--}}
                                        {{--<td>{{ $project['end_timestamp'] }}</td>--}}
                                        {{--<td>{{ $project['private'] }}</td>--}}
                                        {{--<td>{{ $project['parent_folder_id'] }}</td>--}}
                                        {{--<td>{{ $project['client_person_id'] }}</td>--}}
                                        {{--<td>{{ $project['client_organization_id'] }}</td>--}}
                                        {{--<td>{{ $project['project_order'] }}</td>--}}
                                        <td>
                                            {!! Form::model($project, [
                                                'method' => 'PATCH',
                                                'url' => ['/admin/projects', $project["id"]],
                                                'class' => 'form-horizontal',
                                                'files' => true
                                            ]) !!}

                                            {!! Form::color('color_background', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                                            {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Update', ['class' => 'btn btn-primary']) !!}


                                            {!! Form::close() !!}
                                            {{--{{ $project['color_background'] }}--}}
                                        </td>
                                        <td>
                                            {!! Form::model($project, [
                                                'method' => 'PATCH',
                                                'url' => ['/admin/projects', $project["id"]],
                                                'class' => 'form-horizontal',
                                                'files' => true
                                            ]) !!}

                                            {!! Form::color('color_text', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
                                            {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Update', ['class' => 'btn btn-primary']) !!}


                                            {!! Form::close() !!}
                                            {{--{{ $project['color_text'] }}--}}
                                        </td>
                                        {{--<td>{{ $project['color_text'] }}</td>--}}
                                        {{--<td>{{ $project['created_id'] }}</td>--}}
                                        {{--<td>{{ $project['created'] }}</td>--}}
                                        {{--<td>{{ $project['updated_id'] }}</td>--}}
                                        {{--<td>{{ $project['updated'] }}</td>--}}
                                        <td>
                                            <a href="{{ url('/admin/projects/' . $project['id']) }}" title="View Project"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/projects/' . $project['id'] . '/edit') }}" title="Edit Project"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/admin/projects', $project['id']],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Project',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper">
                                {{--{!! $projects->appends(['search' => Request::get('search')])->render() !!} --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection
