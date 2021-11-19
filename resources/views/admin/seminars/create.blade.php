@extends('admin.seminars.base')

@section('action-content')
    <div class="content">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Thêm mới hội thảo</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('seminars.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('event_day_id') ? ' has-error' : '' }}">
                                <label for="event_day_id" class="col-md-4 control-label">Ngày sự kiện <span style="color:red;">*</span></label>
                                <div class="col-md-2">
                                    <select name="event_day_id"  class="form-control event-days">
                                        <option value="">Chọn ngày sự kiện</option>
                                        @foreach($eventDays as $value)
                                            <option value="{{ $value->id }}" {{ old('event_day_id') == $value->id ? 'selected' : '' }} >{{ $value->event_date }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('event_day_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('event_day_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('event_time_id') ? ' has-error' : '' }}">
                                <label for="event_time_id" class="col-md-4 control-label">Giờ sự kiện <span style="color:red;">*</span></label>
                                <div class="col-md-2">
                                    <select name="event_time_id"  class="form-control event-times">
                                        <option value="">Chọn giờ sự kiện</option>
                                    </select>
                                    @if ($errors->has('event_time_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('event_time_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="is_main" value="0">
                            <div class="form-group{{ $errors->has('is_main') ? ' has-error' : '' }}">
                                <label for="is_main" class="col-md-4 control-label">Hội thảo chính?</label>

                                <div class="col-md-6">
                                    <input id="is_main" type="checkbox" class="minimal" name="is_main" value="1"
                                           @if(old('is_main') == 1)
                                           checked
                                            @endif
                                    >
                                    @if ($errors->has('is_main'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('is_main') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Tên hội thảo <span style="color:red;">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group" style="width:100%">
                                        <input id="name" name="name" type="text" class="form-control">
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                                <label for="link" class="col-md-4 control-label">Link <span style="color:red;">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group" style="width:100%">
                                        <input id="link" name="link" type="text" class="form-control">
                                    </div>
                                    @if ($errors->has('link'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image" class="col-md-4 control-label" >Hình ảnh</label>
                                <div class="col-md-6">
                                    <input type="file" id="image" name="image"  >
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Giới thiệu ngắn</label>

                                <div class="col-md-6">
                                    <textarea id="description" rows="10" class="form-control" name="description" value="{{ old('description') }}"  autofocus></textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
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
        if ($('.event-days').val()) {
            getEventTime($('.event-days').val());
        }
        $('.event-days').change(function(){
            var eventDay = $(this).val();
            getEventTime(eventDay);
        });
        function getEventTime(eventDay) {
            $.ajax({
                url: '{{ route('event-times.getByEventDay') }}',
                method: 'GET',
                data: {
                    eventDay : eventDay
                },
                success: function(res){
                    var eventTimes = res.eventTimes;
                    $('.event-times').html('');
                    $('.event-times').append('<option value="">Chọn giờ sự kiện</option>');
                    $.each(eventTimes, function(key, value){
                        $('.event-times').append('<option value="' + value.id + '">' + value.start_time + '~' + value.end_time + '</option>');
                    });
                },
            });
        }
    </script>
@endsection
