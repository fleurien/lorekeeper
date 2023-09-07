@if ($deactivated)
    <div style="filter:grayscale(1); opacity:0.75">
@endif


@if (isset($user->profile->parsed_text))
    <div class="card mb-3" style="clear:both;">
        <div class="card-body">
            {!! $user->profile->parsed_text !!}
        </div>
    </div>
@endif

<div class="card-deck mb-4 profile-assets" style="clear:both;">
    <div class="card profile-inventory profile-assets-card">
    <div class="card-body text-center">
            <h5 class="card-title">Completed Collections</h5>
            <div class="profile-assets-content">
                @if(count($collections))
                    <div class="row">
                        @foreach($collections as $collection)
                            <div class="col-md-3 col-6 profile-inventory-item">
                                @if($collection->imageUrl)
                                    <img src="{{ $collection->imageUrl }}" data-toggle="tooltip" title="{{ $collection->name }}" alt="{{ $collection->name }}"/>
                                @else
                                    <p>{{ $collection->name }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                
            </div>
            <div class="text-right"><a href="{{ $user->url.'/armoury' }}">View all...</a></div>
        </div>
    </div>
</div>
                    <div>No collections completed.</div>
                @endif
            </div>
            <div class="text-right"><a href="{{ $user->url.'/collection-logs' }}">View all...</a></div>
        </div>
</div>
<div class="card mb-3">
        <div class="card-body text-center">
            <h5 class="card-title">Award case</h5>
            <div class="card-body">
                @if(count($awards))
                    <div class="row">
                        @foreach($awards as $award)
                            <div class="col-md-3 col-6 profile-inventory-item">
                                @if($award->imageUrl)
                                    <img src="{{ $award->imageUrl }}" data-toggle="tooltip" title="{{ $award->name }}" />
                                @else
                                    <p>{{ $award->name }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div>No {{ __('awards.awards') }} earned.</div>
                @endif
            </div>
            <div class="text-right"><a href="{{ $user->url.'/awardcase' }}">View all...</a></div>
        </div>
    </div>
</div>

<h2>
    <a href="{{ $user->url . '/characters' }}">Characters</a>
    @if (isset($sublists) && $sublists->count() > 0)
        @foreach ($sublists as $sublist)
            / <a href="{{ $user->url . '/sublist/' . $sublist->key }}">{{ $sublist->name }}</a>
        @endforeach
    @endif
</h2>

@foreach ($characters->take(4)->get()->chunk(4) as $chunk)
    <div class="row mb-4">
        @foreach ($chunk as $character)
            <div class="col-md-3 col-6 text-center">
                <div>
                    <a href="{{ $character->url }}"><img src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" alt="{{ $character->fullName }}" /></a>
                </div>
                <div class="mt-1">
                    <a href="{{ $character->url }}" class="h5 mb-0">
                        @if (!$character->is_visible)
                            <i class="fas fa-eye-slash"></i>
                        @endif {{ Illuminate\Support\Str::limit($character->fullName, 20, $end = '...') }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endforeach





<div class="text-right"><a href="{{ $user->url . '/characters' }}">View all...</a></div>
<hr>

<h2>
        Gallery
    </h2>

    @if ($user->gallerySubmissions->count())

        <div class="d-flex align-content-around flex-wrap mb-2">
            @foreach ($user->gallerySubmissions as $submission)
                @include('galleries._thumb', ['submission' => $submission, 'gallery' => false])
            @endforeach
        </div>

        
    @else
        <p>No submissions found!</p>
    @endif
    <div class="text-right"><a href="{{ $user->url . '/gallery' }}">View all...</a></div>

    <hr>

<div class="row">
    <div class="col-md-8">

        @comments(['model' => $user->profile, 'perPage' => 5])

    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Mention This User</h5>
            </div>
            <div class="card-body">
                In the rich text editor:
                <div class="alert alert-secondary">
                    {{ '@' . $user->name }}
                </div>
                In a comment:
                <div class="alert alert-secondary">
                    [{{ $user->name }}]({{ $user->url }})
                </div>
                <hr>
                <div class="my-2"><strong>For Names and Avatars:</strong></div>
                In the rich text editor:
                <div class="alert alert-secondary">
                    {{ '%' . $user->name }}
                </div>
                In a comment:
                <div class="alert alert-secondary">
                    [![{{ $user->name }}'s Avatar]({{ asset('/images/avatars/' . $user->avatar) }})]({{ $user->url }}) [{{ $user->name }}]({{ $user->url }})
                </div>
            </div>
            @if (Auth::check() && Auth::user()->isStaff)
                <div class="card-footer">
                    <h5>[ADMIN]</h5>
                    Permalinking to this user, in the rich text editor:
                    <div class="alert alert-secondary">
                        [user={{ $user->id }}]
                    </div>
                    Permalinking to this user's avatar, in the rich text editor:
                    <div class="alert alert-secondary">
                        [userav={{ $user->id }}]
                    </div>
                </div>
            @endif
        </div>
    </div>


@if ($deactivated)
    </div>
@endif
