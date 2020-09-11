<?php
            namespace Apps\ces_movies;

            use Core\App;

            
            class Install extends App\App
            {
                private $_app_phrases = [
        
                ];
                protected function setId()
                {
                    $this->id = 'ces_movies';
                }
                protected function setAlias()
    {
        $this->alias = 'movies';
    }

            protected function setName()
            {
                $this->name = 'Movies System - Light';
            } protected function setVersion() {
                $this->version = '4.6.0';
            } protected function setSupportVersion() {
            $this->start_support_version = '4.5.0';
            $this->end_support_version = '4.6.9';
        } protected function setSettings() {
                $this->settings = ['share_manual' => ['type' => 'input:radio','info' => 'Share movies manualy? (Set this to yes only if the API stops working)','value' => '0',],'translate_content' => ['type' => 'input:radio','info' => 'Translate the content of the movie? (default English)','value' => '0',],'translate_language' => ['info' => 'Set the language code for translation (ex: FR, PT, ES...)','value' => '',],'number_movies' => ['info' => 'Number of Movies to show before the view more button','value' => '20',],'show_star' => ['type' => 'input:radio','info' => 'Show star and eye on posters?','value' => '1',],'star_color' => ['info' => 'Color of the star in posters (use name or RGB code)','value' => 'orange',],'eye_color' => ['info' => 'Color of the eye in posters (use name or RGB code)','value' => 'orange',],'show_imdb' => ['type' => 'input:radio','info' => 'Show imdb rating on posters?','value' => '1',],'imdb_color' => ['info' => 'Background color of the imdb rating (use name or RGB code)','value' => '#dfa800',],'show_year' => ['type' => 'input:radio','info' => 'Show year on posters?','value' => '1',],'year_color' => ['info' => 'Background color of the year (use name or RGB code)','value' => '#458a50',],'rating_stars' => ['type' => 'input:radio','info' => 'Show rating stars on movies page?','value' => '1',],'show_social' => ['type' => 'input:radio','info' => 'Show social icons on movies page?','value' => '1',],'add_feed_movie' => ['type' => 'input:radio','info' => 'Create a feed on new movies?','value' => '1',],'add_feed_reviews' => ['type' => 'input:radio','info' => 'Create a feed on new reviews?','value' => '1',],'add_feed_upcoming' => ['type' => 'input:radio','info' => 'Create a feed for upcoming movies?','value' => '1',],'notify_fav' => ['type' => 'input:radio','info' => 'Create a notification on favorites?','value' => '1',],'review_num' => ['info' => 'Number of reviews to show','value' => '3',],'review_text' => ['info' => 'Number of character in review text for Last Reviews block','value' => '300',],'show_tag_dashboard' => ['type' => 'input:radio','info' => 'Show info tags on dashboard blocks?','value' => '1',],'show_upcoming' => ['type' => 'input:radio','info' => 'Show upcoming block on dashboard?','value' => '1',],'num_upcoming' => ['info' => 'How many movies to show for upcoming block?','value' => '10',],'num_upcoming_search' => ['info' => 'How many movies to search each time for upcoming block? (higher the number more time will take to show the block)','value' => '5',],'show_last' => ['type' => 'input:radio','info' => 'Show last block on dashboard?','value' => '1',],'num_last' => ['info' => 'How many movies for last block?','value' => '10',],'show_top' => ['type' => 'input:radio','info' => 'Show top block on dashboard?','value' => '1',],'num_top' => ['info' => 'How many movies for top block?','value' => '10',],'show_viewed' => ['type' => 'input:radio','info' => 'Show most viewed block on dashboard?','value' => '1',],'num_viewed' => ['info' => 'How many movies for most viewed block?','value' => '10',],'show_reviewed' => ['type' => 'input:radio','info' => 'Show most reviewed block on dashboard?','value' => '1',],'num_reviewed' => ['info' => 'How many movies for most reviewed block?','value' => '10',],'show_right' => ['type' => 'input:radio','info' => 'Show right column on movie view and dashboard?','value' => '1',],'num_search' => ['info' => 'How many movies to show when searching?','value' => '20',],'fav_block' => ['info' => 'How many movies to show on the favorite block in profiles?','value' => '9',],'hide_username' => ['type' => 'input:radio','info' => 'Hide username on movies page?','value' => '0',],'hide_views' => ['type' => 'input:radio','info' => 'Hide views on movies page?','value' => '0',],'hide_guests' => ['type' => 'input:radio','info' => 'Hide dashboard for guests?','value' => '0',],];
            } protected function setUserGroupSettings() {
                $this->user_group_settings = ['share_movie' => ['info' => 'Can this usergroup share movies?','type' => 'input:radio','value' => '1','js_variable' => '1',],'review' => ['info' => 'Can this usergroup review the movies?','type' => 'input:radio','value' => '1','js_variable' => '1',],'edit' => ['info' => 'Can this usergroup edit movies?','type' => 'input:radio','value' => '1','js_variable' => '1',],];
            } protected function setComponent() {} protected function setComponentBlock() {} protected function setPhrase() {
            $this->phrase = $this->_app_phrases;
        } protected function setOthers() {

		$this->_publisher = 'cespiritual';
        	$this->_publisher_url = 'https://store.phpfox.com/techie/u/cespiritual';

                
			$this->notifications = ['my_update' => ['message' => _p("<b>{{ user_full_name }}</b> added one of your movies to their favorite list!"),'url' => '/movies/view?m=tt:id',],];
            
                
                

			$this->admincp_route = '/admincp/ces_movies/promotions';
            
                $this->admincp_action_menu = ['/admincp/ces_movies/categories' => 'New Category','ratings' => 'Update IMDb Ratings'];

            
                $this->map = ['title' => 'title','content' => 'text','link' => '/movies/view',];
            
                $this->menu = ['name' => 'Movies','url' => '/movies','icon' => 'video-camera',];
            
                $this->icon = 'https://d2h79mkp7etn4r.cloudfront.net/icon/2016/05/acde2bcdb9e13dbee09ac41610175c16.png';
            }
                public $store_id = '1361';
                public $vendor = 'myphpfoxmods.com - See all our apps <a href="http://store.phpfox.com/apps?search=cespiritual" target=_new>HERE</a> - contact us at: contact@myphpfoxmods.com';
                public $requires = ['phpfox' => '>= 4.5.0',];
                public $credits = ['Movies API from OMDB' => 'http://www.omdbapi.com/','Trailers from Youtube' => 'http://www.youtube.com',];
               
                public $admincpMenu = ['See all our Apps' => 'ces_movies.promotions',];}