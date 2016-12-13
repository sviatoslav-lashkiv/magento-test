<?php

class TB_Testimonials_Block_Testimonials extends Mage_Core_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        $testimonialsCollection = Mage::getModel('tbtestimonials/testimonials')->getCollection();
        $testimonialsCollection->setOrder('created', 'DESC');
        $this->setTestimonialsCollection($testimonialsCollection);
        return $this;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'testimonialsPager');
        $pager->setAvailableLimit(array(5 => 5, 10 => 10, 20 => 20, 'all' => 'all'));
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