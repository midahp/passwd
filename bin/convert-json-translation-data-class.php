<?php

use Horde\Core\Translation\JsonToPhpWriter;

function exitWithHelpText()
{
    $help = "This script will convert a json file into a subclass of GetTranslationBase to be used as a endpoint for gettings translation strings.
    Json File needs to be an (nested) object where the leafes are strings to be translated.";
    print($help);
    exit(0);
}

if ($argc != 2) {
    exitWithHelpText();
}

require_once dirname(__FILE__) . '/../lib/Application.php';
Horde_Registry::appInit('passwd', array('cli' => true));

$ns = $argv[1];
$filepath = $argv[2];

$converter = new JsonToPhpArrayWriter();
$converter->convert($ns, $filepath);
