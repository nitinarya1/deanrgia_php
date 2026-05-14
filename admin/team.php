<?php
$crudConfig = [
    'table' => 'team',
    'singular' => 'Team Member',
    'plural' => 'Team Members',
    'order' => 'id ASC',
    'fields' => [
        ['name' => 'name', 'label' => 'Name', 'required' => true],
        ['name' => 'role', 'label' => 'Role', 'required' => true],
        ['name' => 'department', 'label' => 'Department'],
        ['name' => 'image', 'label' => 'Photo', 'type' => 'file', 'allowed' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']],
        ['name' => 'profile_link', 'label' => 'Profile Link'],
    ],
    'columns' => [
        ['key' => 'image', 'label' => 'Photo', 'type' => 'image'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'role', 'label' => 'Role'],
        ['key' => 'department', 'label' => 'Department'],
    ],
];
require __DIR__ . '/includes/crud_page.php';
