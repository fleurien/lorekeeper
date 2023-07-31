<div class="mb-4 homepagechar">
    <div class="card-body text-center">
        <div class="profile-assets-content">
            @if($character)
                <div>
                    <a href="{{ $character->url }}"><img src="{{ isset($fullImage) && $fullImage ? $character->image->imageUrl : $character->image->thumbnailUrl }}" class="{{ isset($fullImage) && $fullImage ? '' : 'img-thumbnail' }}" style="border-radius: 25px;  margin-left: auto; display: block; position: relative; z-index: 2;" alt="{{ $character->fullName }}" /></a>
                </div>
            @else
            <img src="/images/characters/0/3_a4dn6bmW6v_th.png" style="border-radius: 25px; margin-left: auto; display: block; relative; z-index: 2;" />
            @endif
        </div>
    </div>
</div>
