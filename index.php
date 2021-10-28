<?php
/**
 * Main passwd script.
 *
 * Copyright 2013-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (GPL). If you
 * did not receive this file, see http://www.horde.org/licenses/gpl.
 *
 * @author    Michael Slusarz <slusarz@horde.org>
 * @category  Horde
 * @copyright 2002-2017 Horde LLC
 * @license   http://www.horde.org/licenses/gpl GPL
 * @package   Passwd
 */

// OLD PASSWD
// require_once __DIR__ . '/lib/Application.php';
// Horde_Registry::appInit('passwd');

// $ob = new Passwd_Basic($injector->getInstance('Horde_Variables'));

// $status = $ob->status();

// $page_output->header(array(
//     'title' => _("Change Password"),
//     'view' => $registry::VIEW_BASIC
// ));

// echo $status;
// $ob->render();

// $page_output->footer();

/**
 * NEW PASSWD...
 */
// $pathHelper = $GLOBALS['injector']->getInstance(\Passwd_PathHelper::class);
// $root = $pathHelper->ttWebroot();

require_once __DIR__ . '/lib/Application.php';
Horde_Registry::appInit('passwd');

$session = $GLOBALS['injector']->getInstance(\Horde_Session::class);
$registry = $GLOBALS['injector']->getInstance(\Horde_Registry::class);

$jsGlobals = [
    'appMode' => "horde",
    'sessionToken' => $session->getToken(),
    'currentAppp' => "passwd",
    'userUid' => $userid,
    'appWebroot' => "/passwd",
    'languageKey' => 'de_DE' //this is needed otherwise error "thisGlobal.horde.languageKey is not defined": 
];

$view = new Horde_View(array(
    'templatePath' => PASSWD_TEMPLATES
));

$view->jsGlobals = json_encode($jsGlobals);

// $page_output->addScriptFile("main.js");
// $page_output->addScriptFile("chunk.js");
// $page_output->footer();

$output = $view->render('react-init'); //looks in tempalte folder and finds react-init.... file

echo $output;