<?php
use Horde\Core\Middleware\AuthHordeSession;
use Horde\Core\Middleware\RedirectToLogin;
use Horde\Passwd\Handler\ChangePasswordApiController;

$mapper->connect(
    'Api',
    '/api/:action',
    [
        'controller' => ChangePasswordApiController::class,
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
