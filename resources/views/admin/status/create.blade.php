@extends('adminlte::page')

@section('content')

        <div class="row">

            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Create New Status</h3>
                    </div>
                    <div class="box-body">
                        <a href="{{ url('/admin/status') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/admin/status', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('admin.status.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

@endsection
