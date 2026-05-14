<?php
$crudConfig = [
    'table' => 'deans',
    'singular' => 'Dean',
    'plural' => 'Deans',
    'order' => 'display_order ASC',
    'fields' => [
        ['name' => 'name', 'label' => 'Name', 'required' => true],
        ['name' => 'designation', 'label' => 'Designation', 'default' => 'Dean (R G & IA)'],
        ['name' => 'department', 'label' => 'Department'],
        ['name' => 'tenure', 'label' => 'Tenure', 'required' => true],
        ['name' => 'image', 'label' => 'Photo', 'type' => 'file', 'allowed' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']],
        ['name' => 'email', 'label' => 'Email'],
        ['name' => 'profile_link', 'label' => 'Profile Link'],
        ['name' => 'display_order', 'label' => 'Display Order', 'type' => 'number', 'default' => '0'],
        ['name' => 'bio', 'label' => 'Bio', 'type' => 'textarea'],
    ],
    'columns' => [
        ['key' => 'image', 'label' => 'Photo', 'type' => 'image'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'designation', 'label' => 'Designation'],
        ['key' => 'tenure', 'label' => 'Tenure'],
        ['key' => 'display_order', 'label' => 'Order'],
    ],
];
require __DIR__ . '/includes/crud_page.php';
