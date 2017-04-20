<?php
/**
 * Created by PhpStorm.
 * User: azerty
 * Date: 20/04/2017
 * Time: 09:50
 */

namespace Controller;


use Model\espClientRepository;

class espClientController
{
    public function isConnected()
    {
        session_start();
        $connect = false;

        if (isset($_SESSION['user']) && $_SESSION['user'] != null) {
            $connect = true;
        } else {
            session_unset();
            session_destroy();
            $connect = false;
        }

        return $connect;
    }

    public function logIn($array, $pdo)
    {
        $repo = new espClientRepository();
        $connected = $repo->connectionAction($array, $pdo);

        if ($connected['code'] == true) {
            session_start();
            $_SESSION['user'] = $connected['email'];
            $_SESSION['userClient_id'] = $connected['id'];

            return true;
        } else {
            session_unset();
            session_destroy();

            return false;
        }
    }

    public function logOut()
    {
        session_start();
        unset($_SESSION['user']);
        session_unset();
        session_destroy();
        return true;
    }
}