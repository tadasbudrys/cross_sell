<?php 
class prekiusuderinimas extends Module
{
  public function __construct()
  {
    $this->name = 'prekiusuderinimas';
    $this->tab = 'front_office_features';
    $this->version = '1.0.0';
    $this->author = 'Tadas Budrys';
    $this->need_instance = 0;
    $this->controllers = array('atvaizdas');
    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); 
    $this->bootstrap = true;
 
    parent::__construct();
 
    $this->displayName = $this->l('prekiusuderinimas');
    $this->description = $this->l('Description of my module.');
 
    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
 
    if (!Configuration::get('prekiusuderinimas')) {
      $this->warning = $this->l('No name provided');
    }
  }


public function install()
{
    
    // Run sql for creating DB tables
    Db::getInstance()->execute('
                        CREATE TABLE `prestashop`.`ps_compatibility_categorys` ( `id` INT NOT NULL AUTO_INCREMENT , `order` VARCHAR(50) NOT NULL , `visibe` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
                CREATE TABLE `prestashop`.`ps_compatibility_categorys_lang` ( `id` INT(50) NOT NULL , `id_lang` INT(50) NOT NULL , `id_cattegory` INT(50) NOT NULL , `name` VARCHAR(50) NOT NULL  ) ENGINE = InnoDB;
                    CREATE TABLE `prestashop`.`ps_compatibility_product_attributes` ( `id` INT(50) NOT NULL , `id_attribute` INT(50) NOT NULL , `id_product` INT(50) NOT NULL ) ENGINE = InnoDB;
                        CREATE TABLE `prestashop`.`ps_compatibility_attributes` ( `id` INT(50) NOT NULL , `id_category` INT(50) NOT NULL, PRIMARY KEY (`id`) ) ENGINE = InnoDB;
                            CREATE TABLE `prestashop`.`ps_compatibility_attributes_lang` ( `id_lang` INT(50) NOT NULL , `id_attribute` INT(50) NOT NULL , `name` VARCHAR(50) NOT NULL ) ENGINE = InnoDB;
ALTER TABLE ps_compatibility_categorys_lang
ADD FOREIGN KEY (id) REFERENCES ps_compatibility_categorys(id);
    ALTER TABLE ps_compatibility_attributes
    ADD FOREIGN KEY (id_category) REFERENCES ps_compatibility_categorys(id);
         ALTER TABLE ps_compatibility_product_attributes
         ADD FOREIGN KEY (id_attribute) REFERENCES ps_compatibility_attributes(id);    
             ALTER TABLE ps_compatibility_attributes_lang
             ADD FOREIGN KEY (id_lang) REFERENCES ps_compatibility_attributes(id);
                ALTER TABLE ps_product
                ADD FOREIGN KEY (id_product) REFERENCES ps_compatibility_product_attributes(id_product);' );
   return parent::install() && $this->installModuleTab();
    if (!parent::install()
        || !$this->registerHook('displayAfterProductThumbs')
        || !$this->registerHook('displayAdminProductsExtra')
        || !$this->installModuleTab()
        ) {
        return false;
    }
    
    return true;
}

public function uninstall()
{
    
//     Db::getInstance()->execute('SET FOREIGN_KEY_CHECKS=0; DROP TABLE IF EXISTS
//   			`ps_compatibility_attributes_lang`,
//                 `ps_compatibility_attributes`,
//                  `ps_compatibility_categorys` ,
//                      `ps_compatibility_categorys_lang`,
//                          `ps_compatibility_product_attributes`');
   // return $this->unstallModuleTab() && parent::unstall;
    if (!parent::uninstall()) {
        
        return false;
    }
    
    return true;
}

public function  installModuleTab ()
{
    global $smarty;
    $sql4 = 'SELECT * FROM `'._DB_PREFIX_.'compatibility_product_attributes` ';
    $sql5= Db::getInstance()->executeS($sql4);
    $smarty->assign('atributes', $sql5);
    $tab = new Tab;
    $langs = Language::getLanguage();
    $tab->name = array();
    foreach (Language::getLanguages(true) as $lang) {
        $tab->name[$lang['id_lang']] = 'prekiusuderinimas';
    }
    $tab->module = $this->name;
    $tab->active = 1;
    
    if (version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
        //AdminPreferences
        $tab->id_parent = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)
        ->getValue('SELECT MIN(id_tab)
											FROM `'._DB_PREFIX_.'tab`
											WHERE `class_name` = "'.pSQL('ShopParameters').'"'
            );
    } else {
        // AdminAdmin
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminAdmin');
    }
    
    
    $tab->class_name = 'Adminderinimas';
    return $tab->add();
   
}

public function unstallModuleTab()
{
    $id_tab = Tab::getIdFromClassName('Adminderinimas');
    if($id_tab){
        $tab = new Tab($id_tab);
        return $tab->delete();
    }
    return true;
}

public function hookDisplayAdminProductsExtra($params){
    
    $this->processProductTabContent();
    $this->assignProductTabContent($params);
    return $this->display(__FILE__, 'atvaizdas.tpl');
}

public function processProductTabContent()
{
    if (Tools::isSubmit('kategorija'))
    {
        $id_lang = Tools::getValue('id_lang');
        $id_cattegory = Tools::getValue('id_cattegory');
        $name = Tools::getValue('name');
        $insertlang = array(
            'id_lang' => (int)$id_lang,
            'id_cattegory' => (int)$id_cattegory,
            'name' => pSQL($name),
            
        );
        Db::getInstance()->insert('compatibility_categorys_lang', $insertlang);

    }
    if (Tools::isSubmit('kategorijos'))
    {
        $order = Tools::getValue('order');
        $visible = Tools::getValue('visibe');
        $insert = array(
            'order' => pSQL($order),
            'visibe' => pSQL($visible),
            
        );
        Db::getInstance()->insert('compatibility_categorys', $insert);
      
    }
     
     if (Tools::isSubmit('update'))
     {
         $id = Tools::getValue('id');
         $order = Tools::getValue('order');
         $visible = Tools::getValue('visibe');
         $update = array(
             'id' => (int)$id,
             'order' => pSQL($order),
             'visibe' => pSQL($visible),
             
         );
         Db::getInstance()->update('compatibility_categorys', $update, ' `id` = '.(int)$id);
     }
     if (Tools::isSubmit('update_lang'))
     {
         $id = Tools::getValue('id');
         $id_lang = Tools::getValue('id_lang');
         $id_cattegory = Tools::getValue('id_cattegory');
         $name = Tools::getValue('name');
         $update_lang = array(
             'id' => (int)$id,
             'id_lang' => (int)$id_lang,
             'id_cattegory' => (int)$id_cattegory,
             'name' => pSQL($name),
             
         );

         Db::getInstance()->update('compatibility_categorys_lang', $update_lang, ' `id` = '.(int)$id);
     }
      if (Tools::isSubmit('delete'))
     {
         $id = Tools::getValue('id');
         Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'compatibility_categorys`
		WHERE `id` = '.(int)$id);
     }
     if (Tools::isSubmit('delete_lang'))
     {
         $id = Tools::getValue('id');
         Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'compatibility_categorys_lang`
		WHERE `id` = '.(int)$id);
     }
     if (Tools::isSubmit('atributas'))
     {
         $id_attribute = Tools::getValue('id_attribute');
         $id_product = Tools::getValue('id_product');
         $insertattribute = array(
             'id_attribute' => (int)$id_attribute,
             'id_product' =>(int)$id_product,
         );
         Db::getInstance()->insert('compatibility_product_attributes', $insertattribute);
     }
     if (Tools::isSubmit('update_atribute'))
     {
         $id = Tools::getValue('id');
         $id_attribute = Tools::getValue('id_attribute');
         $id_product = Tools::getValue('id_product');
         $update = array(
             'id' => (int)$id,
             'id_attribute' => (int)$id_attribute,
             'id_product' => (int)$id_product,
             
         );
         Db::getInstance()->update('compatibility_product_attributes', $update, ' `id` = '.(int)$id);
     }
     if (Tools::isSubmit('delete_atribute'))
     {
         $id = Tools::getValue('id');
         Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'compatibility_product_attributes`
		WHERE `id` = '.(int)$id);
     }
     if (Tools::isSubmit('compatibility_attributes'))
     {
        
         $id_category = Tools::getValue('id_category');
         $compatibility_attributes = array(
             'id_category' => (int)$id_category,
             
         );
         Db::getInstance()->insert('compatibility_attributes', $compatibility_attributes);
     }
     if (Tools::isSubmit('update_compatibility_attributes'))
     {
         $id = Tools::getValue('id');
         
         $id_category = Tools::getValue('id_category');
         $update_compatibility_attributes = array(
             'id' => (int)$id,
             'id_attribute' => (int)$id_category,
             
             
         );
         Db::getInstance()->update('compatibility_attributes', $update_compatibility_attributes, ' `id` = '.(int)$id);
     }
     if (Tools::isSubmit('delete_compatibility_attributes'))
     {
         $id = Tools::getValue('id');
         Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'compatibility_attributes`
		WHERE `id` = '.(int)$id);
     }
}



 public function assignProductTabContent($params)
 {
     global $smarty;
     $id_product= $params['id_product'];
   
//      $idProduct = (int)(Tools::getValue('id_product'));
//      $product = new Product((int)($idProduct));
//      $product = new Product((int)Tools::getValue('id_product'));
//      $this->context->smarty->assign('idproduct', $product);
     $sql = 'SELECT * FROM `'._DB_PREFIX_.'compatibility_categorys_lang` ';
     $sql1= Db::getInstance()->executeS($sql);
     $smarty->assign('contacts', $sql1);
      global $smarty;
      $sql2 = 'SELECT * FROM `'._DB_PREFIX_.'compatibility_categorys` ';
      $sql3= Db::getInstance()->executeS($sql2);
      $smarty->assign('compatibility', $sql3);
          global $smarty;
          $sql4 = 'SELECT * FROM `ps_compatibility_product_attributes` ca LEFT JOIN ps_compatibility_attributes_lang cl ON cl.id_attribute=ca.id WHERE id_product='.$id_product;
          $sql5= Db::getInstance()->executeS($sql4);
          $smarty->assign('atributes', $sql5);
              global $smarty;
              $sql6 = 'SELECT * FROM `'._DB_PREFIX_.'compatibility_attributes` ca  LEFT JOIN ps_compatibility_attributes_lang cl ON cl.id_attribute=ca.id';
              $sql7= Db::getInstance()->executeS($sql6);
              $smarty->assign('atributes_list', $sql7);
//               global $smarty;
//               $sql8 = 'SELECT * FROM `'._DB_PREFIX_.'product` ';
//               $sql9= Db::getInstance()->executeS($sql8);
//               $smarty->assign('id_product', $sql9);
              
              //$smarty->assign('product_id',);
 }
 

 
 public function getContent($params)
 {

     $this->processProductTabContent();
     $this->assignProductTabContent($params);
     return $this->display(__FILE__, 'getContent.tpl');
}
public function hookdisplayAfterProductThumbs($params)
{
   // $this->getCover($id_product);
  //  $this->getAttributeCombinations($id_lang);
    $this->assignProductTabContent($params);
    return $this->display(__FILE__, 'combinations.tpl');
}
// public function getAttributeCombinations()
// {
// global $smarty;
// $sql4 = 'SELECT * FROM `ps_compatibility_product_attributes` ca LEFT JOIN ps_compatibility_attributes_lang cl ON cl.id_attribute=ca.id WHERE id_product='.$id_product;
// $sql5= Db::getInstance()->executeS($sql4);
// $smarty->assign('atributes', $sql5);
// $result = $this->getCover($this->id);
// return $result['id_image'];
// }
}