{{-- Image Data --}}
<div class="col-md-6 d-flex">
    <div class="card character-bio w-100">
        <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="infoTab-{{ $image->id }}" data-toggle="tab" href="#info-{{ $image->id }}" role="tab">Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="statsTab-{{ $image->id }}" data-toggle="tab" href="#stats-{{ $image->id }}" role="tab">Stats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="skillsTab-{{ $image->id }}" data-toggle="tab" href="#skills-{{ $image->id }}" role="tab">Skills</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="notesTab-{{ $image->id }}" data-toggle="tab" href="#awards-{{ $image->id }}" role="tab">Awards</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="creditsTab-{{ $image->id }}" data-toggle="tab" href="#credits-{{ $image->id }}" role="tab">Credits</a>
                </li>
                @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <li class="nav-item">
                        <a class="nav-link" id="settingsTab-{{ $image->id }}" data-toggle="tab" href="#settings-{{ $image->id }}" role="tab"><i class="fas fa-cog"></i></a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="card-body tab-content">
            <div class="text-right mb-1">
                <div class="badge badge-primary">Image #{{ $image->id }}</div>
            </div>
            @if(!$image->character->is_myo_slot && !$image->is_valid)
                <div class="alert alert-danger">
                    This version of this {{ __('lorekeeper.character') }} is outdated, and only noted here for recordkeeping purposes. Do not use as an official reference.
                </div>
            @endif

            {{-- Basic info  --}}
            <div class="tab-pane fade show active" id="info-{{ $image->id }}">
            <div class="row">
                    <div class="col-lg-4 col-md-6 col-4"><h5>Class</h5></div>
                    <div class="col-lg-8 col-md-6 col-8">{!! $image->character->class_id ? $image->character->class->displayName : 'None' !!} 
                        @if(Auth::check())
                        @if(Auth::user()->isStaff || Auth::user()->id == $image->character->user_id && $image->character->class_id == null) 
                        <a href="#" class="btn btn-outline-info btn-sm edit-class ml-1" data-id="{{ $image->character->id }}"><i class="fas fa-cog"></i></a>
                        @endif
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-4"><h5>{{ ucfirst(__('lorekeeper.species'))}}</h5></div>
                    <div class="col-lg-8 col-md-6 col-8">{!! $image->species_id ? $image->species->displayName : 'None' !!}</div>
                </div>
                @if($image->subtype_id)
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4"><h5>{{ ucfirst(__('lorekeeper.subtype'))}}</h5></div>
                        <div class="col-lg-8 col-md-6 col-8">{!! $image->subtype_id ? $image->subtype->displayName : 'None' !!}</div>
                    </div>
                @endif
                @if ($image->transformation_id)
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4">
                            <h5>{{ ucfirst(__('transformations.form')) }} {!! add_help('The main image is always the active image') !!}</h5>
                        </div>
                        <div class="col-lg-8 col-md-6 col-8">
                            <a href="{{ $image->transformation->url }}">
                                {!! $image->transformation->displayName !!}
                            </a>
                        </div>
                    </div>
                @endif
                @if($image->character->homeSetting)
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4"><h5>Home</h5></div>
                        <div class="col-lg-8 col-md-6 col-8">{!! $image->character->location ? $image->character->location : 'None' !!}</div>
                    </div>
                @endif
                @if($image->character->factionSetting)
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-4"><h5>Faction</h5></div>
                        <div class="col-lg-8 col-md-6 col-8">{!! $image->character->faction ? $image->character->currentFaction : 'None' !!}{!! $character->factionRank ? ' ('.$character->factionRank->name.')' : null !!}</div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-4"><h5>Rarity</h5></div>
                    <div class="col-lg-8 col-md-6 col-8">{!! $image->rarity_id ? $image->rarity->displayName : 'None' !!}</div>
                </div>

                <div class="mb-3">
                    <div><h5>Traits</h5></div>
                    @if(Config::get('lorekeeper.extensions.traits_by_category'))
                        <div>
                            @php $traitgroup = $image->features()->get()->groupBy('feature_category_id') @endphp
                            @if($image->features()->count())
                                @foreach($traitgroup as $key => $group)
                                <div class="mb-2">
                                    @if($key)
                                        <strong>{!! $group->first()->feature->category->displayName !!}:</strong>
                                    @else
                                        <strong>Miscellaneous:</strong>
                                    @endif
                                    @foreach($group as $feature)
                                        <div class="ml-md-2">{!! $feature->feature->displayName !!} @if($feature->data) ({{ $feature->data }}) @endif</div>
                                    @endforeach
                                </div>
                                @endforeach
                            @else
                                <div>No traits listed.</div>
                            @endif
                        </div>
                    @else
                        <div>
                            <?php $features = $image->features()->with('feature.category')->get(); ?>
                            @if($features->count())
                                @foreach($features as $feature)
                                    <div>@if($feature->feature->feature_category_id) <strong>{!! $feature->feature->category->displayName !!}:</strong> @endif {!! $feature->feature->displayName !!} @if($feature->data) ({{ $feature->data }}) @endif</div>
                                @endforeach
                            @else
                                <div>No traits listed.</div>
                            @endif
                        </div>
                    @endif
                </div>
                

                <div>
                    <strong>Uploaded:</strong> {!! pretty_date($image->created_at) !!}
                </div>
                <div>
                    <strong>Last Edited:</strong> {!! pretty_date($image->updated_at) !!}
                </div>

                @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-info btn-sm edit-features" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> Edit</a>                    </div>
                @endif

