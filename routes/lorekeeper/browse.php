<?php

/*
|--------------------------------------------------------------------------
| Browse Routes
|--------------------------------------------------------------------------
|
| Routes for pages that don't require being logged in to view,
| specifically the information pages.
|
*/

/**************************************************************************************************
    Widgets
**************************************************************************************************/

Route::get('items/{id}', 'Users\InventoryController@getStack');
Route::get('awards/{id}', 'Users\AwardCaseController@getStack');
Route::get('pets/{id}', 'Users\PetController@getStack');
Route::get('weapons/{id}', 'Users\WeaponController@getStack');
Route::get('gears/{id}', 'Users\GearController@getStack');
Route::get('items/character/{id}', 'Users\InventoryController@getCharacterStack');
Route::get('awards/character/{id}', 'Users\AwardCaseController@getCharacterStack');

/**************************************************************************************************
    News
**************************************************************************************************/
// PROFILES
Route::group(['prefix' => 'news'], function () {
    Route::get('/', 'NewsController@getIndex');
    Route::get('{id}.{slug?}', 'NewsController@getNews');
    Route::get('{id}.', 'NewsController@getNews');
});

/**************************************************************************************************
    Sales
**************************************************************************************************/
// PROFILES
Route::group(['prefix' => 'sales'], function () {
    Route::get('/', 'SalesController@getIndex');
    Route::get('{id}.{slug?}', 'SalesController@getSales');
    Route::get('{id}.', 'SalesController@getSales');
});

/**************************************************************************************************
    Users
**************************************************************************************************/
Route::get('/users', 'BrowseController@getUsers');
Route::get('/blacklist', 'BrowseController@getBlacklist');
Route::get('/deactivated-list', 'BrowseController@getDeactivated');

// PROFILES
Route::group(['prefix' => 'user', 'namespace' => 'Users'], function () {
    Route::get('{name}/gallery', 'UserController@getUserGallery');
    Route::get('{name}/favorites', 'UserController@getUserFavorites');
    Route::get('{name}/favorites/own-characters', 'UserController@getUserOwnCharacterFavorites');

    Route::get('{name}', 'UserController@getUser');
    Route::get('{name}/aliases', 'UserController@getUserAliases');
    Route::get('{name}/characters', 'UserController@getUserCharacters');
    Route::get('{name}/sublist/{key}', 'UserController@getUserSublist');
    Route::get('{name}/myos', 'UserController@getUserMyoSlots');
    Route::get('{name}/breeding-permissions', 'UserController@getUserBreedingPermissions');
    Route::get('{name}/inventory', 'UserController@getUserInventory');
    Route::get('{name}/pets', 'UserController@getUserPets');
    Route::get('{name}/bank', 'UserController@getUserBank');
    Route::get('{name}/awardcase', 'UserController@getUserAwardCase');
    Route::get('{name}/level', 'UserController@getUserLevel');
    Route::get('{name}/armoury', 'UserController@getUserArmoury');

    Route::get('{name}/currency-logs', 'UserController@getUserCurrencyLogs');
    Route::get('{name}/item-logs', 'UserController@getUserItemLogs');
    Route::get('{name}/pet-logs', 'UserController@getUserPetLogs');
    Route::get('{name}/ownership', 'UserController@getUserOwnershipLogs');
    Route::get('{name}/submissions', 'UserController@getUserSubmissions');
    Route::get('{name}/exp-logs', 'UserController@getUserExpLogs');
    Route::get('{name}/level-logs', 'UserController@getUserLevelLogs');
    Route::get('{name}/stat-logs', 'UserController@getUserStatLogs');
    Route::get('{name}/gear-logs', 'UserController@getUserGearLogs');
    Route::get('{name}/weapon-logs', 'UserController@getUserWeaponLogs');

    Route::get('{name}/collection-logs', 'UserController@getUserCollectionLogs');
});

