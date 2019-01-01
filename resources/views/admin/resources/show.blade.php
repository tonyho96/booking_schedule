@extends('adminlte::page')

@section('content')

        <div class="row">

            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Resource {{ $resource["id"] }}</h3>
                    </div>
                    <div class="box-body">

                        <a href="{{ url('/admin/resources') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/resources/' . $resource["id"] . '/edit') }}" title="Edit Resource"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/resources', $resource["id"]],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete Resource',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><th> ID </th><td>{{ $resource["id"] }}</td></tr>
                                    <tr><th> Name </th><td> {{ $resource["name"] }} </td></tr>
                                    <tr><th> Description </th><td> {{ $resource["description"] }} </td></tr>
                                    {{--<tr><th> Type_ID </th><td> {{ $resource["type_id"] }} </td></tr>--}}
                                    {{--<tr><th> Parent_ID </th><td> {{ $resource["parent_id"] }} </td></tr>--}}
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection
