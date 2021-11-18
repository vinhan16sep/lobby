<style>
  #selector:before {
    display: none;
  }
</style>
<div class="box box-default {{ (Request::segment(3) == 'search')? '' : 'collapsed-box' }}">
  <div class="box-header with-border">
    <button type="button" class="btn btn-box-tool" data-widget="collapse"><h3 class="box-title fa fa-minus">&nbsp&nbsp&nbsp{{isset($title) ? $title : 'Search'}}</h3></button>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    {{ $slot }}
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    <button type="submit" class="btn btn-primary">
      <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
      OK
    </button>
  </div>
</div>