/**************************************************************************************************
    Characters
**************************************************************************************************/
Route::get('/masterlist', 'BrowseController@getCharacters');
Route::get('/myos', 'BrowseController@getMyos');
Route::get('/sublist/{key}', 'BrowseController@getSublist');
Route::group(['prefix' => 'character', 'namespace' => 'Characters'], function () {
    Route::get('{slug}', 'CharacterController@getCharacter');
    Route::get('{slug}/profile', 'CharacterController@getCharacterProfile');
    Route::get('{slug}/awards', 'CharacterController@getCharacterAwards');
    Route::get('{slug}/bank', 'CharacterController@getCharacterBank');
    Route::get('{slug}/level', 'CharacterController@getCharacterLevel');
    Route::get('{slug}/inventory', 'CharacterController@getCharacterInventory');
    Route::get('{slug}/images', 'CharacterController@getCharacterImages');
    Route::get('{slug}/image/{id}', 'CharacterController@getCharacterImage');

    Route::get('{slug}/award-logs', 'CharacterController@getCharacterAwardLogs');
    Route::get('{slug}/currency-logs', 'CharacterController@getCharacterCurrencyLogs');
    Route::get('{slug}/item-logs', 'CharacterController@getCharacterItemLogs');
    Route::get('{slug}/ownership', 'CharacterController@getCharacterOwnershipLogs');
    Route::get('{slug}/change-log', 'CharacterController@getCharacterLogs');
    Route::get('{slug}/skill-logs', 'CharacterController@getCharacterSkillLogs');
    Route::get('{slug}/submissions', 'CharacterController@getCharacterSubmissions');
    Route::get('{slug}/exp-logs', 'CharacterController@getCharacterExpLogs');
    Route::get('{slug}/stat-logs', 'CharacterController@getCharacterStatLogs');
    Route::get('{slug}/level-logs', 'CharacterController@getCharacterLevelLogs');
    Route::get('{slug}/count-logs', 'CharacterController@getCharacterCountLogs');

    Route::get('{slug}/gallery', 'CharacterController@getCharacterGallery');

    Route::get('{slug}/breeding-permissions', 'CharacterController@getCharacterBreedingPermissions');
    # lineage
    Route::get('{slug}/lineage', 'CharacterLineageController@getCharacterLineage');
    Route::get('{slug}/children', 'CharacterLineageController@getCharacterChildren');
    Route::get('{slug}/grandchildren', 'CharacterLineageController@getCharacterGrandChildren');
    Route::get('{slug}/great-grandchildren', 'CharacterLineageController@getCharacterGreatGrandChildren');
    Route::get('{slug}/image/{id}', 'CharacterController@getCharacterImage');
});
Route::group(['prefix' => 'myo', 'namespace' => 'Characters'], function () {
    Route::get('{id}', 'MyoController@getCharacter');
    Route::get('{id}/profile', 'MyoController@getCharacterProfile');
    Route::get('{id}/ownership', 'MyoController@getCharacterOwnershipLogs');
    Route::get('{id}/change-log', 'MyoController@getCharacterLogs');
});

/**************************************************************************************************
    World
**************************************************************************************************/

