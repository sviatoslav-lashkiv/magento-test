<?php

$installer = $this;
$tableTestimonials = $installer->getTable('tbtestimonials/table_testimonials');

//die($tableTestimonials);

$installer->startSetup();

$installer->getConnection()->dropTable($tableTestimonials);

$table = $installer->getConnection()
    ->newTable($tableTestimonials)
    ->addColumn('testimonial_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ))
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ))
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
    ))
    ->addColumn('created', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ));
$installer->getConnection()->createTable($table);

$installer->endSetup();
