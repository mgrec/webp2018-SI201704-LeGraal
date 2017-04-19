<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 19/04/2017
 * Time: 09:43
 */

namespace Controller;


class adminController
{

    public function isAdminConnect(){
        session_start();
        if (isset($_SESSION['user']) && $_SESSION['user'] != null){

        }else{
            session_unset();
            session_destroy();
        }
    }

    public function logInAdmin(){

    }

    public function logOutAdmin(){

    }
}