<?php

declare(strict_types=1);

return [
    'avatar' => [
        'storage' => [
            'path' => 'avatars'
        ],
        'gravatar' => [
            'default_image' => 'mp', // https://en.gravatar.com/site/implement/images/#default-image
            'default_size' => 100
        ]
    ],
    'invitation' => [
        'default_expiry_days' => 30
    ],
];
