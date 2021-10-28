<?php
require_once dirname(__FILE__, 3) . '/vendor/autoload.php';
if (is_readable(__DIR__ . '/config/horde.local.php')) {
    require_once __DIR__ . '/config/horde.local.php';
}
// Guess
if (!defined(HORDE_BASE)) {
    define(HORDE_BASE, dirname(__FILE__, 2) . '/horde/');
}
require_once HORDE_BASE . '/lib/core.php';
Horde\Core\RampageBootstrap::run();