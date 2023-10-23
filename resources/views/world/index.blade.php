@extends('world.layout')

@section('title')
    Home
@endsection

@section('content')
    {!! breadcrumbs(['Encyclopedia' => 'world']) !!}

    <h1>World of Poffins</h1>
<!-- header -->
    <div class="row">
<div class="col-3">
    <img src="https://poffinsworld.com/files/SITEDECOR/aedionworldchibi.gif" style="width:200px;height:200px;">
</div>
<div class="col-6 text-center">
    <h3>Welcome to the Poffins encyclopedia!</h3>
    <p>
    Here you'll be able to find all the lore on the species itself, as well as on the locations within the Poffins 'canon'!
    <br>
As well, you can find documentation for the different aspects of the game, like items, gear, collections, and more!
</p>
</div>
<div class="col-3">
    <img src="https://poffinsworld.com/files/SITEDECOR/sunshineworldchibi.gif" style="width:200px;height:200px;">
</div>
</div>
<!-- header -->

<div class="row p-2 text-center">
    <div class="col">
    <img src="https://placehold.co/150x150.png">
        <h3><a href="/world/species">Poffins</a></h3>
        <p>All about the oddly adaptable butterfly cats themselves - as well as their subtypes.</p>
</div>
<div class="col">
<img src="https://placehold.co/150x150.png">
        <h3><a href="/world/universaltraits">Traits</a></h3>
        <p>The trait sheet! If you need help when designing your Poffin, check it out!</p>
</div>
<div class="col">
<img src="https://placehold.co/150x150.png">
        <h3><a href="/world/genetics">Genetics</a></h3>
        <p>An explanation to the chaotic and malleable genetic makeup of Poffins, presented by Dr. Sunshine.</p>
</div>
<div class="col">
<img src="https://placehold.co/150x150.png">
        <h3><a href="/world/info">World</a></h3>
        <p>An in-depth look to the world of Poffins, as well as technical information on forage and explore locations!</p>
</div>
<div class="col">
<img src="https://placehold.co/150x150.png">
        <h3><a href="/world/figures">NPCs</a></h3>
        <p>Space doesn't have to be lonely! Learn more about the colorful cast of NPCs here.</p>
</div>
</div>

<h2>Gamedex</h2>
<div class="row">
    <div class="col">
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/blue%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/item-categories">Items by category</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/green%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/items">All items</b></a></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/lime%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/pet-categories">Pets by category</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/orange%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/pets">All pets</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/purple%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/collections">Collections</a></b></p>

       
    </div>
    <div class="col">
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/red%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/status-effects">Status effects</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/yellow%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/skills">Skills</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/blue%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/awards">Badges</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/green%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/character-titles">Titles</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/lime%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/levels/character">Level guide</a></b></p>
    </div>
    <div class="col">
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/orange%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/weapon-categories">Weapons by category</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/purple%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/weapons">All weapons</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/red%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/gear-categories">Gear by category</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/yellow%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/gear">All gear</a></b></p>
       <p class="worldstarbitbulletline"> <img src="https://poffinsworld.com/files/UI/lime%20starbullet.png" class="worldstarbitbullet"> <b><a href="/world/recipes">Recipes</a></b></p>
    </div>
</div>

    
@endsection
