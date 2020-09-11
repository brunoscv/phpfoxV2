<?php
 
namespace Apps\Auth\Controller;

use Phpfox;
 
// Index controller must be child of \Phpfox_Component class.
 
class IndexController extends \Phpfox_Component
{
    public function process()
    {
        // Get phpFox core template service
        $template = $this->template();
 
        // set view title
        $template->setTitle('MinistryCRM Auth');
 
        // set view breadcrumb
 
        // get url
        $url = $this->url()->makeUrl('auth');
 
        $template->setBreadCrumb('MinistryCRM Auth',$url);
 
        // add your section menus
        $template->buildSectionMenu('auth', [
            'Browse' => $this->url()->makeUrl('/auth'),
            'Create' => $this->url()->makeUrl('/auth/add'),
        ]);

        // get current requests
        $request = $this->request();
 
        // get request data
        $vals = $request->get('val');
 
        if (!empty($vals)) {
            // validate
            if (empty($vals['email'])) {
                \Phpfox_Error::set(_p('Email is required'));
            }
 
            if (empty($vals['password'])) {
                \Phpfox_Error::set(_p('Password is required'));
            }
 
            if (\Phpfox_Error::isPassed()) {
                
                Phpfox::getService('user.auth')->login($vals['email'], $vals['password']);
                $this->url()->send('user/browse'); // redirect to to-do-list
            }
        }
    }
}