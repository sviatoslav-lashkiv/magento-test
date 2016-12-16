<?php

class TB_Testimonials_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
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
                    __( 'Add testimonials can only registered users. <a href="%s">Please Login or Register</a>', $loginLink)
            );
            return;
        }

    }

    public function postAction()
    {
        $this->_initLayoutMessages('core/session');
        $data = $this->getRequest()->getPost();

        if (!$data['content']) {
            Mage::getSingleton('core/session')->addError(
                Mage::helper('tbtestimonials')->__('Please, fill all required fields.')
            );
            $this->_redirectReferer();
            return;
        }

        if ($data) {
            try {
                $model = Mage::getModel('tbtestimonials/testimonials');
                $model->setStorelId(Mage::app()->getStore()->getStoreId());
                $model->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());
                $model->setCreated(now());
                $model->setContent($data['content']);
                $model->save();
                Mage::getSingleton('core/session')->addSuccess($this->__('Testimonial was saved successfully'));
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError($e->getMessage());
                Mage::getSingleton('core/session')->setFormData($data);
                $this->_redirectReferer();
                return;
            }
        }
        $this->_redirect('*/*/');
    }

}