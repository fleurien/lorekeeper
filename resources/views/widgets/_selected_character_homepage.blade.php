<div class="mb-4 homepagechar">
    <div class="card-body text-center">
        <div class="profile-assets-content">
            @if($character)
                <div>
                    <a href="{{ $character->url }}"><img src="{{ isset($fullImage) && $fullImage ? $character->image->imageUrl : $character->image->thumbnailUrl }}" class="{{ isset($fullImage) && $fullImage ? '' : 'img-thumbnail' }}" style="border-radius: 25px;  margin-left: auto; display: block; position: relative; z-index: 2;" alt="{{ $character->fullName }}" /></a>
                </div>
            @else
            <img src="/images/characters/0/1_bUm6hKmU5n_th.png" class="img-thumbnail" style="border-radius: 25px;  margin-left: auto; display: block; position: relative; z-index: 2;" />
            @endif
        </div>
    </div>
</div>
