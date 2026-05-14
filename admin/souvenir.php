<?php
$crudConfig = [
    'table' => 'souvenirs',
    'singular' => 'Souvenir',
    'plural' => 'Souvenirs',
    'order' => 'year DESC',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'required' => true],
        ['name' => 'year', 'label' => 'Year', 'type' => 'number', 'required' => true],
        ['name' => 'category', 'label' => 'Category', 'type' => 'select', 'options' => ['Convocation', 'Alumni']],
        ['name' => 'pdf_link', 'label' => 'PDF File', 'type' => 'file', 'allowed' => ['pdf']],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
    ],
    'columns' => [
        ['key' => 'title', 'label' => 'Title'],
        ['key' => 'year', 'label' => 'Year'],
        ['key' => 'category', 'label' => 'Category'],
        ['key' => 'pdf_link', 'label' => 'PDF'],
    ],
];
require __DIR__ . '/includes/crud_page.php';
