

{{-- Image Data --}}
<div class="col-md-5 d-flex">
    <div class="card character-bio" style="background-color:transparent; border-radius: 10px; height:60vh;">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" style="font-size:24px;">
                <li class="nav-item" data-toggle="tooltip" title="Basics">
                    <a class="nav-link active" id="basicsTab-{{ $image->id }}" data-toggle="tab" title="Basics" href="#basics-{{ $image->id }}" role="tab"><i class="fas fa-seedling"></i></a>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="Stats">
                    <a class="nav-link" id="statsTab-{{ $image->id }}" data-toggle="tab" href="#stats-{{ $image->id }}" role="tab"><i class="fas fa-sitemap"></i></a>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="Skills">
                    <a class="nav-link" id="skillsTab-{{ $image->id }}" data-toggle="tab" href="#skills-{{ $image->id }}" role="tab"><i class="fas fa-graduation-cap"></i></a>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="Other">
                    <a class="nav-link" id="otherTab-{{ $image->id }}" data-toggle="tab" href="#other-{{ $image->id }}" role="tab"><i class="fas fa-folder"></i></a>
                </li>
                @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <li class="nav-item">
                        <a class="nav-link" id="settingsTab-{{ $image->id }}" data-toggle="tab" href="#settings-{{ $image->id }}" role="tab"><i class="fas fa-cog"></i></a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="card-body tab-content" style="background-color:transparent; border-radius:3px;">
            @if(!$image->character->is_myo_slot && !$image->is_valid)
                <div class="alert alert-danger">
                    This version of this character is outdated, and only noted here for recordkeeping purposes. Do not use as an official reference.
                </div>
            @endif

            {{-- Basic info  --}}
            <div class="tab-pane fade show active" id="basics-{{ $image->id }}">
                <div class="row p-3 m-2" style="background-color:#f9f9f7; border-radius: 5px;">
                    <div class="character-masterlist-categories col" style="font-size:14px; text-align:right;">
                        <p>
                            @if(!$character->is_myo_slot)
                                {!! $character->category->displayName !!} ・ {!! $character->image->species->displayName !!} ・ {!! $character->image->rarity->displayName !!}
                            @else
                                <h2>MYO Slot @if($character->image->species_id) ・ {!! $character->image->species->displayName !!}@endif @if($character->image->rarity_id) ・ {!! $character->image->rarity->displayName !!}@endif</h2>
                            @endif
                        </p>
                        <p>
                            Owned by {!! $character->displayOwner !!}
                        </p>
                    </div>
                </div>
                <div class="row p-4 m-2" style="display:flex; flex-direction:column; background-color:#f9f9f7; border-radius: 5px;">
                    <div class="row">
                        <div class="col"><h5>Class</h5></div>
                        <div class="col text-end">{!! $image->character->class_id ? $image->character->class->displayName : 'None' !!}
                            @if(Auth::check())
                            @if(Auth::user()->isStaff || Auth::user()->id == $image->character->user_id && $image->character->class_id == null)
                            <a href="#" class="btn btn-primary btn-sm edit-class ml-1" data-id="{{ $image->character->id }}"><i class="fas fa-cog"></i></a>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><h5>Species</h5></div>
                        <div class="col text-end">{!! $image->species_id ? $image->species->displayName : 'None' !!}</div>
                    </div>
                    @if($image->subtype_id)
                        <div class="row">
                            <div class="col"><h5>Subtype</h5></div>
                            <div class="col text-end">{!! $image->subtype_id ? $image->subtype->displayName : 'None' !!}</div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col"><h5>Rarity</h5></div>
                        <div class="col text-end">{!! $image->rarity_id ? $image->rarity->displayName : 'None' !!}</div>
                    </div>
                </div>
                <div class="row p-4 m-2" style="display:flex; flex-direction:column; background-color:#f9f9f7; border-radius: 5px;">
                    @if($image->parsed_description)
                    <div class="parsed-text imagenoteseditingparse">{!! $image->parsed_description !!}</div>
                    @else
                        <div class="imagenoteseditingparse">No additional notes given.</div>
                    @endif
                    @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="#" class="btn btn-primary btn-sm edit-notes" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> Add notes</a>
                            @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                                <a href="#" class="btn btn-danger btn-sm edit-features" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> Staff Edit</a>
                            @endif
                        </div>
                    @endif

                    <hr />

                    <div style="text-align: right; font-size:8px;">
                        <strong>Uploaded:</strong> {!! pretty_date($image->created_at) !!}
                    </div>
                    <div style="text-align: right; font-size:8px;">
                        <strong>Last Edited:</strong> {!! pretty_date($image->updated_at) !!}
                    </div>
                </div>
            </div>

            {{-- Stats --}}

            <div class="tab-pane fade show" id="stats-{{ $image->id }}">
                <div class="row p-3 m-2" style="background-color:#f9f9f7; border-radius: 5px;">
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
                </div>
                <div class="row p-4 m-2" style="display:flex; flex-direction:column; background-color:#f9f9f7; border-radius: 5px;">
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

            {{-- Skills --}}

            @if($character->is_myo_slot)
                <div class="tab-pane fade" id="skills-{{ $image->id }}">
                    <div class="row p-3 m-2" style="background-color:#f9f9f7; border-radius: 5px;">
                        This character doesn't have skills yet
                    </div>
                </div>
            @else
                <div class="tab-pane fade" id="skills-{{ $image->id }}">
                    <div class="row p-3 m-2" style="background-color:#f9f9f7; border-radius: 5px;">
                        @include('character._tab_skills', ['character' => $character, 'skills' => $skills])
                    </div>
                </div>
            @endif

            @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                <div class="tab-pane fade" id="settings-{{ $image->id }}">
                    {!! Form::open(['url' => 'admin/character/image/' . $image->id . '/settings']) !!}
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
                    <div class="text-right">
                    @if($character->character_image_id != $image->id) <a href="#" class="btn btn-primary btn-sm active-image" data-id="{{ $image->id }}">Set Active</a> @endif <a href="#" class="btn btn-primary btn-sm reupload-image" data-id="{{ $image->id }}">Reupload Image</a> <a href="#" class="btn btn-danger btn-sm delete-image" data-id="{{ $image->id }}">Delete</a>
                    </div>

                    <hr />
                    <h3 style="margin-bottom:20px;">Staff:</h3>
                    {!! Form::open(['url' => $character->is_myo_slot ? 'admin/myo/'.$character->id.'/settings' : 'admin/character/'.$character->slug.'/settings']) !!}
                    <div class="form-group">
                        {!! Form::checkbox('is_visible', 1, $character->is_visible, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                        {!! Form::label('is_visible', 'Is Visible', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Turn this off to hide the character. Only mods with the Manage Masterlist power (that\'s you!) can view it - the owner will also not be able to see the character\'s page.') !!}
                    </div>
                    <div class="text-right">
                        {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!} <a href="#" class="btn btn-danger delete-character" data-slug="{{ $character->slug }}">Delete</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            @endif

            {{-- Other --}}
            <div class="tab-pane fade" id="other-{{ $image->id }}">
                <div class="row p-3 m-2" style="background-color:#f9f9f7; border-radius: 5px;">
                    <div class="row mb-2">
                        <div class="col"><h5>Design</h5></div>
                        <div class="col">
                            @foreach($image->designers as $designer)
                                <div>{!! $designer->displayLink() !!}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"><h5>Art</h5></div>
                        <div class="col">
                            @foreach($image->artists as $artist)
                                <div>{!! $artist->displayLink() !!}</div>
                            @endforeach
                        </div>
                    </div>

                    @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                        <div class="mt-3">
                            <a href="#" class="btn btn-primary btn-sm edit-credits" data-id="{{ $image->id }}"><i class="fas fa-cog"></i> Edit</a>
                        </div>
                    @endif
                </div>

                @include('character._tab_stats', ['character' => $character])
            </div>

        </div>
    </div>

</div>
