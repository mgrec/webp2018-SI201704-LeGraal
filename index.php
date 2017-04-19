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


$app->get('/adminRepository', function($request, $response, $arg) {
    $bindVar = [];

    return $this->view->render($response, 'adminRepository/page/connexion.twig',  $bindVar);
})->setName('adminConnection');

$app->get('/connect', function(Request $request, $response, $args) {
    $adminController = new adminController();
    $pdo = $this->db;

    $content = $adminController->logInAdmin($pdo);

    var_dump($content);
});

$app->run();