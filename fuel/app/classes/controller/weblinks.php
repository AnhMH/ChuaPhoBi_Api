<?php

/**
 * Controller for actions on articles
 *
 * @package Controller
 * @created 2018-03-02
 * @version 1.0
 * @author AnhMH
 * @copyright Oceanize INC
 */
class Controller_Weblinks extends \Controller_App {

    /**
     * Get list
     */
    public function action_list() {
        return \Bus\Weblinks_List::getInstance()->execute();
    }
    
    /**
     * Get list
     */
    public function action_addupdate() {
        return \Bus\Weblinks_AddUpdate::getInstance()->execute();
    }
    
    /**
     * Get list
     */
    public function action_detail() {
        return \Bus\Weblinks_Detail::getInstance()->execute();
    }
    
    /**
     * Disable
     */
    public function action_disable() {
        return \Bus\Weblinks_Disable::getInstance()->execute();
    }
    
    /**
     * Disable
     */
    public function action_all() {
        return \Bus\Weblinks_All::getInstance()->execute();
    }
}
