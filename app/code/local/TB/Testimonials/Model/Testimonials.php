<?php

class TB_Testimonials_Model_Testimonials extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('tbtestimonials/testimonials');
    }

}