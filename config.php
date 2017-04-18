<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 16/12/2016
 * Time: 13:44
 */

// Create and configure Slim app
$config = [
    'settings' => [
        'addContentLengthHeader' => false,

        'db' => [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => 'root',
            'dbname' => 'leGraal'
        ]
]];

$app = new \Slim\App($config);

global $app;