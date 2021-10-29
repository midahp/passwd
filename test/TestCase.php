<?php
namespace Horde\Passwd\Test;
use \PHPUnit\Framework\TestCase;
use \Horde_Injector;
use \Horde_Injector_TopLevel;
use \Horde_Test_Setup;
use \Horde_Registry;

/**
 * @author     Ralf Lang <lang@ralf-lang.de>
 * @category   Horde
 * @copyright  2013-2021 Horde LLC
 * @internal
 * @license    http://www.horde.org/licenses/gpl GPL
 * @package    Passwd
 * @subpackage UnitTests
 */
class PasswdTestCase extends TestCase
{
    protected function getInjector()
    {
        return new Horde_Injector(new Horde_Injector_TopLevel());
    }

    protected static function createBasicPasswdSetup(Horde_Test_Setup $setup)
    {
        $setup->setup(
            array(
                '_PARAMS' => array(
                    'user' => 'test@example.com',
                    'app' => 'passwd'
                ),
                'Horde_Registry' => 'Registry',
            )
        );
        $setup->makeGlobal(
            array(
                'registry' => 'Horde_Registry',
            )
        );
    }

}