Route::group(['prefix' => 'world'], function () {
    Route::get('/', 'WorldController@getIndex');

    Route::get('currencies', 'WorldController@getCurrencies');
    Route::get('rarities', 'WorldController@getRarities');
    Route::get('genetics', 'WorldController@getGenetics');
    Route::get('species', 'WorldController@getSpecieses');
    Route::get('subtypes', 'WorldController@getSubtypes');
    Route::get('transformations', 'WorldController@getTransformations');
    Route::get('species/{id}/traits', 'WorldController@getSpeciesFeatures');
    Route::get('species/{speciesId}/trait/{id}', 'WorldController@getSpeciesFeatureDetail')->where(['id' => '[0-9]+', 'speciesId' => '[0-9]+']);
    Route::get('item-categories', 'WorldController@getItemCategories');
    Route::get('items', 'WorldController@getItems');
    Route::get('award-categories', 'WorldController@getAwardCategories');
    Route::get('awards', 'WorldController@getAwards');
    Route::get('awards/{id}', 'WorldController@getAward');
    Route::get('items/{id}', 'WorldController@getItem');
    Route::get('trait-categories', 'WorldController@getFeatureCategories');
    Route::get('traits', 'WorldController@getFeatures');
    Route::get('pet-categories', 'WorldController@getPetCategories');
    Route::get('pets', 'WorldController@getPets');
    Route::get('prompt-categories', 'WorldController@getPromptCategories');
    Route::get('prompts', 'WorldController@getPrompts');
    Route::get('character-categories', 'WorldController@getCharacterCategories');
    Route::get('character-titles', 'WorldController@getCharacterTitles');

    Route::get(__('volumes.library'), 'WorldController@getLibrary');
    Route::get(__('volumes.library').'/'.__('volumes.volume').'/{id}', 'WorldController@getVolume');
    Route::get(__('volumes.library').'/'.__('volumes.book').'/{id}', 'WorldController@getBook');
    Route::get(__('volumes.library').'/'.__('volumes.volumes'), 'WorldController@getVolumes');

    Route::get(__('transformations.transformations'), 'WorldController@getTransformations');
    Route::get('levels', 'WorldController@getLevels');
    Route::get('levels/{type}', 'WorldController@getLevelTypes');
    Route::get('levels/{type}/{level}', 'WorldController@getSingleLevel');
    Route::get('stats', 'WorldController@getStats');
    Route::get('weapon-categories', 'WorldController@getWeaponCategories');
    Route::get('weapons', 'WorldController@getWeapons');
    Route::get('weapons/{id}', 'WorldController@getWeapon');
    Route::get('gear-categories', 'WorldController@getGearCategories');
    Route::get('gear', 'WorldController@getGears');
    Route::get('gear/{id}', 'WorldController@getGear');
    Route::get('character-classes', 'WorldController@getCharacterClasses');
    Route::get('skill-categories', 'WorldController@getSkillCategories');
    Route::get('skills', 'WorldController@getSkills');
    Route::get('skills/{id}', 'WorldController@getSkill');

    Route::get('collections', 'WorldController@getCollections');
    Route::get('collections/{id}', 'WorldController@getCollection');
    Route::get('collection-categories', 'WorldController@getCollectionCategories');
});

Route::group(['prefix' => 'prompts'], function () {
    Route::get('/', 'PromptsController@getIndex');
    Route::get('prompt-categories', 'PromptsController@getPromptCategories');
    Route::get('prompts', 'PromptsController@getPrompts');
    Route::get('{id}', 'PromptsController@getPrompt');
});

Route::group(['prefix' => 'shops'], function () {
    Route::get('/', 'ShopController@getIndex');
    Route::get('{id}', 'ShopController@getShop')->where(['id' => '[0-9]+']);
    Route::get('{id}/{stockId}', 'ShopController@getShopStock')->where(['id' => '[0-9]+', 'stockId' => '[0-9]+']);
    Route::get('donation-shop', 'ShopController@getDonationShop');
    Route::get('donation-shop/{id}', 'ShopController@getDonationShopStock')->where(['id' => '[0-9]+']);
});

Route::get('event-tracking', 'PromptsController@getEventTracking');

/**************************************************************************************************
    Pet Drops
**************************************************************************************************/
Route::get('pets/pet/{id}', 'Users\PetController@getPetDrops');

/**************************************************************************************************
    Site Pages
**************************************************************************************************/
Route::get('credits', 'PageController@getCreditsPage');
Route::get('info/{key}', 'PageController@getPage');

/**************************************************************************************************
    Raffles
**************************************************************************************************/
Route::group(['prefix' => 'raffles'], function () {
    Route::get('/', 'RaffleController@getRaffleIndex');
    Route::get('view/{id}', 'RaffleController@getRaffleTickets');
});

