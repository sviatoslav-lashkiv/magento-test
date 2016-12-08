<?php

class TB_Testimonials_Block_Adminhtml_Testimonials extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    protected function _construct()
    {
        parent::_construct();

        $helper = Mage::helper('tbtestimonials');
        $this->_blockGroup = 'tbtestimonials';
        $this->_controller = 'adminhtml_testimonials';

        $this->_headerText = $helper->__('Testimonials Management');
        $this->_addButtonLabel = $helper->__('Add Testimonials');
    }

}