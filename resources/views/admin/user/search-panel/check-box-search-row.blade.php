<div class="row">
  @php
    $index = 0;
  @endphp
  @foreach ($items as $item)
    <div class="col-md-3">
      <div class="form-group">
          @php
            $stringFormat =  strtolower(str_replace(' ', '', $item));

            if($stringFormat == 'special'){
                $label = 'Đặc biệt?';
            }elseif($stringFormat == 'new'){
                $label = 'Mới?';
            }else{
                $label = $stringFormat;
            }
          @endphp
          <label for="input<?=$stringFormat?>" class="col-sm-4 control-label">{{$label}}</label>
          <div class="col-sm-3">
            <input value="{{isset($oldVals) ? $oldVals[$index] : ''}}" type="checkbox" name="<?=$stringFormat?>" id="input<?=$stringFormat?>" placeholder="{{$label}}" >
          </div>
      </div>
    </div>
  @php
    $index++;
  @endphp
  @endforeach
</div>