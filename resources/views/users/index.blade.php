@extends('adminlte::page')

@section('content')

        <div class="row">

            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Users</h3>
                        @if (Auth::user()->role == config('user.role.admin'))
                        <a href="{{ url('/users/create') }}" class="btn btn-success btn-sm" title="Add New User">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <a href="{{ url('/export-user') }}" class="btn btn-success btn-sm" title="Export User">
                            <i aria-hidden="true"></i> Export User
                        </a>
                        @endif
                        <div class="box-tools">
                            {!! Form::open(['method' => 'GET', 'url' => '/users', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
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
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(Auth::user()->role == config('user.role.admin'))
                                    @foreach($users as $item)
                                        <tr>
                                            <td>{{ $loop->iteration or $item->id }}</td>
                                            <td>{{ $item->firstname }}</td>
                                            <td>{{ $item->lastname }}</td>
                                            <td>{{ $item->email }}</td>
                                            @if($item->role == config('user.role.admin'))
                                                <td> Admin </td>
                                            @endif
                                            @if($item->role == '1')
                                                <td> Driver </td>
                                            @endif
                                            @if($item->role == '2')
                                                <td> Booking Manager </td>
                                            @endif
                                            <td>
                                                <a href="{{ url('/users/' . $item->id) }}" title="View User"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                <a href="{{ url('/users/' . $item->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                                @if($item->role != config('user.role.admin'))
												{!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/users', $item->id],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete User',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                                {!! Form::close() !!}
												@endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                                @foreach($users as $item)
                                    @if (Auth::user()->role != config('user.role.admin') && $item->id == Auth::user()->id)
                                        <tr>
                                            <td>{{ $loop->iteration or $item->id }}</td>
                                            <td>{{ $item->firstname }}</td>
                                            <td>{{ $item->lastname }}</td>
                                            <td>{{ $item->email }}</td>
                                            @if($item->role == '1')
                                                <td> Driver </td>
                                            @else
                                                <td> Booking Manager </td>
                                            @endif
                                            <td>{{ $item->year }}</td>
                                            <td>{{ $item->module }}</td>
                                            <td>{{ $item->category }}</td>
                                            <td>
                                                <a href="{{ url('/users/' . $item->id) }}" title="View User"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                <a href="{{ url('/users/' . $item->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $users->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection
