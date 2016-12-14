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
        $this->_initLayoutMessages('core/session');
        $data = $this->getRequest()->getPost();

        if (!($data['user_name'] && $data['content'])) {
            Mage::getSingleton('core/session')->addError(
                Mage::helper('tbtestimonials')->__('Please, fill all required fields.')
            );
            $this->_redirectReferer();
            return;
        }

        if ($data) {
            try {
                $model = Mage::getModel('tbtestimonials/testimonials');
                $model->setStoreId(Mage::app()->getStore()->getStoreId());
                $model->setUserName($data['user_name']);
                $model->setEmail($data['email']);
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