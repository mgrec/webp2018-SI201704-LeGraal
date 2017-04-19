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
        $connect = false;
        
        if (isset($_SESSION['user_admin']) && $_SESSION['user_admin'] != null){
            $connect = true;  
        }else{
            session_unset();
            session_destroy();
            $connect = false;
        }
        
        return$connect;
    }


    public function logInAdmin($pdo){
        $repo = new adminRepository();
        return $repo->getAction($pdo);
    }

    public function logOutAdmin(){
        session_start();
        unset($_SESSION['user_admin']);
        session_unset();
        session_destroy();
        return true;
    }

}