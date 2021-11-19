<?php
/**
 * The Horde_Tree_Renderer_Nodes class "renders" the tree structure of the top
 * application menu: it ouputs a json-object.
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
     * @return json  The json code of the rendered tree.
     * This outputs the following Jsons-example for React:
     * {
     *  entryId: "subpage1_category",
     *  type: "entry",
     *  parent: "",
     *  caption: "Category 1",
     *  action: "router",
     *  targetUrl: "/subpage1",
     *  icon: "",
     * }
     */
    public function getNodes()
    {       
        $nodes = $this->_tree->getNodes();
        
        // Resulting object for react
        $reactOb = [];

        // Creating basic array without parents
        foreach($nodes as $key => $value){

            $reactOb_Value['entryId'] = $key;
            $reactOb_Value['type'] = 'entry';  
            $reactOb_Value['parent'] = '';
            $reactOb_Value['caption'] = $value['label'];
            $reactOb_Value['action'] = 'router';       
            $reactOb_Value['targetUrl'] = $value['url'];
            $reactOb_Value['icon'] = $value['icon'];            

            $reactOb[$key] = $reactOb_Value;
        }

        // Creating more specific array with parents
        foreach($nodes as $key => $value){

            if (isset($value['children'])) {
                # if children, then assign parent to child
                foreach($value['children'] as $childname){
                    $reactOb[$childname]['parent'] = $key;
                }   
            }
        }
        return $reactOb; 
    }
}
      
            