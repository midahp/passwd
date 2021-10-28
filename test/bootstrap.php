<?php
$candidates = [
    dirname(__FILE__, 2) . '/vendor/autoload.php',
    dirname(__FILE__, 4) . '/vendor/autoload.php',
];
// Cover root case and web/ case
foreach ($candidates as $candidate) {
    if (file_exists($candidate)) {
        require_once $candidate;
    }
}
\Horde_Test_Bootstrap::bootstrap(dirname(__FILE__));
