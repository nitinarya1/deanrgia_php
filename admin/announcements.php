<?php
$crudConfig = [
    'table' => 'announcements',
    'singular' => 'Announcement',
    'plural' => 'Announcements',
    'order' => 'date DESC',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'required' => true],
        ['name' => 'date', 'label' => 'Date', 'type' => 'date', 'required' => true],
        ['name' => 'link', 'label' => 'Link (optional)'],
        ['name' => 'is_new', 'label' => 'Mark as New', 'type' => 'select', 'options' => ['1', '0']],
        ['name' => 'is_active', 'label' => 'Active', 'type' => 'select', 'options' => ['1', '0']],
        ['name' => 'content', 'label' => 'Content', 'type' => 'textarea'],
    ],
    'columns' => [
        ['key' => 'title', 'label' => 'Title'],
        ['key' => 'date', 'label' => 'Date'],
        ['key' => 'is_new', 'label' => 'New'],
        ['key' => 'is_active', 'label' => 'Active'],
    ],
];
require __DIR__ . '/includes/crud_page.php';
