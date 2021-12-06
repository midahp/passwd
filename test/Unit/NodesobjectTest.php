<?php
use \Horde\Passwd\Test\PasswdTestCase;


/**
 * Test the Nodesobject - Horde_Tree functions
 *
 * @author     Rafael te Boekhorst <boekhorst@b1-systems.de>
 * @category   Horde
 * @copyright  2013 Horde LLC
 * @internal
 * @license    http://www.horde.org/licenses/gpl GPL
 * @package    Passwd
 * @subpackage UnitTests
 */
class NodesobjectTest extends PasswdTestCase
{
    
    // public function __construct(
    //     \Horde_Core_Factory_Topbar $topbar,
    //     $logger = null        
    // ) {
    //     $this->topbar = $topbar;      
    //     $this->logger = $logger;        
    // }


    public function testTree(){
        
        
        $GLOBALS['injector'] = $this->getInjector();
        $topbar = $GLOBALS['injector']->getInstance(\Horde_Core_Factory_Topbar::class);
        // $registry = $GLOBALS['injector']->getInstance(\Horde_Registry::class);

        // getting node information of Horde top-menubar: this will be saved in jsGlobalsHorde
        $menu = $topbar->create('Passwd_Tree_Nodesobject', array('nosession' => true));
        $menu =  $menu->getTree();
        $nodes = $menu->getNodes();
        dd($nodes);
    }


}