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

    public function isAdminConnect()
    {
        session_start();
        $connect = false;

        if (isset($_SESSION['user_admin']) && $_SESSION['user_admin'] != null) {
            $connect = true;
        } else {
            session_unset();
            session_destroy();
            $connect = false;
        }

        return $connect;
    }


    public function logInAdmin($array, $pdo)
    {
        $repo = new adminRepository();
        $connected = $repo->connectionAction($array, $pdo);

        if ($connected['code'] == true) {
            session_start();
            $_SESSION['user_admin'] = $connected['email'];
            $_SESSION['user_id'] = $connected['id'];

            return true;
        } else {
            session_unset();
            session_destroy();

            return false;
        }
    }

    public function logOutAdmin()
    {
        session_start();
        unset($_SESSION['user_admin']);
        session_unset();
        session_destroy();
        return true;
    }

    public function addUser($array, $pdo)
    {
        function createPassword($nbCaractere)
        {
            $password = "";
            for ($i = 0; $i <= $nbCaractere; $i++) {
                $random = rand(97, 122);
                $password .= chr($random);
            }

            return $password;
        }


        $array['password'] = createPassword(8);
        $repo = new adminRepository();
        $send = $repo->addUserAction($array, $pdo);
        
        return $send;
    }

    public function getAllUsers($pdo){
        $repo = new adminRepository();
        $users = $repo->getAllUsersAction($pdo);
        return $users;
    }
    
    public function getAdminInformations($pdo){
        $repo = new adminRepository();
        $admin = $repo->getAdminInformationsAction($pdo);
        
        return $admin;
    }
    
    public function getUser($id_user, $pdo){
        $repo = new adminRepository();
        $admin = $repo->getUserAction($id_user, $pdo);

        return $admin;
    }

    public function addFile($data, $dataImg, $pdo)
    {
        if ($data['fichier'] == "facture") {
            $dirname = '/app/assets/pdf/facture/';
        } elseif ($data['fichier'] == "plan") {
            $dirname = '/app/assets/pdf/plan/';
        }

        if (!empty($dataImg['pdf'])) {
            $img = $dataImg['pdf'];
            $name = $dirname . $img['name'];
            $ext = strtolower(substr($img['name'], -3));
            $allow_ext = array('jpg', 'png', 'tif', 'gif', 'jpeg', 'pdf');
            if (in_array($ext, $allow_ext)) {
                move_uploaded_file($img['tmp_name'], '.' . $name);
            } else {
                $error = "votre fichier n'est pas une image";
                echo $error;
            }
        }
        $repo = new adminRepository();
        if ($data['fichier'] == "facture") {
            $repo->uploadFactureAction($data, $name, $pdo);
        } elseif ($data['fichier'] == "plan") {
            $repo->uploadPlanAction($data, $name, $pdo);
        }
        return $data['id'];
    }

}