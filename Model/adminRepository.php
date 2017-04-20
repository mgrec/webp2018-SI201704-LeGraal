<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 19/04/2017
 * Time: 15:05
 */

namespace Model;


class adminRepository
{
    public function connectionAction($array, $pdo)
    {
        $query = "SELECT id FROM administrators WHERE email = :email AND password = :password";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':email', $array['email']);
        $stmt->bindValue(':password', $array['password']);
        $stmt->execute();
        $res = $stmt->fetch();

        if ($res != null) {
            $arrayRtn = [];
            $arrayRtn['id'] = $res['id'];
            $arrayRtn['code'] = true;
            $arrayRtn['email'] = $array['email'];

            return $arrayRtn;
        } else {
            $arrayRtn = [];
            $arrayRtn['code'] = false;
            $arrayRtn['email'] = $array['email'];

            return $arrayRtn;
        }
    }

    public function addUserAction($array, $pdo)
    {
        $query = "SELECT id FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':email', $array['email']);
        $stmt->execute();
        $res = $stmt->fetch();

        if ($res == null) {
            $query = "INSERT INTO users (name, lastname, email, password) VALUES (:name, :lastname, :email, :password)";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':name', $array['name']);
            $stmt->bindValue(':lastname', $array['lastname']);
            $stmt->bindValue(':email', $array['email']);
            $stmt->bindValue(':password', $array['password']);
            $stmt->execute();

            $to = $array['email'];
            $subject = 'BTP tu connais';
            $message = 'Bonjour, merci de votre inscription, vous pouvez vous connecter à cette adresse http://www.btp-tu-connais.fr/ à l\'aide de votre adresse email et de votre mot de passe qui est : ' . $array['password'];
            $headers = 'From: site-contact@btp-tu-connais.com' . "\r\n" .
                'Reply-To: site-contact@btp-tu-connais.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);

            $arrayRtn = [];
            $arrayRtn['code'] = true;

            return $arrayRtn;
        } else {
            $arrayRtn = [];
            $arrayRtn['code'] = false;

            return $arrayRtn;
        }
    }

    public function getAllUsersAction($pdo)
    {
        $query = "SELECT * FROM users";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $res = $stmt->fetchAll();
        
        return $res;
    }
    
    public function getAdminInformationsAction($pdo){
        $query = "SELECT * FROM administrators";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $res = $stmt->fetch();

        return $res;
    }

    public function getUserAction($id_user, $pdo){
        $query = "SELECT * FROM users WHERE id = :id_user";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id_user', $id_user);
        $stmt->execute();
        $res = $stmt->fetch();

        return $res;
    }
}