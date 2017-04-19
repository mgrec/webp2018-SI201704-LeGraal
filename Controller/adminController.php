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

    public function logInAdmin(array $array){
        session_start();
        $_SESSION['user_admin'] = $array['email'];
        return true;
    }

    public function logOutAdmin(){
        session_start();
        unset($_SESSION['user_admin']);
        session_unset();
        session_destroy();
        return true;
    }


}