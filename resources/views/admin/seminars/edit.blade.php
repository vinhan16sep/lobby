@extends('admin.seminars.base')

@section('action-content')
    <div class="content">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cập nhật danh mục sản phẩm</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('seminars.update', ['id' => $detail['id']]) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('event_day_id') ? ' has-error' : '' }}">
                                <label for="event_day_id" class="col-md-4 control-label">Ngày sự kiện <span style="color:red;">*</span></label>
                                <div class="col-md-2">
                                    <select name="event_day_id"  class="form-control event-days">
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
                            <div class="form-group{{ $errors->has('event_time_id') ? ' has-error' : '' }}">
                                <label for="event_time_id" class="col-md-4 control-label">Giờ sự kiện <span style="color:red;">*</span></label>
                                <div class="col-md-2">
                                    <select name="event_time_id"  class="form-control event-times">
                                        <option value="">Chọn giờ sự kiện</option>
                                        @foreach($eventTimes as $value)
                                            <option
                                                value="{{ $value->id }}"
                                                {{ $detail['event_time_id'] == $value->id ? 'selected' : '' }}
                                            >
                                                {{ $value->start_time }} ~ {{ $value->end_time }}
                                            </option>
                                        @endforeach
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
                                           @if($detail['is_main'] == 1)
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
                                        <input id="name" name="name" type="text" class="form-control" value="{{ $detail['name'] }}">
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
                                        <input id="link" name="link" type="text" class="form-control" value="{{ $detail['link'] }}">
                                    </div>
                                    @if ($errors->has('link'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="avatar" class="col-md-4 control-label" >Hình ảnh đang dùng</label>
                                <div class="col-md-6">
                                    <div class="img-mask">
                                        <img src="{{ asset('uploads/seminars/' . $detail['image']) }}"
                                             width="300" height="200"
                                             alt="{{ $detail['name'] }}"/>
                                    </div>
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
                                    <textarea id="description" rows="10" class="form-control" name="description">{{ $detail['description'] }}</textarea>

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
@endsection
