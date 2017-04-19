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
    public function connectionAction($array, $pdo){
        $query = "SELECT id FROM administrators WHERE email = :email AND password = :password";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':email', $array['email']);
        $stmt->bindValue(':password', $array['password']);
        $stmt->execute();
        $res = $stmt->fetch();

        if ($res != null){
            $arrayRtn  = [];
            $arrayRtn['id'] = $res['id'];
            $arrayRtn['code'] = true;
            $arrayRtn['email'] = $array['email'];

            return $arrayRtn;
        }else{
            $arrayRtn  = [];
            $arrayRtn['code'] = false;
            $arrayRtn['email'] = $array['email'];

            return $arrayRtn;
        }
    }
}