<?php

class Zygnis_Giftregistry_Model_Entity extends Mage_Core_Model_Abstract{
    
    public function _construct() {
        $this->_init('zygnis_giftregistry/entity');
        parent::_construct();
    }
    
    public function updateRegistryData(Mage_Customer_Model_Customer $customer, $data){
        try {
            if(!empty($data)){
                $this->setCustomerId($customer->getId());
                $this->setWebsiteId($customer->getWebsiteId());
                $this->setTypeId($data['type_id']);
                $this->setEventName($data['event_name']);
                $this->setEventDate($data['event_date']);
                $this->setEventCountry($data['event_country']);
                $this->setEventLocation($data['event_location']);
            }
        }  catch (Exception $e){
            Mage::logException($e);
        }
        Mage::log($data);
        return $this;
    }
}