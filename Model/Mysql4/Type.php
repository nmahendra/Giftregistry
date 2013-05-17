<?php

class Zygnis_Giftregistry_Model_Mysql4_Type extends Mage_Core_Model_Mysql4_Abstract{
    
    public function _construct() {
        $this->_init('zygnis_giftregistry/type', 'type_id');
    }
}