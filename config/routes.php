<?php
use Horde\Core\Middleware\AuthHordeSession;
use Horde\Core\Middleware\RedirectToLogin;
use Horde\Passwd\Middleware\RenderReactApp;
use Horde\Core\Middleware\ReturnSessionToken;
use Horde\Core\Middleware\DemandAuthenticatedUser;
use Horde\Core\Middleware\DemandSessionToken;

use Horde\Passwd\Handler\ReactInit;
use Horde\Passwd\Handler\Api\ChangePassword;

$mapper->connect(
    'ChangePassword',
    '/api/changepw',
    [
        'controller' => ChangePassword::class,
        'stack' => [
            AuthHordeSession::class,
            DemandAuthenticatedUser::class,
            // DemandSessionToken::class,
        ]
    ]
);

$mapper->connect(
    'ReactInit',
    '/react',
    [
        'controller' => ReactInit::class,
        'stack' => [
            AuthHordeSession::class,
            RedirectToLogin::class,
        ]
    ]
);
