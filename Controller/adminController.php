<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 19/04/2017
 * Time: 09:43
 */

namespace Controller;

use Model\adminRepository;

class adminController
{

    public function isAdminConnect(){
        session_start();
        if (isset($_SESSION['user_admin']) && $_SESSION['user_admin'] != null){

        }else{
            session_unset();
            session_destroy();
        }
    }

    public function logInAdmin($pdo){
        $repo = new adminRepository();
        return $repo->getAction($pdo);
    }

    public function logOutAdmin(){

    }

}