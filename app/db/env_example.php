<?php

define('URLROOT', 'http://localhost/canecart');

if (!defined('DATABASE_INFO') || !defined('DATABASE_INFO')) {
    DEFINE('DATABASE_INFO', [
        'dsn' => 'pgsql:host=localhost;port=5432;dbname=e_commerce',
        'user' => 'postgres',
        'password' => 'password'
    ]);

    DEFINE('PHPMAILER_INFO', [
        'smtp_host' => 'smtp.gmail.com',
        'mail_user' => 'exameple@gmail.com',
        'password_user' => 'password',
        'mail_port' => 465
    ]);
}
