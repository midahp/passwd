<?php
use Horde\Core\Middleware\AuthHordeSession;
use Horde\Core\Middleware\RedirectToLogin;
use Horde\Passwd\Middleware\RenderReactApp;
use Horde\Core\Middleware\ReturnSessionToken;
use Horde\Core\Middleware\DemandAuthenticatedUser;
use Horde\Core\Middleware\DemandSessionToken;
use Horde\Core\Translation\Middleware\Api\GetLanguages;

use Horde\Passwd\Middleware\GetTranslation;
use Horde\Passwd\Handler\ReactInit;
use Horde\Passwd\Handler\Api\ChangePassword;
use Horde\Passwd\Middleware\Ui;



$mapper->connect(
    'Change Password',
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
    'Get Languages',
    '/i18n/get-supported-languages',
    [
        'controller' => GetLanguages::class,
        'stack' => [
            AuthHordeSession::class,
            DemandAuthenticatedUser::class,
            // DemandSessionToken::class,
        ]
    ]
);

$mapper->connect(
    'Get Translation',
    '/i18n/:languageCode/:app/:namespace',
    [
        'controller' => GetTranslation::class,
        'namespace' => 'translation',
        'stack' => [
            AuthHordeSession::class,
            DemandAuthenticatedUser::class,
            // DemandSessionToken::class,
        ],
    ]
);

$mapper->connect(
    'UI',
    '/index.php',
    [
        'controller' => Ui::class
    ]
);
$mapper->connect(
    'Index',
    '/*path',
    [
        'controller' => Ui::class
    ]
);
