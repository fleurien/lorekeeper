<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Sidebar Links
    |--------------------------------------------------------------------------
    |
    | Admin panel sidebar links.
    | Add links here to have them show up in the admin panel.
    | Users that do not have the listed power will not be able to
    | view the links in that section.
    |
    */

    'Admin'      => [
        'power' => 'admin',
        'links' => [
            [
                'name' => 'User Ranks',
                'url'  => 'admin/users/ranks',
            ],
            [
                'name' => 'Admin Logs',
                'url'  => 'admin/logs',
            ],
            [
                'name' => 'Staff Reward Settings',
                'url'  => 'admin/staff-reward-settings',
            ],
        ],
    ],
    'Reports'    => [
        'power' => 'manage_reports',
        'links' => [
            [
                'name' => 'Report Queue',
                'url'  => 'admin/reports/pending',
            ],
        ],
    ],
    'Affiliates' => [
        'power' => 'manage_affiliates',
        'links' => [
            [
                'name' => 'Approved Affiliates',
                'url'  => 'admin/affiliates/current',
            ],
            [
                'name' => 'Affiliate Requests',
                'url'  => 'admin/affiliates/pending',
            ],
        ],
    ],
    'Site' => [
        'power' => 'edit_pages',
        'links' => [
            [
                'name' => 'News',
                'url'  => 'admin/news',
            ],
            [
                'name' => 'Sales',
                'url'  => 'admin/sales',
            ],
            [
                'name' => 'Pages',
                'url' => 'admin/pages'
            ],
            [
                'name' => 'Emotes',
                'url' => 'admin/emotes'
            ]
        ]
    ],
    'Users'      => [
        'power' => 'edit_user_info',
        'links' => [
            [
                'name' => 'User Index',
                'url'  => 'admin/users',
            ],
            [
                'name' => 'Invitation Keys',
                'url'  => 'admin/invitations',
            ],
        ],
    ],
    'Queues'     => [
        'power' => 'manage_submissions',
        'links' => [
            [
                'name' => 'Gallery Submissions',
                'url'  => 'admin/gallery/submissions',
            ],
            [
                'name' => 'Gallery Currency Awards',
                'url'  => 'admin/gallery/currency',
            ],
            [
                'name' => 'Prompt Submissions',
                'url'  => 'admin/submissions',
            ],
            [
                'name' => 'Claim Submissions',
                'url'  => 'admin/claims',
            ],
        ],
    ],
    'Grants'     => [
        'power' => 'edit_inventories',
        'links' => [
            [
                'name' => 'Currency Grants',
                'url'  => 'admin/grants/user-currency',
            ],
            [
                'name' => 'Item Grants',
                'url'  => 'admin/grants/items',
            ],
            [
                'name' => 'Award Grants',
                'url'  => 'admin/grants/awards',
            ],
            [
                'name' => 'Event Currency',
                'url'  => 'admin/grants/event-currency',
            ],
        ],
    ],
    'Foraging' => [
        'power' => 'edit_inventories',
        'links' => [
            [
                'name' => 'Forages',
                'url' => 'admin/data/forages'
            ],
            [
                'name' => 'EXP Grants',
                'url' => 'admin/grants/exp'
            ],
            [
                'name' => 'Pet Grants',
                'url' => 'admin/grants/pets'
            ],
            [
                'name' => 'Gear Grants',
                'url' => 'admin/grants/gear'
            ],
            [
                'name' => 'Weapon Grants',
                'url' => 'admin/grants/weapons'
            ],
            [
                'name' => 'Recipe Grants',
                'url' => 'admin/grants/recipes'
            ],
        ]
    ],
    'Masterlist' => [
        'power' => 'manage_characters',
        'links' => [
            [
                'name' => 'Create Character',
                'url'  => 'admin/masterlist/create-character',
            ],
            [
                'name' => 'Create MYO Slot',
                'url'  => 'admin/masterlist/create-myo',
            ],
            [
                'name' => 'Character Transfers',
                'url'  => 'admin/masterlist/transfers/incoming',
            ],
            [
                'name' => 'Character Trades',
                'url'  => 'admin/masterlist/trades/incoming',
            ],
            [
                'name' => 'Design Updates',
                'url'  => 'admin/design-approvals/pending',
            ],
            [
                'name' => 'MYO Approvals',
                'url'  => 'admin/myo-approvals/pending',
            ],
        ],
    ],
    'Genetics' => [
        'power' => 'view_hidden_genetics',
        'links' => [
            [
                'name' => 'Gene Groups',
                'url' => 'admin/genetics/genes'
            ],
            [
                'name' => 'Breeding Roller',
                'url' => 'admin/genetics/roller'
            ],
            [
                'name' => 'Breeding Logs',
                'url' => 'admin/genetics/logs'
            ],
        ]
    ],
    'Stats' => [
        'power' => 'edit_stats',
        'links' => [
            [
                'name' => 'Stats',
                'url' => 'admin/stats'
            ],
        ]
    ],
    'Levels' => [
        'power' => 'edit_levels',
        'links' => [
            [
                'name' => 'User Levels',
                'url' => 'admin/levels/user'
            ],
            [
                'name' => 'Character Levels',
                'url' => 'admin/levels/character'
            ],
        ]
    ],
    'Data' => [
        'power' => 'edit_data',
        'links' => [
            [
                'name' => 'Galleries',
                'url'  => 'admin/data/galleries',
            ],
            [
                'name' => 'Award Categories',
                'url'  => 'admin/data/award-categories',
            ],
            [
                'name' => 'Awards',
                'url'  => 'admin/data/awards',
            ],
            [
                'name' => 'Character Categories',
                'url'  => 'admin/data/character-categories',
            ],
            [
                'name' => 'Sub Masterlists',
                'url'  => 'admin/data/sublists',
            ],
            [
                'name' => 'Rarities',
                'url'  => 'admin/data/rarities',
            ],
            [
                'name' => 'Species',
                'url'  => 'admin/data/species',
            ],
            [
                'name' => 'Subtypes',
                'url'  => 'admin/data/subtypes',
            ],
            [
                'name' => 'Transformations',
                'url'  => 'admin/data/transformations',
            ],
            [
                'name' => 'Traits',
                'url'  => 'admin/data/traits',
            ],
            [
                'name' => 'Character Titles',
                'url'  => 'admin/data/character-titles',
            ],
            [
                'name' => 'Status Effects',
                'url' => 'admin/data/status-effects'
            ],
            [
                'name' => 'Shops',
                'url'  => 'admin/data/shops',
            ],
            [
                'name' => 'Currencies',
                'url'  => 'admin/data/currencies',
            ],
            [
                'name' => 'Prompts',
                'url'  => 'admin/data/prompts',
            ],
            [
                'name' => 'Loot Tables',
                'url'  => 'admin/data/loot-tables',
            ],
            [
                'name' => 'Items',
                'url'  => 'admin/data/items',
            ],
            [
                'name' => 'Advent Calendars',
                'url'  => 'admin/data/advent-calendars',
            ],
        [
                'name' => 'Library',
                'url' => 'admin/data/volumes'
            ],
            [
                'name' => 'Transformations',
                'url'  => 'admin/data/transformations',
            ],
            [
                'name' => 'Pets',
                'url' => 'admin/data/pets'
            ],
            [
                'name' => 'Collections',
                'url' => 'admin/data/collections'
            ],
            [
                'name' => 'Recipes',
                'url' => 'admin/data/recipes'
            ],
        ]
    ],
    'Claymores' => [
        'power' => 'edit_claymores',
        'links' => [
            [
                'name' => 'Gear',
                'url' => 'admin/gear'
            ],
            [
                'name' => 'Weapons',
                'url' => 'admin/weapon'
            ],
            [
                'name' => 'Character Classes',
                'url' => 'admin/character-classes'
            ],
            [
                'name' => 'Character Skills',
                'url' => 'admin/data/skills'
            ]
        ]
    ],
    'World.Expanded' => [
        'power' => 'manage_world',
        'links' => [
            [
                'name' => 'Locations',
                'url'  => 'admin/world/locations',
            ],
            [
                'name' => 'Fauna',
                'url'  => 'admin/world/faunas',
            ],
            [
                'name' => 'Flora',
                'url'  => 'admin/world/floras',
            ],
            [
                'name' => ' Events',
                'url'  => 'admin/world/events',
            ],
            [
                'name' => ' Figures',
                'url'  => 'admin/world/figures',
            ],
            [
                'name' => 'Factions',
                'url'  => 'admin/world/factions',
            ],
            [
                'name' => 'Concepts',
                'url'  => 'admin/world/concepts',
            ],
        ],
    ],
    'Raffles'    => [
        'power' => 'manage_raffles',
        'links' => [
            [
                'name' => 'Raffles',
                'url'  => 'admin/raffles',
            ],
        ],
    ],
    'Settings'   => [
        'power' => 'edit_site_settings',
        'links' => [
            [
                'name' => 'Site Settings',
                'url'  => 'admin/settings',
            ],
            [
                'name' => 'Site Images',
                'url'  => 'admin/images',
            ],
            [
                'name' => 'File Manager',
                'url'  => 'admin/files',
            ],
            [
                'name' => 'Theme Manager',
                'url' => 'admin/themes'
            ],
        ]
    ],
];
