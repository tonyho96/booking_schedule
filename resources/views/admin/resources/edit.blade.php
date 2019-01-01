@extends('adminlte::page')

@section('content')

        <div class="row">

            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        Edit Resource #{{ $resource["id"] }}
                    </div>

                    <div class="box-body">
                        <a href="{{ url('/admin/resources') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($resource, [
                            'method' => 'PATCH',
                            'url' => ['/admin/resources', $resource["id"]],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('admin.resources.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

@endsection
