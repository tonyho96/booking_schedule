@extends('adminlte::page')

@section('content')

        <div class="row">

            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        Edit Staff #{{ $project["id"] }}
                    </div>

                    <div class="box-body">
                        <a href="{{ url('/admin/projects') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($project, [
                            'method' => 'PATCH',
                            'url' => ['/admin/projects', $project["id"]],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('admin.projects.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

@endsection
