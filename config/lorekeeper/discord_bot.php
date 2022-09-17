<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Discord Bot Settings
    |--------------------------------------------------------------------------
    |
    | This controls various settings relating to the Discord bot and its
    | functionality.
    |
    */

    // list of registered commands and their descriptions
    'commands' => [
        [
            'name'        => 'ping',
            'description' => 'Checks delay.',
        ],
        [
            'name'        => 'rank',
            'description' => 'Displays level, EXP, etc. information by generating a rank card.',
        ],
    ],

    // Channels to ignore for EXP rewards
    // Commands will still work in them, however
    //
    'ignored_channels' => [
        // put channel IDs here, e.g.
        // 0000000000000000000
    ],

    // These settings pertain to the generation of rank cards
    'rank_cards' => [
        // Color used for the background of the rank card
        'background_color' => '#fff',
        // Color used for background elements, such as the empty part of
        // the EXP bar
        'accent_color' => '#ddd',
        // Opacity of accent backgrounds. Set to null or 100 for full opacity
        'accent_opacity' => 75,
        // Color used for the filled portion of the EXP bar
        'exp_bar' => '#62bd77',

        // Color used for regular text
        'text_color' => '#000',
        // Color used for EXP bar text. Set to null to use regular text color
        'exp_text' => null,
        // This should be a path relative to the site's public directory
        'font_file' => 'webfonts/RobotoCondensed-Regular.ttf',

        // Image file to insert as a "logo" into the corner of the rank card
        // Should be relative to the site's public directory (e.g. 'images/meta-image.png')
        // Set to null to disable
        'logo_insert' => 'images/meta-image.png',
    ],

    /*
    |--------------------------------------------------------------------------
    | env Values
    |--------------------------------------------------------------------------
    |
    | Do not change these! This is used so that values in the env can be cached
    | for performance.
    |
    */

    'env' => [
        'token'                => env('DISCORD_BOT_TOKEN'),
        'announcement_channel' => env('DISCORD_ANNOUNCEMENT_CHANNEL'),
        'error_channel'        => env('DISCORD_ERROR_CHANNEL'),
    ],

];