/**************************************************************************************************
    Submissions
**************************************************************************************************/
Route::group(['prefix' => 'submissions', 'namespace' => 'Users'], function () {
    Route::get('view/{id}', 'SubmissionController@getSubmission');
});
Route::group(['prefix' => 'claims', 'namespace' => 'Users'], function () {
    Route::get('view/{id}', 'SubmissionController@getClaim');
});

/**************************************************************************************************
    Comments
**************************************************************************************************/
Route::get('comment/{id}', 'PermalinkController@getComment');

/**************************************************************************************************
    Galleries
**************************************************************************************************/
Route::group(['prefix' => 'gallery'], function () {
    Route::get('/', 'GalleryController@getGalleryIndex');
    Route::get('all', 'GalleryController@getAll');
    Route::get('{id}', 'GalleryController@getGallery');
    Route::get('view/{id}', 'GalleryController@getSubmission');
    Route::get('view/favorites/{id}', 'GalleryController@getSubmissionFavorites');
});

/**************************************************************************************************
    Reports
**************************************************************************************************/
Route::group(['prefix' => 'reports', 'namespace' => 'Users'], function () {
    Route::get('/bug-reports', 'ReportController@getBugIndex');
});

/**************************************************************************************************
    Affiliates
**************************************************************************************************/
Route::group(['prefix' => 'affiliates'], function () {
    Route::get('/', 'AffiliateController@getIndex')->name('affiliates');
    Route::get('apply', 'AffiliateController@getApply')->name('apply_affiliate');
    Route::get('status/{slug}', 'AffiliateController@getStatus')->name('affiliate_status');
    Route::post('apply', 'AffiliateController@postApply')->name('post_apply_affiliate');
});
/**************************************************************************************************
    World Expansion
**************************************************************************************************/

Route::group(['prefix' => 'world', 'namespace' => 'WorldExpansion'], function () {
    Route::get('info', 'LocationController@getWorld');
    Route::get('locations', 'LocationController@getLocations');
    Route::get('locations/{id}', 'LocationController@getLocation');
    Route::get('locations/{id}/submissions', 'LocationController@getLocationSubmissions');
    Route::get('location-types', 'LocationController@getLocationTypes');
    Route::get('location-types/{id}', 'LocationController@getLocationType');

    Route::get('faunas', 'NatureController@getFaunas');
    Route::get('faunas/{id}', 'NatureController@getFauna');
    Route::get('fauna-categories', 'NatureController@getFaunaCategories');
    Route::get('fauna-categories/{id}', 'NatureController@getFaunaCategory');

    Route::get('floras', 'NatureController@getFloras');
    Route::get('floras/{id}', 'NatureController@getFlora');
    Route::get('flora-categories', 'NatureController@getFloraCategories');
    Route::get('flora-categories/{id}', 'NatureController@getFloraCategory');

    Route::get('events', 'EventController@getEvents');
    Route::get('events/{id}', 'EventController@getEvent');
    Route::get('event-categories', 'EventController@getEventCategories');
    Route::get('event-categories/{id}', 'EventController@getEventCategory');

    Route::get('figures', 'FigureController@getFigures');
    Route::get('figures/{id}', 'FigureController@getFigure');
    Route::get('figure-categories', 'FigureController@getFigureCategories');
    Route::get('figure-categories/{id}', 'FigureController@getFigureCategory');

    Route::get('factions', 'FactionController@getFactions');
    Route::get('factions/{id}', 'FactionController@getFaction');
    Route::get('faction-types', 'FactionController@getFactionTypes');
    Route::get('faction-types/{id}', 'FactionController@getFactionType');
    Route::get('factions/{id}/members', 'FactionController@getFactionMembers');

    Route::get('concepts', 'ConceptController@getConcepts');
    Route::get('concepts/{id}', 'ConceptController@getConcept');
    Route::get('concept-categories', 'ConceptController@getConceptCategories');
    Route::get('concept-categories/{id}', 'ConceptController@getConceptCategory');
});
Route::get('time' , function() {
    return date('Y-m-d H:i:s');
});
