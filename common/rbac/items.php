<?php
return [
     'guest' => [
         'type' => 1,
         'description' => 'Guest',
     ],
     'user' => [
         'type' => 1,
         'description' => 'User',
         'ruleName' => 'notGuest',
         'children' => [
             'guest',
         ],
     ],
     'tier2User' => [
         'type' => 1,
         'description' => 'A tier 2 logged user',
         'ruleName' => 'tier2',
         'children' => [
             'guest',
         ],
     ],
    'staff' => [
        'type' => 1,
        'description' => 'Staff Member',
        'children' => [
            'affiliate',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Administrator',
        'children' => [
            'staff',
        ],
    ],
    'god' => [
        'type' => 1,
        'description' => 'IRGOD',
        'children' => [
            'admin',
        ],
    ],
];