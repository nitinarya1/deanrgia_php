<?php
$crudConfig = [
    'table' => 'slideshows',
    'singular' => 'Slide',
    'plural' => 'Slides',
    'order' => 'display_order ASC',
    'fields' => [
        ['name' => 'image_url', 'label' => 'Slide Image', 'type' => 'file', 'required' => true, 'allowed' => ['jpg', 'jpeg', 'png', 'gif', 'webp'], 'auto_compress' => true],
        ['name' => 'caption', 'label' => 'Caption'],
        ['name' => 'display_order', 'label' => 'Display Order', 'type' => 'number', 'default' => '0'],
        ['name' => 'is_active', 'label' => 'Active', 'type' => 'select', 'options' => ['1', '0']],
    ],
    'columns' => [
        ['key' => 'image_url', 'label' => 'Image', 'type' => 'image'],
        ['key' => 'caption', 'label' => 'Caption'],
        ['key' => 'display_order', 'label' => 'Order'],
        ['key' => 'is_active', 'label' => 'Active'],
    ],
];
require __DIR__ . '/includes/crud_page.php';
