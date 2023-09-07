<div class="col-md-6">
@if(isset($background) && Config::get('lorekeeper.extensions.character_backgrounds.enabled'))
    <div class="text-center" style="{{ implode('; ',$background) }}; background-size: cover; background-repeat:no-repeat; width: 650px; height: 750px; background-position: center; border-radius: 20px;">
        <a href="{{ $image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($image->imageDirectory . '/' . $image->fullsizeFileName)) ? $image->fullsizeUrl : $image->imageUrl }}" data-lightbox="entry"
            data-title="{{ $character->fullName }}">
            <img src="{{ $image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($image->imageDirectory . '/' . $image->fullsizeFileName)) ? $image->fullsizeUrl : $image->imageUrl }}" class="image" style="max-height: 720px; width: auto;"
                alt="{{ $character->fullName }}" />
        </a>
    </div>
    @else
    <div class="text-center">
        <a href="{{ $image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($image->imageDirectory . '/' . $image->fullsizeFileName)) ? $image->fullsizeUrl : $image->imageUrl }}" data-lightbox="entry"
            data-title="{{ $character->fullName }}">
            <img src="{{ $image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($image->imageDirectory . '/' . $image->fullsizeFileName)) ? $image->fullsizeUrl : $image->imageUrl }}" class="image"
                alt="{{ $character->fullName }}" />
        </a>
    </div>
    @endif
    @if ($image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($image->imageDirectory . '/' . $image->fullsizeFileName)))
        <div class="text-right">You are viewing the full-size image. <a href="{{ $image->imageUrl }}">View watermarked image</a>?</div>
    @endif
</div>
@include('character._image_info', ['image' => $image])