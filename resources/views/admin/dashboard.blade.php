@extends('admin.layouts.app-template')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">ADMIN Dashboard</div>

                    <div class="panel-body">
                        @component('components.who')
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
