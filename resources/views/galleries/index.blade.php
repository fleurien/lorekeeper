@extends('galleries.layout')

@section('gallery-title')
    Home
@endsection

@section('gallery-content')
    {!! breadcrumbs(['Gallery' => 'gallery']) !!}
    <h1>
        @if (Config::get('lorekeeper.extensions.show_all_recent_submissions.enable') && Config::get('lorekeeper.extensions.show_all_recent_submissions.links.indexbutton'))
            <div class="float-right">
                <a class="btn btn-primary" href="gallery/all">
                    All Recent Submissions
                </a>
            </div>
        @endif
        Gallery
    </h1>
    <div class="row" ">
    
    <div class="col-sm-12 col-md-4">
        <img src="https://poffinsworld.com/files/SITEDECOR/gallerypic.png" class="img-fluid">
    </div>
    <div class="col-sm-12 col-md-6">
        <center>
        <h2 class><b>Let's get creative!</b></h2>
       <p> Welcome to the gallery! Here, you can submit art of poffins you've drawn for both Star Tears and steps for exploring!</p>
        <p>Don't feel like booting up an art program, or just don't have one handy? You can use <b><a href="/oekaki">the oekaki board!</a></b></p>
        <p>Take a looksee, and see what kind of things the community has created!</p>
        </center>
    </div>
    
</div>
    @if ($galleries->count())
        {!! $galleries->render() !!}

        @foreach ($galleries as $gallery)
            <div class="card mb-4">
                <div class="card-header">
                    <h4>
                        {!! $gallery->displayName !!}
                        @if (Auth::check() && $gallery->canSubmit(Auth::user()))
                            <a href="{{ url('gallery/submit/' . $gallery->id) }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i></a>
                        @endif
                    </h4>
                    @if ($gallery->children->count() || (isset($gallery->start_at) || isset($gallery->end_at)))
                        <p>
                            @if (isset($gallery->start_at) || isset($gallery->end_at))
                                @if ($gallery->start_at)
                                    <strong>Open{{ $gallery->start_at->isFuture() ? 's' : 'ed' }}: </strong>{!! pretty_date($gallery->start_at) !!}
                                @endif
                                {{ $gallery->start_at && $gallery->end_at ? ' ・ ' : '' }}
                                @if ($gallery->end_at)
                                    <strong>Close{{ $gallery->end_at->isFuture() ? 's' : 'ed' }}: </strong>{!! pretty_date($gallery->end_at) !!}
                                @endif
                            @endif
                            {{ $gallery->children->count() && (isset($gallery->start_at) || isset($gallery->end_at)) ? ' ・ ' : '' }}
                            @if ($gallery->children->count())
                                Sub-galleries:
                                @foreach ($gallery->children()->visible()->get() as $count => $child)
                                    {!! $child->displayName !!}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            @endif
                        </p>
                    @endif
                </div>
                <div class="card-body">
                    @if ($gallery->submissions->where('status', 'Accepted')->count())
                        <div class="row">
                            @foreach ($gallery->submissions->where('is_visible', 1)->where('status', 'Accepted')->take(4) as $submission)
                                <div class="col-md-3 text-center align-self-center">
                                    @include('galleries._thumb', ['submission' => $submission, 'gallery' => true])
                                </div>
                            @endforeach
                        </div>
                        @if ($gallery->submissions->where('status', 'Accepted')->count() > 4)
                            <div class="text-right"><a href="{{ url('gallery/' . $gallery->id) }}">See More...</a></div>
                        @endif
                    @elseif(
                        $gallery->children->count() &&
                            App\Models\Gallery\GallerySubmission::whereIn('gallery_id', $gallery->children->pluck('id')->toArray())->where('is_visible', 1)->where('status', 'Accepted')->count())
                        <div class="row">
                            @foreach (App\Models\Gallery\GallerySubmission::whereIn('gallery_id', $gallery->children->pluck('id')->toArray())->where('is_visible', 1)->where('status', 'Accepted')->orderBy('created_at', 'DESC')->get()->take(4) as $submission)
                                <div class="col-md-3 text-center align-self-center">
                                    @include('galleries._thumb', ['submission' => $submission, 'gallery' => false])
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>This gallery has no submissions!</p>
                    @endif
                </div>
            </div>
        @endforeach

        {!! $galleries->render() !!}
    @else
        <p>There aren't any galleries!</p>
    @endif

@endsection
