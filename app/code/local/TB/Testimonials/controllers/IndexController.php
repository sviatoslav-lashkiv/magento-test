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
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('tbtestimonials/testimonials');
                $model->setData($data)->setId($this->getRequest()->getParam('id'));
                if(!$model->getCreated()){
                    $model->setCreated(now());
                }
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Testimonials was saved successfully'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getParam('id')
                ));
            }
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
        $this->_redirect('*/*/');
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


}