<br>
                
                <div class="tabbable">
                <ul class="nav nav-tabs" style="margin-bottom:5px;">
                    <li class="active"><a href="#sub11" id="sub11tab" data-toggle="tab" role="tab" class="nav-link">Pets</a>
                    </li>
                    <li><a href="#sub12" id="sub12tab" data-toggle="tab" role="tab" class="nav-link">Gear</a>
                    </li>
                    <li><a href="#sub13" id="sub13tab" data-toggle="tab" role="tab" class="nav-link">Weapons</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade active in" id="sub11">

                <div class="mb-1">
                    <div><h5>Pets</h5></div>
                        <div class="text-center row">
                        @foreach($image->character->pets as $pet)
                            <div class="ml-3 mr-3">
                                @if($pet->has_image)
                                <img src="{{ $pet->imageUrl }}" data-toggle="tooltip" title="{{ $pet->pet->name }}" style="max-width: 75px;"/>
                                @elseif($pet->pet->imageurl)
                                <img src="{{ $pet->pet->imageUrl }}" data-toggle="tooltip" title="{{ $pet->pet->name }}" style="max-width: 75px;"/>
                                @else {!!$pet->pet->displayName !!}
                                @endif
                                <br>
                                <span class="text-light badge badge-dark" style="font-size:95%;">{!! $pet->pet_name !!}</span>
                            </div>
                        @endforeach
                        </div>


</div>
</div>



                    <div class="tab-pane fade" id="sub12">
                <div class="mb-1">
                    <div><h5>Gear</h5></div>
                        <div class="text-center row">
                        @foreach($image->character->gear as $gear)
                            <div class="ml-3 mr-3">
                                @if($gear->has_image)
                                <img src="{{ $gear->imageUrl }}" data-toggle="tooltip" title="{{ $gear->gear->name }}" style="max-width: 75px;"/>
                                @elseif($gear->gear->imageurl)
                                <img src="{{ $gear->gear->imageUrl }}" data-toggle="tooltip" title="{{ $gear->gear->name }}" style="max-width: 75px;"/>
                                @else {!!$gear->gear->displayName !!}
                                @endif
                            </div>
                        @endforeach
                        </div>
                </div>

</div>


                    <div class="tab-pane fade" id="sub13">
                <div class="mb-1">
                    <div><h5>Weapons</h5></div>
                        <div class="text-center row">
                        @foreach($image->character->weapons as $weapon)
                            <div class="ml-3 mr-3">
                                @if($weapon->has_image)
                                <img src="{{ $weapon->imageUrl }}" data-toggle="tooltip" title="{{ $weapon->weapon->name }}" style="max-width: 75px;"/>
                                @elseif($weapon->weapon->imageurl)
                                <img src="{{ $weapon->weapon->imageUrl }}" data-toggle="tooltip" title="{{ $weapon->weapon->name }}" style="max-width: 75px;"/>
                                @else {!!$weapon->weapon->displayName !!}
                                @endif
                            </div>
                        @endforeach
                        </div>
                </div>
                </div>
</div>
</div>
            </div>



            {{-- Awards --}}
            <div class="tab-pane fade" id="skills-{{ $image->id }}">
        @foreach($character->skills->chunk(2) as $chunk)
<div class="row">
    @foreach($chunk as $skill)
    <div class="col-md">
        <div class="text-center">
            <h5>
                {{ $skill->name }}
            </h5>
    @if($character->skills()->where('skill_id', $skill->id)->exists())
    @php $characterSkill = $character->skills()->where('skill_id', $skill->id)->first() @endphp
            Level: {{$characterSkill->level}}
        </div>
            <div class="row">
                @foreach($skill->children as $children)
                    <div class="col-md  mx-auto body children-body children-scroll">
                        <div class="children-skill ">
                            <ul>
                                @include('character._skill_children', ['children' => $children, 'skill' => $skill])
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
    @else
        </div>
        <p class="mx-auto text-center">Not unlocked.
            <br>
            @if($skill->prerequisite) Requires {!! $skill->prerequisite->displayname !!} @endif
        </p>
    @endif
    </div>
    @endforeach
</div>
<hr>
@endforeach

