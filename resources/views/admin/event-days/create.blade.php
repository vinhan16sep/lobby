@extends('admin.event-days.base')

@section('action-content')
    <div class="content">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Thêm mới ngày sự kiện</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('event-days.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('event_date') ? ' has-error' : '' }}">
                                <label for="event_date" class="col-md-4 control-label">Ngày sự kiện</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="event_date" placeholder="" id="event_date" value="{{ old('event_date') }}">
                                    {{-- <input id="event_date" type="text" class="form-control" name="event_date" value="{{ old('event_date') }}" required autofocus> --}}

                                    @if ($errors->has('event_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('event_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <input type="hidden" name="is_active" value="0">
                            <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                <label for="is_active" class="col-md-4 control-label">Active?</label>

                                <div class="col-md-6">
                                    <input id="is_active" type="checkbox" class="minimal" name="is_active" value="1" checked
                                           @if(old('is_active') == 1)
                                           checked
                                            @endif
                                    >
                                    @if ($errors->has('is_active'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('is_active') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        OK
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#event_date').datepicker({
            // autoclose: true,
            format: 'yyyy-mm-dd'
        });
    </script>
@endsection
