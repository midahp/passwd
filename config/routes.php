<?php
use Horde\Core\Middleware\AuthHordeSession;
use Horde\Core\Middleware\RedirectToLogin;
    

$mapper->connect(
    'Api',
    '/api/:action',
    [
        'controller' => 'ApiPasswordReact',
        'stack' => [

        ],
    ]
);

$mapper->connect(
    'ReactInit',
    '/react',
    [
        'controller' => 'ChangePasswordReact',
        'stack' => [
            AuthHordeSession::class,
            RedirectToLogin::class,
        ]
    ]
);
