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
use Controller\contactController;
use Controller\espClientController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function ($request, $response, $args) {
    $bindVar = [];

    return $this->view->render($response, 'home.twig', $bindVar);
})->setName('profile');

//groupe routes : admin
$app->group('/admin/', function () {

    $this->get('', function($request, $response, $arg){
        return $response->withRedirect('connexion', 401);
    });

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
            $admin_name = $adminController->getAdminName($pdo, $bindVar['user_admin']);
            $bindVar['user_admin_name'] = $admin_name['name'];
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

        $isConnect = $adminController->isAdminConnect();

        if (isset($_POST['email']) && isset($_POST['password'])){
            $array = $_POST;
            if ($_POST['password'] == $_POST['password_confirm']){
                $updateAdmin = $adminController->updateAdmin($array, $pdo);
                $bindVar['border-color'] = '';
                $bindVar['code'] = true;
            }else{
                $bindVar['code'] = false;
                $bindVar['border-color'] = 'border-color: red';
            }

        }

        $adminInfos = $adminController->getAdminInformations($pdo);
        $bindVar['admin_infos'] = $adminInfos;

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

        $isConnect = $adminController->isAdminConnect();

        if (isset($_POST['email'])){
            $array = $_POST;
            $userAdd = $adminController->addUser($array, $pdo);
            $bindVar['code'] = $userAdd['code'];
        }

        $users = $adminController->getAllUsers($pdo);
        $bindVar['users_list'] = $users;
        
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
        
        $facture = $adminController->getFacture($id_user, $pdo);
        $bindVar['user_facture'] = $facture;

        $plan = $adminController->getPlan($id_user, $pdo);
        $bindVar['user_plan'] = $plan;
        
        if ($isConnect == true) {
            $bindVar['connected'] = true;
            return $this->view->render($response, 'admin/page/single-user.twig', $bindVar);
        } else {
            return $response->withRedirect('connexion', 301);
        }

    });

});

$app->post( '/upload', function ($request, $response, $arg) {
    $bindVar = [];
    $pdo = $this->db;
    $adminController = new adminController();
    $data = $_POST;
    $dataImg = $_FILES;
    $adminController->addFile($data, $dataImg, $pdo);
    return $response->withRedirect('admin/user/' . $data['id'], 200);

});


$app->post('/contact', function(Request $request) {
    $pdo = $this->db;
    $contactController = new contactController();
    $data = $request->getParams();

    $contactController->contactTreatment($pdo, $data);
});

$app->group('/espClient/', function() {

    $this->map(['GET', 'POST'], 'login-page', function($request, $response, $args) {
        return $this->view->render($response, 'espClient/page/connexion.twig');
    });

    $this->map(['GET', 'POST'], 'connexion', function($request, $response, $args) {
        $bindVar = [];
        $espClientController = new espClientController();
        $pdo = $this->db;

        $isConnect = $espClientController->isConnected();

        if ($isConnect == true) {
            return $response->withRedirect('home', 200);
        }

        if (isset($_POST['email']) && isset($_POST['password'])){
            $array = $_POST;
            $connected = $espClientController->logIn($array, $pdo);
        }

        if (isset($connected) && $connected == true){
            return $response->withRedirect('home', 200);
        } else {
            return $response->withRedirect('login-page', 401);
        }
    });

    $this->map(['GET', 'POST'], 'home', function($request, $response, $arg) {
        session_start();
        $bindVar = [];
        $pdo = $this->db;
        $espClientController = new espClientController();
        $adminController = new adminController();

        $id = $adminController->getId($_SESSION['user'], $pdo);
        $id = intval($id['id']);

        $facture = $adminController->getFacture($id, $pdo);
        $plan = $adminController->getPlan($id, $pdo);


        if (isset($_SESSION['user'])){
            $bindVar['user'] = $_SESSION['user'];
        }

        $isConnect = $espClientController->isConnected();

        if ($isConnect == true) {
            $bindVar['connected'] = true;
            $bindVar['user'] = $_SESSION['user'];
            $bindVar['factures'] = $facture;
            $bindVar['plans'] = $plan;
//            var_dump($bindVar['plans']);
//            die();
            return $this->view->render($response, 'espClient/page/home.twig', $bindVar);
        } else {
            return $response->withRedirect('login-page', 301);
        }
    });

    $this->map(['GET', 'POST'], 'deconnexion', function ($request, $response, $arg) {
        $espClientController = new espClientController();
        $espClientController->logOut();

        return $response->withRedirect('login-page', 200);
    });
});

$app->run();