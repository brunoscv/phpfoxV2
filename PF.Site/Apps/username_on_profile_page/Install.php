<?php
            namespace Apps\username_on_profile_page;

            use Core\App;

            /**
             * Class Install
             * @author  Neil J. <neil@phpfox.com>
             * @version 4.6.0
             * @package Apps\username_on_profile_page
             */
            class Install extends App\App
            {
                private $_app_phrases = [
        
                ];
                protected function setId()
                {
                    $this->id = 'username_on_profile_page';
                }
                protected function setAlias() 
                {
            }
            protected function setName()
            {
                $this->name = 'Username on Profile';
            } protected function setVersion() {
                $this->version = '1.2';
            } protected function setSupportVersion() {
            $this->start_support_version = '4.4.0';
            // $this->end_support_version = '4.6.1';
        } protected function setSettings() {
                $this->settings = ['ennableUP' => ['type' => 'input:radio','info' => 'Enable Username on Profile','value' => '1',],'colorUP' => ['type' => 'input:text','info' => 'Username color (e.g. #ffffff)','value' => '#ffffff',],'sizeUP' => ['type' => 'input:text','info' => 'Username size (e.g. 14px)','value' => '14px',],'ennableSH' => ['type' => 'input:radio','info' => 'Enable shadow','value' => '0',],];
            } protected function setUserGroupSettings() {} protected function setComponent() {} protected function setComponentBlock() {} protected function setPhrase() {
            $this->phrase = $this->_app_phrases;
        } protected function setOthers() {
                $this->icon = 'http://apps.phpfoxer.net/module_icons_important/username_on_profile.jpg';
            }
                public $store_id = '1627';
                public $vendor = ' Copyright phpFoxer (<a href="http://www.phpfoxer.com" target="_blank" alt="phpFox mobile apps and custom development">www.phpfoxer.com</a>)';}