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


    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,20=>20,'all'=>'all'));
        $pager->setCollection($this->getTestimonialsCollection());
        $this->setChild('pager', $pager);
        $this->getTestimonialsCollection()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
	
}