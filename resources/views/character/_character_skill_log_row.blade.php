<div class="d-flex row flex-wrap col-12 mt-1 pt-1 px-0 ubt-top">
  <div class="col-4 col-md-2">{!! $log->sender ? $log->sender->displayName : '' !!}</div>
  <div class="col-4 col-md-4">{!! $log->log !!}</div>
  <div class="col-4 col-md-4">{!! $log->data !!}</div>
  <div class="col-4 col-md-2">{!! pretty_date($log->created_at) !!}</div>
</div>
