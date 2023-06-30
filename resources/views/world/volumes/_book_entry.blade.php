
    <div class="col-md-4">
        <div class="card character-bio">
            <div class="card-body tab-content">
            @if(Auth::check() && Auth::user()->hasPower('edit_data'))
                <a data-toggle="tooltip" title="[ADMIN] Edit {{ __('volumes.book') }}" href="{{ url('admin/data/volumes/books/edit/').'/'.$book->id }}" class="mb-2 float-right"><i class="fas fa-crown"></i></a>
            @endif
                <h3>{!! $name !!}</h3>
                <img src="{{ $book->imageUrl }}" class="img-fluid mb-2"/>
                @if($book->summary)
                    <div class="world-entry-text">
                        <i>{!! $book->summary !!}</i>
                    </div>
                    <br>
                @endif

                @if($book->volumes->count())
                    <h4>{{ __('volumes.volumes') }}</h4>
                        <ul>
                            @foreach($book->volumes as $volume)
                            @if(Auth::check() && Auth::user()->hasVolume($volume->id) || $isAdmin || $volume->is_global == 1 && $volume->checkGlobal() > 0)
                                <li>{!! $volume->displayName !!}</li>
                                @else 
                                <li> <i>????? </i></li>
                                @endif
                            @endforeach 
                        </ul>
                @endif
                <div class="text-right">
                    <a href="{{ url('world/'.__('volumes.library').'/'.__('volumes.book').'/'.$book->id) }}">View full {{ __('volumes.book') }}...</a>
                </div>
            </div>
        </div>
    </div>

