@extends('user.layout', ['user' => isset($user) ? $user : null])

@section('profile-title')
    {{ $user->name }}'s Profile
@endsection

@section('meta-img')
    {{ asset('/images/avatars/' . $user->avatar) }}
@endsection

@section('profile-content')
    {!! breadcrumbs(['Users' => 'users', $user->name => $user->url]) !!}

@if($user->is_banned)
    <div class="alert alert-danger">This user has been banned.</div>
@endif
<h1>
    <img src="/images/avatars/{{ $user->avatar }}" style="width:125px; height:125px; float:left; border-radius:50%; margin-right:25px;">
    {!! $user->displayName !!}
    {!! $user->isOnline() !!}
    <a href="{{ url('reports/new?url=') . $user->url }}"><i class="fas fa-exclamation-triangle fa-xs" data-toggle="tooltip" title="Click here to report this user." style="opacity: 50%; font-size:0.5em;"></i></a>

    @if ($user->is_banned)
        <div class="alert alert-danger">This user has been banned.</div>
    @endif

    @if ($user->is_deactivated)
        <div class="alert alert-info text-center">
            <h1>{!! $user->displayName !!}</h1>
            <p>This account is currently deactivated, be it by staff or the user's own action. All information herein is hidden until the account is reactivated.</p>
            @if (Auth::check() && Auth::user()->isStaff)
                <p class="mb-0">As you are staff, you can see the profile contents below and the sidebar contents.</p>
            @endif
        </div>
    @endif

    @if (!$user->is_deactivated || (Auth::check() && Auth::user()->isStaff))
        @include('user._profile_content', ['user' => $user, 'deactivated' => $user->is_deactivated])
    @endif

@endsection
