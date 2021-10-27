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


require_once __DIR__ . '/lib/Application.php';
Horde_Registry::appInit('passwd');



print_r("right..");


$pathHelper = $GLOBALS['injector']->getInstance(\Passwd_PathHelper::class);
$root = $pathHelper->ttWebroot();

// print_r("test: ".$root);
$jsGlobals = [
    'url' => $_vars->return_to,
    'userid' => $_userid,
    'sessionToken' => "test",//$_session->getToken(),
    'languageKey' => 'de' //this is needed otherwise error "thisGlobal.horde.languageKey is not defined": 
];

$view = new Horde_View(array(
    'templatePath' => PASSWD_TEMPLATES
));

$view->jsGlobals = json_encode($jsGlobals);

$page_output->addScriptFile("main.js");
$page_output->addScriptFile("chunk.js");
$page_output->footer();

$output = $view->render('react-init'); //looks in tempalte folder and finds react-init.... file

echo $output;


// \Horde::debug($output, '/dev/shm/test1', false);

// print_r($view);
// $view->jsGlobals = json_encode($jsGlobals);



// // $this->page_output->addScriptFile("3run.js");
// $page_output->addScriptFile("main.js");
// $page_output->addScriptFile("chunk.js");


// $view->render('react-init');

// $page_output->footer(); //without the footer js will not be included. Question: js is placed weirdly above page, check page source

// require_once 'lib/Autoloader.php';

// $ResponseFactory = $injector->getInstance('RequestFactory');
// $StreamFactory= $injector->getInstance('StreamFactory');
// $Horde_Variables = $injector->getInstance('Horde_Variables');
// $Horde_Session = $injector->getInstance('Horde_Session');
// $Horde_PageOutput = $injector->getInstance('Horde_PageOutput');

// return $ob = new ReactInit($ResponseFactory, $StreamFactory, $Horde_Variables, $Horde_Session, $Horde_PageOutput);

// $this->page_output->addScriptFile("main.js");
// $this->page_output->addScriptFile("chunk.js");

// $ob->render();

// $this->page_output->footer();
// $status = $ob->status();

// $page_output->header(array(
//     'view' => $registry::VIEW_BASIC,

// ));


// $page_output->addScriptFile("1main.js");
// $page_output->addScriptFile("2chunk.js");



// echo $status;
// $ob->render();

// $page_output->footer();