<script>
    $(function () {
        $('.children-skill ul').hide();
        $('.children-skill>ul').show();
        $('.children-skill ul.active').show();
        $('.children-skill li').on('click', function (e) {
            var children = $(this).find('> ul');
            if (children.is(":visible")) children.hide('fast').removeClass('active');
            else children.show('fast').addClass('active');
            e.stopPropagation();
        });
    });
</script>
            </div>

            {{-- Awards --}}
            <div class="tab-pane fade" id="awards-{{ $image->id }}">
        @foreach($character->awards as $award)
                <a href="{{$award->idUrl}}"><img src="{{ $award->imageUrl }}" alt="{{ $award->name }}" data-toggle="tooltip" data-title="{{ $award->name }}" class="awardbox" style="margin-left: auto; margin-right: auto;"/></a>
        @endforeach
            </div>

            {{-- Stats --}}
            <div class="tab-pane fade" id="stats-{{ $image->id }}">
                <div>
            <h1 style="text-align: center;">
            <span class="badge badge-dark text-white mx-1" data-toggle="tooltip" title="Current Character level.">Current Lvl: {{ $character->level->current_level }}</span></h1>
            @foreach($character->stats as $stat)
            <p><strong>{{$stat->stat->name}}:</strong></p
                @php $add = 0; @endphp
                @foreach($character->gear as $gear)
                    @php 
                    if($gear->gear->stats->where('stat_id', $stat->stat->id)->first())
                    { 
                        $add += $gear->gear->stats->where('stat_id', $stat->stat->id)->first()->count;  
                    }
                    @endphp
                @endforeach
                @foreach($character->weapons as $weapon)
                    @php 
                    if($weapon->weapon->stats->where('stat_id', $stat->stat->id)->first())
                    {
                        $add += $weapon->weapon->stats->where('stat_id', $stat->stat->id)->first()->count;
                    }
                    @endphp
                @endforeach
                <p>@php echo($stat->stat_level->count + $add); echo(' (+ '.$add.')'); @endphp</p>

                @if($stat->current_count != $stat->count && $stat->current_count != NULL)
                <p><strong>Current {{$stat->stat->name}} Count:</strong></p>
                <p>{{$stat->current_count}}/{{$stat->count}}</p>
                @endif
                @if($character->level->current_points > 0 && Auth::check() && Auth::user()->id == $character->user_id)
                    {{ Form::open(['url' => $character->url . '/stats-area/' . $stat->id]) }}
                    
                    {!! Form::submit('Level Stat!', ['class' => 'btn btn-success mb-2']) !!}

                    {!! Form::close() !!}
                @endif
                @endforeach
                </div>
                <h3>
    Status Effects
</h3>
<div class="card mb-4">
    <ul class="list-group list-group-flush">
    
        @foreach($image->character->getStatusEffects() as $status)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-6 text-right">
                        <strong>
                            <img src="{{ $status->imageUrl }}" style="width: 50px;">
                            <a href="{{ $status->url }}">
                                {!! $status->displaySeverity($status->quantity) !!}
                            </a>
                        </strong>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
                </div>

            

            {{-- Image credits --}}
            <div class="tab-pane fade" id="credits-{{ $image->id }}">

                <div class="row mb-2">
                    <div class="col-lg-4 col-md-6 col-4"><h5>Design</h5></div>
                    <div class="col-lg-8 col-md-6 col-8">
                        @foreach($image->designers as $designer)
                            <div>{!! $designer->displayLink() !!}</div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-4"><h5>Art</h5></div>
                    <div class="col-lg-8 col-md-6 col-8">
                        @foreach($image->artists as $artist)
                            <div>{!! $artist->displayLink() !!}</div>
                        @endforeach
                    </div>
                </div>

                @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-info btn-sm edit-credits" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> Edit</a>
                    </div>
                @endif
            </div>

            @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                <div class="tab-pane fade" id="settings-{{ $image->id }}">
                    {!! Form::open(['url' => 'admin/character/image/'.$image->id.'/settings']) !!}
                        <div class="form-group">
                            {!! Form::checkbox('is_visible', 1, $image->is_visible, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('is_visible', 'Is Viewable', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If this is turned off, the image will not be visible by anyone without the Manage Masterlist power.') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('is_valid', 1, $image->is_valid, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('is_valid', 'Is Valid', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If this is turned off, the image will still be visible, but displayed with a note that the image is not a valid reference.') !!}
                        </div>
                        <div class="text-right">
                            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}
                    <hr />
                    <div class="text-right">
                    @if($character->character_image_id != $image->id) <a href="#" class="btn btn-outline-info btn-sm active-image" data-id="{{ $image->id }}">Set Active</a> @endif <a href="#" class="btn btn-outline-info btn-sm reupload-image" data-id="{{ $image->id }}">Reupload Image</a> <a href="#" class="btn btn-outline-danger btn-sm delete-image" data-id="{{ $image->id }}">Delete</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

                </div>