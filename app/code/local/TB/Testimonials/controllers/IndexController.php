<?php

class TB_Testimonials_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();
        if (!$isLoggedIn) {
            $loginLink = Mage::helper('customer')->getLoginUrl();
            Mage::getSingleton('core/session')->addError(
                Mage::helper('tbtestimonials')->
                __('Add testimonials can only registered users. <a href="%s">Please Login or Register</a>', $loginLink)
            );
        }

        $this->loadLayout();
        $this->renderLayout();
    }


    public function newAction()
    {
        $isLoggedIn = Mage::getSingleton('customer/session')->isLoggedIn();

        if ($isLoggedIn) {
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->_redirect('*/*/');
            $loginLink = Mage::helper('customer')->getLoginUrl();
            Mage::getSingleton('core/session')->addError(
                Mage::helper('tbtestimonials')->
                __('Add testimonials can only registered users. <a href="%s">Please Login or Register</a>', $loginLink)
            );
            return;
        }

    }


    public function postAction()
    {
        $this->_initLayoutMessages('core/session');
        $data = $this->getRequest()->getPost();

        $result = array();

        if (!$data['content']) {
            $result['success'] = false;
            $result['messages'] = $this->__('Please, fill required field.');
        } else {
            try {
                $model = Mage::getModel('tbtestimonials/testimonials');
                $model->setStorelId(Mage::app()->getStore()->getStoreId());
                $model->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());
                $model->setCreated(now());
                $model->setContent($data['content']);
                $model->save();
                $result['success'] = true;
                $result['messages'] = $this->__('Testimonial was saved successfully. It will be added after moderation.');
            } catch (Exception $e) {
                $result['success'] = false;
                $result['messages'] = $this->__($e->getMessage());
            }
        }
        return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

}