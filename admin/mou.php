<?php
$crudConfig = [
    'table' => 'mous',
    'singular' => 'MoU',
    'plural' => 'MoUs',
    'order' => 'date DESC',
    'fields' => [
        ['name' => 'institution', 'label' => 'Institution', 'required' => true],
        ['name' => 'country', 'label' => 'Country', 'required' => true],
        ['name' => 'date', 'label' => 'Date', 'type' => 'date', 'required' => true],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['Active', 'Inactive', 'Expired']],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
    ],
    'columns' => [
        ['key' => 'institution', 'label' => 'Institution'],
        ['key' => 'country', 'label' => 'Country'],
        ['key' => 'date', 'label' => 'Date'],
        ['key' => 'status', 'label' => 'Status'],
    ],
];
require __DIR__ . '/includes/crud_page.php';
