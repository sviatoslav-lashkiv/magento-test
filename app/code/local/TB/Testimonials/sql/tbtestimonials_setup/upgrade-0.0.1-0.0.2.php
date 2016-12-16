<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$installer->getConnection()->addForeignKey(
    $installer->getFkName('tbtestimonials/table_testimonials', 'customer_id', 'customer/entity', 'entity_id'),
    $installer->getTable('tbtestimonials/table_testimonials'),
    'customer_id',
    $installer->getTable('customer/entity'),
    'entity_id');

$installer->endSetup();