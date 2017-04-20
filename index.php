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


$app->post('/contact', function (Request $request) {

    $indexController = new indexController();

    $req = $request->getParams();
    $msgReq = $req['nbrMessage'];
    $corps = $req['corps'];
    $indexController->ContactTratement($msgReq, $corps);
});

//groupe routes : admin
$app->group('/admin/', function () {
    //home admin
    $this->get('home', function ($request, $response, $arg) {
        session_start();
        $bindVar = [];
        $adminController = new adminController();
        $pdo = $this->db;

        $users = $adminController->getAllUsers($pdo);
        $usersCount = sizeof($users);
        $bindVar['users_count'] = (int)$usersCount;

        if (isset($_SESSION['user_admin'])){
            $bindVar['user_admin'] = $_SESSION['user_admin'];
        }

        $isConnect = $adminController->isAdminConnect();

        if ($isConnect == true) {
            $bindVar['connected'] = true;
            return $this->view->render($response, 'admin/page/home.twig', $bindVar);
        } else {
            return $response->withRedirect('connexion', 401);
        }
    })->setName('adminHome');

    //connexion admin
    $this->map(['GET', 'POST'], 'connexion', function ($request, $response, $arg) {
        $bindVar = [];
        $adminController = new adminController();
        $pdo = $this->db;

        $isConnect = $adminController->isAdminConnect();

        if ($isConnect == true) {
            return $response->withRedirect('home', 200);
        }

        if (isset($_POST['email']) && isset($_POST['password'])){
           $array = $_POST;
           $connected = $adminController->logInAdmin($array, $pdo);
        }

        if (isset($connected) && $connected == true){
            return $response->withRedirect('home', 200);
        }

        return $this->view->render($response, 'admin/page/connexion.twig', $bindVar);
    })->setName('adminConnexion');

    $this->map(['GET', 'POST'], 'deconnexion', function ($request, $response, $arg) {
        $adminController = new adminController();
        $adminController->logOutAdmin();

        return $response->withRedirect('connexion', 200);
    });

    $this->map(['GET', 'POST'], 'contenu', function ($request, $response, $arg) {
        $bindVar = [];
        $adminController = new adminController();
        $pdo = $this->db;

        $isConnect = $adminController->isAdminConnect();

        if ($isConnect == true) {
            $bindVar['connected'] = true;
            return $this->view->render($response, 'admin/page/contenu.twig', $bindVar);
        } else {
            return $response->withRedirect('connexion', 301);
        }
    });

    $this->map(['GET', 'POST'], 'settings', function ($request, $response, $arg) {
        $bindVar = [];
        $adminController = new adminController();
        $pdo = $this->db;

        $adminInfos = $adminController->getAdminInformations($pdo);
        $bindVar['admin_infos'] = $adminInfos;

        $isConnect = $adminController->isAdminConnect();

        if ($isConnect == true) {
            $bindVar['connected'] = true;
            return $this->view->render($response, 'admin/page/settings.twig', $bindVar);
        } else {
            return $response->withRedirect('connexion', 301);
        }
    });

    $this->map(['GET', 'POST'], 'users', function ($request, $response, $arg) {
        $bindVar = [];
        $adminController = new adminController();
        $pdo = $this->db;

        $users = $adminController->getAllUsers($pdo);
        $bindVar['users_list'] = $users;
        $isConnect = $adminController->isAdminConnect();

        if (isset($_POST['email'])){
            $array = $_POST;
            $userAdd = $adminController->addUser($array, $pdo);
            $bindVar['code'] = $userAdd['code'];
        }

        if ($isConnect == true) {
            $bindVar['connected'] = true;
            return $this->view->render($response, 'admin/page/users.twig', $bindVar);
        } else {
            return $response->withRedirect('connexion', 301);
        }
    });

    $this->map(['GET', 'POST'], 'user/{id}', function ($request, $response, $arg) {
        $bindVar = [];
        $adminController = new adminController();
        $pdo = $this->db;
        $isConnect = $adminController->isAdminConnect();
        $id_user = $arg['id'];

        
        $user = $adminController->getUser($id_user, $pdo);
        $bindVar['user_infos'] = $user;
        
        if ($isConnect == true) {
            $bindVar['connected'] = true;
            return $this->view->render($response, 'admin/page/single-user.twig', $bindVar);
        } else {
            return $response->withRedirect('connexion', 301);
        }

    });

});

$app->run();