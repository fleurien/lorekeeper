
@if(Auth::check() && Auth::user()->hasVolume($volume->id) || $isAdmin || $volume->is_global == 1 && $volume->checkGlobal() > 0)
            <div class="col-md-4 text-center">
                <div class="card character-bio">
                    <div class="card-body tab-content">
                        <h3>{!! $volume->name !!}</h3>
                        <img src="{{ $volume->imageUrl }}" class="img-fluid mb-2"/>
                        @if($volume->summary)
                            <p>{!! $volume->summary !!} </p>
                        @endif
                        @if($volume->book)
                            <div>
                                <strong>In {{ __('volumes.book') }}: {!! $volume->book->displayName !!}</strong>
                            </div>
                            <br>
                        @endif
                        <div class="text-right">
                            <a href="{{ url('world/'.__('volumes.library').'/'.__('volumes.volume').'/'.$volume->id) }}">View full {{ __('volumes.volume') }}...</a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-md-4 text-center">
                <div class="card character-bio">
                    <div class="card-body tab-content">
                        <h3>???</h3>
                        @if($volume->summary)
                            <p><i>????? </i></p>
                        @endif
                        @if($volume->book)
                            <div>
                                <strong>In {{ __('volumes.book') }}: {!! $volume->book->displayName !!}</strong>
                            </div>
                            <br>
                        @endif
                        <div class="text-right">
                            <a href="{{ url('world/'.__('volumes.library').'/'.__('volumes.volume').'/'.$volume->id) }}">View full {{ __('volumes.volume') }}...</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif