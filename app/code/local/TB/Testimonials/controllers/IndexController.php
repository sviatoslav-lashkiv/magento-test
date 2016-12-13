<?php

class TB_Testimonials_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction()
    {
        $testimonialId = Mage::app()->getRequest()->getParam('id', 0);
        $testimonials = Mage::getModel('tbtestimonials/testimonials')->load($testimonialId);

        if ($testimonials->getId() > 0) {
            $this->loadLayout();
            $this->getLayout()->getBlock('testimonials.content')->assign(array(
                "testimonialsItem" => $testimonials,
            ));
            $this->renderLayout();
        } else {
            $this->_forward('noRoute');
        }
    }

    public function newAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        //$layoutHandles = $this->getLayout()->getUpdate()->getHandles();
        //echo '<pre>' . print_r($layoutHandles, true) . '</pre>';
    }

    public function postAction()
    {
        $this->_initLayoutMessages('customer/session');

        if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('tbtestimonials/testimonials');
                $model->setStoreId(Mage::app()->getStore()->getStoreId());
                $model->setUserName($data['user_name']);
                $model->setEmail($data['email']);
                $model->setCreated(now());
                $model->setContent($data['content']);
                $model->save();
                Mage::getSingleton('customer/session')->addSuccess($this->__('Testimonials was saved successfully'));
            } catch (Exception $e) {
                Mage::getSingleton('customer/session')->addError($e->getMessage());
                Mage::getSingleton('customer/session')->setFormData($data);
                $this->_redirectReferer();
                return;
            }
        }
        $this->_redirect('*/*/');
    }

}