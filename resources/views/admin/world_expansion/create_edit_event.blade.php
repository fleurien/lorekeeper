@extends('admin.layout')

@section('admin-title') Event @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Events' => 'admin/world/events', ($event->id ? 'Edit' : 'Create').' Event' => $event->id ? 'admin/world/events/edit/'.$event->id : 'admin/world/events/create']) !!}

<h1>{{ $event->id ? 'Edit' : 'Create' }} Event
    @if($event->id)
        ({!! $event->displayName !!})
        <a href="#" class="btn btn-danger float-right delete-event-button">Delete Event</a>
    @endif
</h1>

{!! Form::open(['url' => $event->id ? 'admin/world/events/edit/'.$event->id : 'admin/world/events/create', 'files' => true]) !!}

<h3>Basic Information</h3>

<div class="row mx-0 px-0">
    <div class="form-group col-md px-0 pr-md-1">
        {!! Form::label('Name') !!}
        {!! Form::text('name', $event->name, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-md px-0 pr-md-1">
        {!! Form::label('Category') !!} {!! add_help('What category of event is this?') !!}
        {!! Form::select('category_id', [0=>'Choose an Event Category'] + $categories, $event->category_id, ['class' => 'form-control selectize', 'id' => 'category']) !!}
    </div>
</div>

<div class="row mx-0 px-0">
    <div class="form-group col-md px-0 pr-md-1">
        {!! Form::label('occur_start', 'Start Date (Optional)') !!}
        {!! Form::text('occur_start', $event->occur_start, ['class' => 'form-control datepicker']) !!}
    </div>
    <div class="form-group col-md px-0 pr-md-1">
        {!! Form::label('occur_end', 'End Date (Optional)') !!} {!! add_help('If left blank but start date is set, this will be considered Ongoing.') !!}
        {!! Form::text('occur_end', $event->occur_end, ['class' => 'form-control datepicker']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('Summary (Optional)') !!}
    {!! Form::text('summary', $event->summary, ['class' => 'form-control']) !!}
</div>

<h3>Images</h3>
<div class="form-group">
    @if($event->thumb_extension)
        <a href="{{$event->thumbUrl}}"  data-lightbox="entry" data-title="{{ $event->name }}"><img src="{{$event->thumbUrl}}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
    @endif
    {!! Form::label('Thumbnail Image (Optional)') !!} {!! add_help('This thumbnail is used on the event index.') !!}
    <div>{!! Form::file('image_th') !!}</div>
    <div class="text-muted">Recommended size: 200x200</div>
    @if(isset($event->thumb_extension))
        <div class="form-check">
            {!! Form::checkbox('remove_image_th', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Thumbnail As-Is', 'data-on' => 'Remove Thumbnail Image']) !!}
        </div>
    @endif
</div>

<div class="form-group">
    @if($event->image_extension)
        <a href="{{$event->imageUrl}}"  data-lightbox="entry" data-title="{{ $event->name }}"><img src="{{$event->imageUrl}}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
    @endif
    {!! Form::label('Event Image (Optional)') !!} {!! add_help('This image is used on the event page as a header.') !!}
    <div>{!! Form::file('image') !!}</div>
    <div class="text-muted">Recommended size: None (Choose a standard size for all event header images.)</div>
    @if(isset($event->image_extension))
        <div class="form-check">
            {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Header Image As-Is', 'data-on' => 'Remove Current Header Image']) !!}
        </div>
    @endif
</div>

<h3>Description</h3>
<div class="form-group" style="clear:both">
    {!! Form::label('Description (Optional)') !!}
    {!! Form::textarea('description', $event->description, ['class' => 'form-control wysiwyg']) !!}
</div>

@if($event->id)
    <h3>Associated Figures</h3>
    <div class="form-group row">
        <div id="itemList" class="col-12 row">
            @foreach($event->figures as $figure)
                <div class="d-flex mb-2 col-4">
                    {!! Form::select('figure_id['.$figure->id.']', $figures, $figure->id, ['class' => 'form-control mr-2 item-select original', 'placeholder' => 'Select Figure']) !!}
                    <a href="#" class="remove-item btn btn-danger mb-2">×</a>
                </div>
            @endforeach
        </div>
        <div class="col-12 text-right"><a href="#" class="btn btn-primary" id="add-item">Add Figure</a></div>
    </div>

    <h3>Associated Locations</h3>
    <div class="form-group row">
        <div id="locationList" class="col-12 row">
            @foreach($event->locations as $location)
                <div class="d-flex mb-2 col-4">
                    {!! Form::select('location_id['.$location->id.']', $locations, $location->id, ['class' => 'form-control mr-2 location-select original', 'placeholder' => 'Select Location']) !!}
                    <a href="#" class="remove-location btn btn-danger mb-2">×</a>
                </div>
            @endforeach
        </div>
        <div class="col-12 text-right"><a href="#" class="btn btn-primary" id="add-location">Add Location</a></div>
    </div>

    <h3>Associated Factions</h3>
    <div class="form-group row">
        <div id="factionList" class="col-12 row">
            @foreach($event->factions as $faction)
                <div class="d-flex mb-2 col-4">
                    {!! Form::select('faction_id['.$faction->id.']', $factions, $faction->id, ['class' => 'form-control mr-2 faction-select original', 'placeholder' => 'Select Faction']) !!}
                    <a href="#" class="remove-faction btn btn-danger mb-2">×</a>
                </div>
            @endforeach
        </div>
        <div class="col-12 text-right"><a href="#" class="btn btn-primary" id="add-faction">Add Faction</a></div>
    </div>

    <h3>Associated News Posts</h3>
    <div class="form-group row">
        <div id="newsList" class="col-12 row">
            @foreach($event->newses as $news)
                <div class="d-flex mb-2 col-4">
                    {!! Form::select('news_id['.$news->id.']', $newses, $news->id, ['class' => 'form-control mr-2 news-select original', 'placeholder' => 'Select News Post']) !!}
                    <a href="#" class="remove-news btn btn-danger mb-2">×</a>
                </div>
            @endforeach
        </div>
        <div class="col-12 text-right"><a href="#" class="btn btn-primary" id="add-news">Add News Post</a></div>
    </div>

    <h3>Associated Prompts</h3>
    <div class="form-group row">
        <div id="promptList" class="col-12 row">
            @foreach($event->prompts as $prompt)
                <div class="d-flex mb-2 col-4">
                    {!! Form::select('prompt_id['.$prompt->id.']', $prompts, $prompt->id, ['class' => 'form-control mr-2 prompt-select original', 'placeholder' => 'Select Prompt']) !!}
                    <a href="#" class="remove-prompt btn btn-danger mb-2">×</a>
                </div>
            @endforeach
        </div>
        <div class="col-12 text-right"><a href="#" class="btn btn-primary" id="add-prompt">Add Prompt</a></div>
    </div>
@endif


<div class="form-group">
    {!! Form::checkbox('is_active', 1, $event->id ? $event->is_active : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_active', 'Set Active', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off, the category will not be visible to regular users.') !!}
</div>

<div class="text-right">
    {!! Form::submit($event->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}


<div class="item-row hide mb-2 col-4">
    {!! Form::select('figure_id[]', $figures, null, ['class' => 'form-control mr-2 item-select', 'placeholder' => 'Select Figure']) !!}
    <a href="#" class="remove-item btn btn-danger mb-2">×</a>
</div>

<div class="location-row hide mb-2 col-4">
    {!! Form::select('location_id[]', $locations, null, ['class' => 'form-control mr-2 location-select', 'placeholder' => 'Select Location']) !!}
    <a href="#" class="remove-location btn btn-danger mb-2">×</a>
</div>

<div class="faction-row hide mb-2 col-4">
    {!! Form::select('faction_id[]', $factions, null, ['class' => 'form-control mr-2 faction-select', 'placeholder' => 'Select Faction']) !!}
    <a href="#" class="remove-faction btn btn-danger mb-2">×</a>
</div>

<div class="news-row hide mb-2 col-4">
    {!! Form::select('news_id[]', $newses, null, ['class' => 'form-control mr-2 news-select', 'placeholder' => 'Select News Post']) !!}
    <a href="#" class="remove-news btn btn-danger mb-2">×</a>
</div>

<div class="prompt-row hide mb-2 col-4">
    {!! Form::select('prompt_id[]', $prompts, null, ['class' => 'form-control mr-2 prompt-select', 'placeholder' => 'Select Prompt']) !!}
    <a href="#" class="remove-prompt btn btn-danger mb-2">×</a>
</div>

@endsection

@section('scripts')
@parent
<script>
$( document ).ready(function() {
    $('.delete-event-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/world/events/delete') }}/{{ $event->id }}", 'Delete Event');
    });
    $('.selectize').selectize();

    $('.original.item-select').selectize();
    $('#add-item').on('click', function(e) {
        e.preventDefault();
        addFigureRow();
    });
    $('.remove-item').on('click', function(e) {
        e.preventDefault();
        removeFigureRow($(this));
    })
    function addFigureRow() {
        var $clone = $('.item-row').clone();
        $('#itemList').append($clone);
        $clone.removeClass('hide item-row');
        $clone.addClass('d-flex');
        $clone.find('.remove-item').on('click', function(e) {
            e.preventDefault();
            removeFigureRow($(this));
        })
        $clone.find('.item-select').selectize();
    }
    function removeFigureRow($trigger) {
        $trigger.parent().remove();
    }

    $('.original.location-select').selectize();
    $('#add-location').on('click', function(e) {
        e.preventDefault();
        addLocationRow();
    });
    $('.remove-location').on('click', function(e) {
        e.preventDefault();
        removeFigureRow($(this));
    })
    function addLocationRow() {
        var $clone = $('.location-row').clone();
        $('#locationList').append($clone);
        $clone.removeClass('hide location-row');
        $clone.addClass('d-flex');
        $clone.find('.remove-location').on('click', function(e) {
            e.preventDefault();
            removeLocationRow($(this));
        })
        $clone.find('.location-select').selectize();
    }
    function removeLocationRow($trigger) {
        $trigger.parent().remove();
    }


    $('.original.faction-select').selectize();
    $('#add-faction').on('click', function(e) {
        e.preventDefault();
        addFactionRow();
    });
    $('.remove-faction').on('click', function(e) {
        e.preventDefault();
        removeFigureRow($(this));
    })
    function addFactionRow() {
        var $clone = $('.faction-row').clone();
        $('#factionList').append($clone);
        $clone.removeClass('hide faction-row');
        $clone.addClass('d-flex');
        $clone.find('.remove-faction').on('click', function(e) {
            e.preventDefault();
            removeFactionRow($(this));
        })
        $clone.find('.faction-select').selectize();
    }
    function removeFactionRow($trigger) {
        $trigger.parent().remove();
    }


    $('.original.news-select').selectize();
    $('#add-news').on('click', function(e) {
        e.preventDefault();
        addNewsRow();
    });
    $('.remove-news').on('click', function(e) {
        e.preventDefault();
        removeFigureRow($(this));
    })
    function addNewsRow() {
        var $clone = $('.news-row').clone();
        $('#newsList').append($clone);
        $clone.removeClass('hide news-row');
        $clone.addClass('d-flex');
        $clone.find('.remove-news').on('click', function(e) {
            e.preventDefault();
            removeNewsRow($(this));
        })
        $clone.find('.news-select').selectize();
    }
    function removeNewsRow($trigger) {
        $trigger.parent().remove();
    }


    $('.original.prompt-select').selectize();
    $('#add-prompt').on('click', function(e) {
        e.preventDefault();
        addPromptRow();
    });
    $('.remove-prompt').on('click', function(e) {
        e.preventDefault();
        removeFigureRow($(this));
    })
    function addPromptRow() {
        var $clone = $('.prompt-row').clone();
        $('#promptList').append($clone);
        $clone.removeClass('hide prompt-row');
        $clone.addClass('d-flex');
        $clone.find('.remove-prompt').on('click', function(e) {
            e.preventDefault();
            removePromptRow($(this));
        })
        $clone.find('.prompt-select').selectize();
    }
    function removePromptRow($trigger) {
        $trigger.parent().remove();
    }

    $( ".datepicker" ).datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: '',
    });
});

</script>
@endsection
