<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn(
    $installer->getTable('tbtestimonials/table_testimonials'),
    'status',
    'tinyint(1) UNSIGNED NOT NULL DEFAULT 0'
);

$installer->endSetup();