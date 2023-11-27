@extends('character.design.layout')

@section('design-title') Design Approval Request (#{{ $request->id }}) :: Comments @endsection

@section('design-content')
{!! breadcrumbs(['Design Approvals' => 'designs', 'Request (#' . $request->id . ')' => 'designs/' . $request->id, 'Traits' => 'designs/' . $request->id . '/traits']) !!}

@include('character.design._header', ['request' => $request])

<h2>Traits</h2>

@if($request->status == 'Draft' && $request->user_id == Auth::user()->id)
    <p>Select the traits for the {{ $request->character->is_myo_slot ? 'created' : 'updated' }} character. @if($request->character->is_myo_slot) Some traits may have been restricted for you - you cannot change them. @endif <b>Staff will not be able to modify these traits for you during approval,</b> so if in doubt, please reach out if you need a clarification of what traits to use.</p>
    {!! Form::open(['url' => 'designs/'.$request->id.'/traits']) !!}
        <div class="form-group">
           <h4> {!! Form::label('species_id',  ucfirst(__('lorekeeper.species'))) !!} </h4>
            @if($request->character->is_myo_slot && $request->character->image->species_id)
                <div class="alert alert-secondary">{!! $request->character->image->species->displayName !!}</div>
            @else
                {!! Form::select('species_id', $specieses, $request->species_id, ['class' => 'form-control', 'id' => 'species']) !!}
            @endif

        </div>

        <div class="form-group">
           <h4> {!! Form::label('subtype_id', 'Species '.ucfirst(__('lorekeeper.subtype'))) !!} </h4>
            @if($request->character->is_myo_slot && $request->character->image->subtype_id)
                <div class="alert alert-secondary">{!! $request->character->image->subtype->displayName !!}</div>
            @else
                <div id="subtypes">
                  {!! Form::select('subtype_id', $subtypes, $request->subtype_id, ['class' => 'form-control', 'id' => 'subtype']) !!}
                </div>
            @endif
        </div>

        <div class="form-group">
           <h4> {!! Form::label('transformation_id', 'Image type') !!} </h4>
            <p><b><a href="/info/design">See the design guide for an explanation of image types and their requirements.</a></b>
        <br>
    If choosing an image type your Poffin already has, the previous image will be overridden.
<br>
<b>If you want to replace your Poffin's main image, leave this blank.</b></p>
            @if ($request->character->is_myo_slot && $request->character->image->transformation_id)
                <div class="alert alert-secondary">{!! $request->character->image->transformation->displayName !!}</div>
            @else
                <div id="transformations">
                    {!! Form::select('transformation_id', $transformations, $request->transformation_id, ['class' => 'form-control', 'id' => 'transformation']) !!}
                </div>
            @endif
        </div>

        <div class="form-group">
           <h4> {!! Form::label('rarity_id', 'Character Rarity') !!} </h4>
            @if($request->character->is_myo_slot && $request->character->image->rarity_id)
                <div class="alert alert-secondary">{!! $request->character->image->rarity->displayName !!}</div>
            @else
                {!! Form::select('rarity_id', $rarities, $request->rarity_id, ['class' => 'form-control', 'id' => 'rarity']) !!}
            @endif
        </div>

        <div class="form-group">
          <h4>  {!! Form::label('Traits') !!} </h4>
            <p><b>For special traits:</b>
        <br>
    Please list the applicable features one by one in the 'extra info' box, seperated by a comma.
<br>
<i>For example:</i> A Poffin with extra eyes and a halo would have the <i>Eldritch</i> trait, and the extra info would say <i>'Extra eyes, halo'</i>.</p>
            <div id="featureList">
                {{-- Add in the compulsory traits for MYO slots --}}
                @if($request->character->is_myo_slot && $request->character->image->features)
                    @foreach($request->character->image->features as $feature)
                        <div class="mb-2 d-flex align-items-center">
                            {!! Form::text('', $feature->name, ['class' => 'form-control mr-2', 'disabled']) !!}
                            {!! Form::text('', $feature->data, ['class' => 'form-control mr-2', 'disabled']) !!}
                            <div>{!! add_help('This trait is required.') !!}</div>
                        </div>
                    @endforeach
                @endif

                {{-- Add in the ones that currently exist --}}
                @if($request->features)
                    @foreach($request->features as $feature)
                        <div class="mb-2 d-flex">
                            {!! Form::select('feature_id[]', $features, $feature->feature_id, ['class' => 'form-control mr-2 feature-select', 'placeholder' => 'Select Trait']) !!}
                            {!! Form::text('feature_data[]', $feature->data, ['class' => 'form-control mr-2', 'placeholder' => 'Extra Info (Optional)']) !!}
                            <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
                        </div>
                    @endforeach
                @endif
            </div>
            <div><a href="#" class="btn btn-primary" id="add-feature">Add Trait</a></div>
            <div class="feature-row hide mb-2">
                {!! Form::select('feature_id[]', $features, null, ['class' => 'form-control mr-2 feature-select', 'placeholder' => 'Select Trait']) !!}
                {!! Form::text('feature_data[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Extra Info (Optional)']) !!}
                <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
