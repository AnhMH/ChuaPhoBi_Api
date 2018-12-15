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
class Controller_Settings extends \Controller_App {

    /**
     * Get list
     */
    public function action_general() {
        return \Bus\Settings_General::getInstance()->execute();
    }
    
    /**
     * Add update
     */
    public function action_addupdate() {
        return \Bus\Settings_AddUpdate::getInstance()->execute();
    }
    
    /**
     * Detail
     */
    public function action_detail() {
        return \Bus\Settings_Detail::getInstance()->execute();
    }
    
    /**
     * Set page view
     */
    public function action_setpageview() {
        return \Bus\Settings_SetPageView::getInstance()->execute();
    }
}
