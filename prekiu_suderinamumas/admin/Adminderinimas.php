<?php 


class AdminderinimastabController extends AdminController
{
        public function __construct()
        {
            
            parent::__construct();
            
        }
        public function renderForm(){
            
            //some basics information, only used to include your own javascript
             $this->context->smarty->assign(array(
                 'mymodule_controller_url' => $this->context->link->getAdminLink('Adminderinimas'),//give the url for ajax query
             ));
            
            //what do we want to add to the default template
            $more = $this->module->display($path, 'view/templates/admin/atvaizdas.tpl');
            
            return $more.parent::renderForm();//add you own information to the rendered template
        }
}