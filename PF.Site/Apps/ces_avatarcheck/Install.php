<?php
            namespace Apps\ces_avatarcheck;

            use Core\App;

            /**
             * Class Install
             * @author  Neil
             * @version 4.5.0
             * @package Apps\ces_avatarcheck
             */
            class Install extends App\App
            {
                private $_app_phrases = [
        
                ];
                protected function setId()
                {
                    $this->id = 'ces_avatarcheck';
                }
                protected function setAlias() 
                {
            }
            protected function setName()
            {
                $this->name = 'Avatar Check';
            } protected function setVersion() {
                $this->version = '4.7.1';
            } protected function setSupportVersion() {
            $this->start_support_version = '4.5.0';
            $this->end_support_version = '4.6.9';
        } protected function setSettings() {
                $this->settings = ['enable_avatarcheck' => ['info' => 'Enable App?','type' => 'input:radio','value' => '1',],];
            } protected function setUserGroupSettings() {} protected function setComponent() {} protected function setComponentBlock() {} protected function setPhrase() {
            $this->phrase = $this->_app_phrases;
        } protected function setOthers() {
			
			$this->_publisher = 'cespiritual';
        $this->_publisher_url = 'https://store.phpfox.com/techie/u/cespiritual';
		
                $this->admincp_route = '/admincp/ces_avatarcheck/promotions';
            
                $this->admincp_menu = ['Make a Donation' => 'ces_avatarcheck.promotions',];
            
                $this->icon = 'https://s3.amazonaws.com/phpfox-store/uploads/2018/07/20152230/avatar.png';
            }
                public $store_id = '1601';
                public $vendor = 'myphpfoxmods.com - See all our apps <a href="http://store.phpfox.com/apps?search=cespiritual" target=_new>HERE</a> - contact us at: contact@myphpfoxmods.com';
                public $requires = ['phpfox' => '>= 4.5.0',];
                public $blocks = ['0' => ['callback' => 'Avatar Check','route' => 'core.index-member','location' => '2',],];
                public $admincpMenu = ['See all our Apps' => 'ces_avatarcheck.promotions',];}