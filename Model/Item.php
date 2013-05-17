<?php

class Zygnis_Giftregistry_Model_Item extends Mage_Core_Model_Abstract{
    
    public function __construct() {
        $this->_init('zygnis_giftregistry/item');
        parent::__construct();
    }
}