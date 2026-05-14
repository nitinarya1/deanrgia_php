<?php
$crudConfig = [
    'table' => 'publications',
    'singular' => 'Publication',
    'plural' => 'Publications',
    'order' => 'id DESC',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'required' => true],
        ['name' => 'author', 'label' => 'Author', 'required' => true],
        ['name' => 'image', 'label' => 'Cover Image', 'type' => 'file', 'allowed' => ['jpg', 'jpeg', 'png', 'gif', 'webp']],
        ['name' => 'link', 'label' => 'Book Link (optional)'],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
    ],
    'columns' => [
        ['key' => 'image', 'label' => 'Cover', 'type' => 'image'],
        ['key' => 'title', 'label' => 'Title'],
        ['key' => 'author', 'label' => 'Author'],
    ],
];
require __DIR__ . '/includes/crud_page.php';
