<?php

return [

    /*
   |----------------------------------------------------------
   | Administrators
   |----------------------------------------------------------
   |
   | This array contains admin emails, put email of users who
   | should be an administrator in there
   |
   */
    'admins' => [
        'test@example.com',
        // other super admins email

    ],

    /*
    |----------------------------------------------------------
    | Footer items
    |----------------------------------------------------------
    |
    | This array contains items that will show in the footer.
    | there are two type of items: link, text
    |
    */
    'footer' => [
        'sections' => [
            'Social Media' => [
                ['name' => 'twitter',   'type' => 'link', 'value' => 'http://twitter.com/laraword',],
                ['name' => 'instagram', 'type' => 'link', 'value' => 'http://instagram.com/laraword',],
                ['name' => 'telegram',  'type' => 'link', 'value' => 'http://t.me/laraword',],
                ['name' => 'facebook',  'type' => 'link', 'value' => 'http://facebook.com/laraword',],
            ],

            'Pages' => [
                ['name' => 'Policy',  'type' => 'link', 'value' => '/policy',],
                ['name' => 'About',   'type' => 'link', 'value' => '/about',],
                ['name' => 'Contact', 'type' => 'link', 'value' => '/contact',],
                ['name' => 'Terms',   'type' => 'link', 'value' => '/terms',],
            ],

            'Info' => [
                ['name' => 'Phone',  'type' => 'text', 'value' => '555-432-555',],
                ['name' => 'Address','type' => 'text', 'value' => ' somewhere in the github :) Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid animi atque blanditiis consectetur dolorem excepturi ',],
            ],
        ],
    ],
];
