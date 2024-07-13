<?php

$config = [
    'dashboard' => array('read'),
    'users_accounts' => array('create', 'read', 'update'),
    'about_us' => array('read', 'update'),
    'privacy_policy' => array('read', 'update'),
    'terms_condition' => array('read', 'update'),
    'customer' => array('create', 'read', 'update', 'delete'),
    'slider' => array('create', 'read', 'update', 'delete'),
    'categories' => array('create', 'read', 'update', 'delete'),
    'type' => array('create', 'read', 'update', 'delete'),
    'property' => array('create', 'read', 'update', 'delete'),
    'property_enquiry' => array('read', 'update', 'delete'),
    'notification' => array('read', 'update', 'delete'),
];
return $config;
