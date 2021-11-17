<?php
/**
 * The Horde_Tree_Renderer_Nodes class "renders" the tree structure of the top
 * application menu: it ouputs a json-object.
 * 
 *
 *
 * Copyright 2012-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL-2). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl.
 *
 * @author   Rafael te Boekhorst <boekhorst@b1-systems.de>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl LGPL-2
 * @package  Horde
 */
class Passwd_Tree_Nodesobject extends Horde_Tree_Renderer_Base
{
     /**
     * Returns the tree.
     *
     * @param boolean $static  Unused.
     *
     * @return json  The json code of the rendered tree.
     */
    public function getNodes()
    {
        $postdata = $this->_tree->getNodes();
        $post = json_encode($postdata, JSON_FORCE_OBJECT);
        $post = json_decode($post);
        return $post; 
    }

}