@else
    <div class="mb-1">
        <div class="row">
            <div class="col-md-2 col-4"><h5>{{ ucfirst(__('lorekeeper.species')) }}</h5></div>
            <div class="col-md-10 col-8">{!! $request->species ? $request->species->displayName : 'None Selected' !!}</div>
        </div>
        @if($request->subtype_id)
        <div class="row">
            <div class="col-md-2 col-4"><h5>{{ ucfirst(__('lorekeeper.subtype')) }}</h5></div>
            <div class="col-md-10 col-8">
            @if($request->character->is_myo_slot && $request->character->image->subtype_id)
                {!! $request->character->image->subtype->displayName !!}
            @else
                {!! $request->subtype_id ? $request->subtype->displayName : 'None Selected' !!}
            @endif
            </div>
        </div>
        @endif
        @if($request->transformation_id)
                <div class="row">
                    <div class="col-md-2 col-4">
                        <h5>{{ ucfirst(__('transformations.transformation')) }}</h5>
                    </div>
                    <div class="col-md-10 col-8">
                        @if ($request->character->is_myo_slot && $request->character->image->transformation_id)
                            {!! $request->character->image->transformation->displayName !!}
                        @else
                            {!! $request->transformation_id ? $request->transformation->displayName : 'None Selected' !!}
                        @endif
                    </div>
                </div>
        @endif
        <div class="row">
            <div class="col-md-2 col-4"><h5>Rarity</h5></div>
            <div class="col-md-10 col-8">{!! $request->rarity ? $request->rarity->displayName : 'None Selected' !!}</div>
        </div>
    </div>
    <h5>Traits</h5>
        <div>
            @if ($request->character && $request->character->is_myo_slot && $request->character->image->features)
                @foreach ($request->character->image->features as $feature)
                    <div>
                        @if ($feature->feature->feature_category_id)
                            <strong>{!! $feature->feature->category->displayName !!}:</strong>
                            @endif {!! $feature->feature->displayName !!} @if ($feature->data)
                                ({{ $feature->data }})
                            @endif <span class="text-danger">*Required</span>
                    </div>
                @endforeach
            @endif
            @foreach ($request->features as $feature)
                <div>
                    @if ($feature->feature->feature_category_id)
                        <strong>{!! $feature->feature->category->displayName !!}:</strong>
                        @endif {!! $feature->feature->displayName !!} @if ($feature->data)
                            ({{ $feature->data }})
                        @endif
                </div>
            @endforeach
        </div>
    @endif

@endsection

@section('scripts')
@include('widgets._image_upload_js')

<script>
  $( "#species" ).change(function() {
    var species = $('#species').val();
    var id = '<?php echo($request->id); ?>';
    $.ajax({
      type: "GET", url: "{{ url('designs/traits/subtype') }}?species="+species+"&id="+id, dataType: "text"
    }).done(function (res) { $("#subtypes").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });

  });
</script>

@endsection