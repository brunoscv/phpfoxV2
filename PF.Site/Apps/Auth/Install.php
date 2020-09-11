<?php
            namespace Apps\Auth;

            use Core\App;

            /**
             * Class Install
             * @copyright [PHPFOX_COPYRIGHT]
             * @author phpFox LLC
             * @version 4.1.0
             * @package Apps\Auth
             */
            class Install extends App\App
            {
                private $_app_phrases = [
        
                ];
                protected function setId()
                {
                    $this->id = 'Auth';
                }
                protected function setAlias() 
                {
            }
            protected function setName()
            {
                $this->name = 'Auth';
            } protected function setVersion() {
                $this->version = '4.1.0';
            } protected function setSupportVersion() {
            $this->start_support_version = '4.8.1';
            $this->end_support_version = '4.8.1';
        } protected function setSettings() {} protected function setUserGroupSettings() {} protected function setComponent() {} protected function setComponentBlock() {} protected function setPhrase() {
            $this->phrase = $this->_app_phrases;
        } protected function setOthers() {}}