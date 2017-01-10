<?php

class TB_Testimonials_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getCustomersCollection()
    {
        $collection = Mage::getModel('customer/customer')->getCollection()
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('middlename')
            ->addAttributeToSelect('lastname');
        $output = array();
        foreach ($collection as $customer) {
            $output[] = [
                'label' => $customer->getName(),
                'value' => $customer->getId()
            ];
        }
        return $output;
    }

    public function selectVisibilityStatus()
    {
        return
            [
                ['label' => 'Hidden', 'value' => 0],
                ['label' => 'Visible', 'value' => 1]
            ];
    }

}