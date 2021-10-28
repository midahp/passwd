<?php
/**
 * Main passwd script.
 *
 * Copyright 2013-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (GPL). If you
 * did not receive this file, see http://www.horde.org/licenses/gpl.
 *
 * @author    Michael Slusarz <slusarz@horde.org>
 * @author    Ralf Lang <lang@b1-systems.de>
 * @category  Horde
 * @copyright 2002-2021 Horde LLC
 * @license   http://www.horde.org/licenses/gpl GPL
 * @package   Passwd
 */
require_once __DIR__ . '/lib/Application.php';
Horde_Registry::appInit('passwd');
global $registry;
global $prefs;
$ui = $prefs->getValue('dynamic_ui');
$dynamic = $registry->getView() === Horde_Registry::VIEW_DYNAMIC;

if ($dynamic && $ui == 'material') {
    $session = $GLOBALS['injector']->getInstance(\Horde_Session::class);
    $registry = $GLOBALS['injector']->getInstance(\Horde_Registry::class);
    
    $jsGlobals = [
        'appMode' => 'horde',
        'sessionToken' => $session->getToken(),
        'currentApp' => $registry->getApp(),
        'userUid' => $registry->getAuth(),
        'apps' => $registry->listApps(null, true),
        // TODO: Apps always show their English name
        'appWebroot' => $registry->get('webroot', 'passwd'),
        'languageKey' => $registry->preferredLang()
    ];

    $view = new Horde_View(array(
        'templatePath' => PASSWD_TEMPLATES
    ));
    $view->jsGlobals = json_encode($jsGlobals);
    $output = $view->render('react-init');
    echo $output;
    exit;
}

$ob = new Passwd_Basic($injector->getInstance('Horde_Variables'));

$status = $ob->status();

$page_output->header(array(
    'title' => _("Change Password"),
    'view' => $registry::VIEW_BASIC
));

echo $status;
$ob->render();

$page_output->footer();
