<?php
/**
 * Created by PhpStorm.
 * User: azerty
 * Date: 19/04/2017
 * Time: 18:42
 */

namespace Controller;

use Model\contactRepository;

class contactController
{
    public function contactTreatment($pdo, $data)
    {
        $strIP = $_SERVER['REMOTE_ADDR'];
        $data['ip'] = $strIP;
        $repo = new contactRepository();
        if ($repo->getNumberMessage($pdo, $data['ip']) < 3) {
            $repo->insertAction($pdo, $data);

            echo "bien joué";
        } else {
            echo "trop de message";
        }
    }
}