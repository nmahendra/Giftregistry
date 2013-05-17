<?php

class Zygnis_Giftregistry_IndexController extends Mage_Core_Controller_Front_Action{

    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->getResponse()->setRedirect(Mage::helper('customer')->getLoginUrl());
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }

    public function indexAction(){
        $this->loadLayout();
        var_dump(Mage::getSingleton('core/layout')->getUpdate()->getHandles());
        $this->renderLayout();
        return $this;
    }
    
    public function deleteAction(){
        try {
            $registryId = $this->getRequest()->getParam('registry_id');
            if ($registryId && $this->getRequest()->getRequestString()) {
                Mage::log('Deleted');
                if($registry = Mage::getModel('zygnis_giftregistry/entity')->load($registryId)) {
                    $registry->delete();
                    $successMessage = Mage::helper('zygnis_giftregistry')->__('Gift registry has been succesfully deleted.');
                    Mage::getSingleton('core/session')->addSuccess($successMessage);
                } else {
                    throw new Exception("There was a problem deleting the registry");
                }
            }
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }
    
    public function newAction(){
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }

    public function editAction(){
        $registryId = $this->getRequest()->getParam('registry_id');
        echo $registryId;
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }
    
    public function newPostAction(){
        try {
            $data = $this->getRequest()->getParams();
            $registry = Mage::getModel('zygnis_giftregistry/entity');
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            
            if($this->getRequest()->getPost() && !empty($data)){
                $registry->updateRegistryData($customer,$data);
                $registry->save();
                
                $successMessage = Mage::helper('zygnis_giftregistry')->__('Registry Successfully Created');
                Mage::getSingleton('core/session')->addSuccess($successMessage);
            }else{
                throw new Exception("Insufficient Data Provided.");
            }
            
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
        $this->_redirect('*/*/');
    }

    public function editPostAction() {
        try {
            $data = $this->getRequest()->getParams();
            
            $registry = Mage::getModel('zygnis_giftregistry/entity');
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            
            if ($this->getRequest()->getPosts() && !empty($data)) {
                $registry->load($data['registry_id']);
                
                if ($registry) {
                    $registry->updateRegistryData($customer, $data);
                    $registry->save();
                    $successMessage = Mage::helper('zygnis_giftregistry')->__('Registry Successfully Saved');
                    Mage::getSingleton('core/session')->addSuccess($successMessage);
                } else {
                    throw new Exception("Invalid Registry Specified");
                }
            } else {
                throw new Exception("Insufficient Data provided");
            }
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
        $this->_redirect('*/*/');
    }

}