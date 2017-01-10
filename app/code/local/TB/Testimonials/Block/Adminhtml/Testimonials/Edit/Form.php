<?php

class TB_Testimonials_Block_Adminhtml_Testimonials_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $helper = Mage::helper('tbtestimonials');
        $model = Mage::registry('current_testimonials');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array(
                'id' => $this->getRequest()->getParam('id')
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $this->setForm($form);

        $fieldset = $form->addFieldset('testimonials_form', array('legend' => $helper->__('Testimonials Information')));

        $fieldset->addField('customer_id', 'select', array(
            'label' => $helper->__('Customer Name'),
            'title' => $helper->__('Select Customer'),
            'required' => true,
            'name' => $helper->__('customer_id'),
            'values' => $helper->getCustomersCollection()
        ));

        $fieldset->addField('content', 'editor', array(
            'label' => $helper->__('Content'),
            'required' => true,
            'name' => 'content',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => $helper->__('Visibility'),
            'title' => $helper->__('Please Select'),
            'name' => $helper->__('status'),
            'required' => true,
            'values' => $helper->selectVisibilityStatus (),
        ));

        $fieldset->addField('created', 'date', array(
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'label' => $helper->__('Created'),
            'name' => 'created',
            'value' => $helper->__('TEXTTEXT'),
        ));

        $form->setUseContainer(true);

        if ($data = Mage::getSingleton('adminhtml/session')->getFormData()) {
            $form->setValues($data);
        } else {
            $form->setValues($model->getData());
        }

        return parent::_prepareForm();
    }

}