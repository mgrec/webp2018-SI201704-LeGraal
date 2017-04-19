<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 16/12/2016
 * Time: 13:44
 */
require 'vendor/autoload.php';
require_once "config.php";
use Controller\indexController;
use Controller\adminController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->get('/', function ($request, $response, $args) {
    $bindVar = [];

    return $this->view->render($response, 'home.twig', $bindVar);
})->setName('profile');


$app->post('/contact/', function(Request $request){
    $indexController = new indexController();
    $req = $request->getParams();
    $msgReq = $req['nbrMessage'];
    $corps = $req['corps'];
    $indexController->ContactTratement($msgReq, $corps);
});

$app->get('/admin', function($request, $response, $arg) {
    return $this->view->render($response, 'admin/connection.twig');
})->setName('adminConnection');

$app->get('/connect', function(Request $request, $response, $args) {
    $dbhandler = $this->db;
    $queryUsers = $dbhandler->prepare("SELECT * FROM user");
    $queryUsers->execute();
    $users = $queryUsers->fetchAll();
    var_dump($users);
    die();

});

$app->run();