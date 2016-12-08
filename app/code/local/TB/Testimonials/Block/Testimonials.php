<?php

class TB_Testimonials_Block_Testimonials extends Mage_Core_Block_Template
{

    public function getTestimonialsCollection()
    {
        $testimonialsCollection = Mage::getModel('tbtestimonials/testimonials')->getCollection();
        $testimonialsCollection->setOrder('created', 'DESC');
        return $testimonialsCollection;
    }

    /*public function _prepareLayout()
        {
                return parent::_prepareLayout();
        }	*/

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
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