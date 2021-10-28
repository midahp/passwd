<?php
namespace Horde\Passwd\Test\Unit\Driver;
use \Horde\Passwd\Test\PasswdTestCase;
use \Horde_Db_Adapter_Pdo_Sqlite;
use \Passwd_Factory_Driver;
use \Passwd_Driver_Sql;
use \Horde_Test_Setup;
/**
 * Test the Sql backend driver.
 *
 * @author     Ralf Lang <lang@b1-systems.de>
 * @category   Horde
 * @copyright  2013-2021 Horde LLC
 * @internal
 * @package    Passwd
 * @subpackage UnitTests
 */
class SqlTest extends PasswdTestCase
{
    private $driver;

    public static function setUpBeforeClass(): void
    {
        self::createBasicPasswdSetup(new Horde_Test_Setup());
        parent::setUpBeforeClass();
    }

    public function setUp(): void
    {
        $GLOBALS['injector'] = $this->getInjector();
        $factory = new Passwd_Factory_Driver($this->getInjector());
        $factory->backends = array();

        // Get a Horde_Db_Adapter to prevent usage of Horde_Core_Factory_Db.
        $db = new Horde_Db_Adapter_Pdo_Sqlite(array('dbname' => ':memory:'));
        $db->execute("CREATE TABLE horde_users (
            user_uid VARCHAR(255) PRIMARY KEY NOT NULL,
            user_pass VARCHAR(255) NOT NULL,
            user_soft_expiration_date INTEGER,
            user_hard_expiration_date INTEGER
        );");

        $this->driver = new Passwd_Driver_Sql(array('db' => $db));
    }

    public function testSetup()
    {
        $this->assertInstanceOf('Passwd_Driver', $this->driver);
    }

    /**
     * @expectedException Passwd_Exception
     */
    public function testChangePasswordFailsForNonexistingUser()
    {
        $res = $this->driver->changePassword('Patricia', 'alt', 'neu');
    }

}
