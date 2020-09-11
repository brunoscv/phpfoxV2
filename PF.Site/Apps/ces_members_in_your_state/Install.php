<?php
            namespace Apps\ces_members_in_your_state;

            use Core\App;

            /**
             * Class Install
             * @author  Neil
             * @version 4.5.0
             * @package Apps\ces_members_in_your_state
             */
            class Install extends App\App
            {
                private $_app_phrases = [
        
                ];
                protected function setId()
                {
                    $this->id = 'ces_members_in_your_state';
                }
                protected function setAlias() 
                {
            }
            protected function setName()
            {
                $this->name = 'Members In Your State';
            } protected function setVersion() {
                $this->version = '4.7.01';
            } protected function setSupportVersion() {
            $this->start_support_version = '4.5.0';
            $this->end_support_version = '4.6.9';
        } protected function setSettings() {
                $this->settings = ['gender_state' => ['info' => 'Only show members of the opposite sex?','type' => 'input:radio','value' => '0',],'avatar_state' => ['info' => 'Only show members with avatars?','type' => 'input:radio','value' => '0',],'nametype_state' => ['info' => 'Use Full Name?','type' => 'input:radio','value' => '1',],'number_members_state' => ['info' => 'Number of Members','value' => '6',],];
            } protected function setUserGroupSettings() {} protected function setComponent() {} protected function setComponentBlock() {} protected function setPhrase() {
            $this->phrase = $this->_app_phrases;
        } protected function setOthers() {
			
			$this->_publisher = 'cespiritual';
        	$this->_publisher_url = 'https://store.phpfox.com/techie/u/cespiritual';
			
                $this->admincp_route = '/admincp/ces_members_in_your_state/promotions';
            
                $this->admincp_menu = ['Make a Donation' => 'ces_members_in_your_state.promotions',];
            
                $this->icon = 'https://s3.amazonaws.com/phpfox-store/uploads/2018/07/20212136/state.png';
            }
                public $store_id = '863';
                public $vendor = 'myphpfoxmods.com - See all our apps <a href="http://store.phpfox.com/apps?search=cespiritual" target=_new>HERE</a> - contact us at: contacto@paxcreative.pt';
                public $requires = ['phpfox' => '>= 4.5.0',];
                public $blocks = ['0' => ['callback' => 'Members In Your State','route' => 'core.index-member','location' => '3',],];
                public $admincpMenu = ['Members Near You (upgrade)' => 'ces_members_in_your_state.promotions',];}