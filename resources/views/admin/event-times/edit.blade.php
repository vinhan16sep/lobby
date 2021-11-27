@extends('admin.event-times.base')

@section('action-content')
    <div class="content">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cập nhật danh mục sản phẩm</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('event-times.update', ['id' => $detail['id']]) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('event_day_id') ? ' has-error' : '' }}">
                                <label for="event_day_id" class="col-md-4 control-label">Ngày sự kiện <span style="color:red;">*</span></label>
                                <div class="col-md-6">
                                    <select name="event_day_id"  class="form-control type">
                                        <option value="">Chọn ngày sự kiện</option>
                                        @foreach($eventDays as $value)
                                            <option value="{{ $value->id }}" {{ $detail['event_day_id'] == $value->id ? 'selected' : '' }} >{{ $value->event_date }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('event_day_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('event_day_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('start_time') ? ' has-error' : '' }}">
                                <label for="start_time" class="col-md-4 control-label">Giờ bắt đầu <span style="color:red;">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group bootstrap-timepicker">
                                        <input id="start_time" name="start_time" type="text" class="form-control" value="{{ $detail['start_time'] }}">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    @if ($errors->has('start_time'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('start_time') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('end_time') ? ' has-error' : '' }}">
                                <label for="end_time" class="col-md-4 control-label">Giờ kết thúc <span style="color:red;">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group bootstrap-timepicker">
                                        <input id="end_time" name="end_time" type="text" class="form-control" value="{{ $detail['end_time'] }}">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    @if ($errors->has('end_time'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('end_time') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <input type="hidden" name="is_active" value="0">
                            <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                <label for="is_active" class="col-md-4 control-label">Active?</label>

                                <div class="col-md-6">
                                    <input id="is_active" type="checkbox" class="minimal" name="is_active" value="1"
                                           @if($detail['is_active'] == 1)
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
        $('#start_time').timepicker({
            minuteStep: 1,
            secondStep: 5,
            showInputs: false,
            template: 'dropdown',
            modalBackdrop: true,
            showSeconds: false,
            showMeridian: false
        });
        $('#end_time').timepicker({
            minuteStep: 1,
            secondStep: 5,
            showInputs: false,
            template: 'dropdown',
            modalBackdrop: true,
            showSeconds: false,
            showMeridian: false
        });
    </script>
@endsection
