<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 16/12/2016
 * Time: 13:52
 */

namespace Controller;


class indexController
{
    public function render($name){
        echo "Hello " . $name;
    }

    public function ContactTratement($msgReq, $corps){
        if ($msgReq < 3){

        }else{
            
        }
    }

    public function isConnect(){
        session_start();
        if (isset($_SESSION['user']) && $_SESSION['user'] != null){

        }else{

        }
    }

    public function logIn(){

    }

    public function logOut(){

    }

    
}