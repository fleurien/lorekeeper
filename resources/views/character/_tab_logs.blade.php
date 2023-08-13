<h3>Ownership History</h3>

{!! $character->getOwnershipLogs(0)->render() !!}
<div class="row ml-md-2 mb-4">
  <div class="d-flex row flex-wrap col-12 mt-1 pt-1 px-0 ubt-bottom">
    <div class="col-6 col-md font-weight-bold">Sender</div>
    <div class="col-6 col-md font-weight-bold">Recipient</div>
    <div class="col-6 col-md-4 font-weight-bold">Log</div>
    <div class="col-6 col-md font-weight-bold">Date</div>
  </div>
    @foreach($character->getOwnershipLogs(0) as $log)
        @include('user._ownership_log_row', ['log' => $log, 'user' => $character->user])
    @endforeach
</div>
{!! $character->getOwnershipLogs(0)->render() !!}
