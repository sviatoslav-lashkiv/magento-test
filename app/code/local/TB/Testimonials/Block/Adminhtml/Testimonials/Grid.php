<?php

class TB_Testimonials_Block_Adminhtml_Testimonials_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('tbtestimonials/testimonials')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('tbtestimonials');

        $this->addColumn('testimonial_id', array(
            'header' => $helper->__('Testimonials ID'),
            'index' => 'testimonial_id'
        ));

        $this->addColumn('customer_id', array(
            'header' => $helper->__('Customer ID'),
            'index' => 'customer_id',
        ));
		
		$this->addColumn('content', array(
            'header' => $helper->__('Content'),
            'index' => 'content',
            'type' => 'text',
        ));

        $this->addColumn('created', array(
            'header' => $helper->__('Created'),
            'index' => 'created',
            'type' => 'date',
        ));

        $this->addColumn('status', array(
            'header' => $helper->__('Visibility'),
            'index' => 'status'
        ));

        return parent::_prepareColumns();
    }
	
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('testimonial_id');
        $this->getMassactionBlock()->setFormFieldName('testimonials');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
    }

    public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', array(
                    'id' => $model->getId(),
                ));
    }	
	

}