<?php
/**
 * Created by PhpStorm.
 * User: azerty
 * Date: 19/04/2017
 * Time: 18:43
 */

namespace Model;


class contactRepository
{
    public function getNumberMessage($pdo, $ip)
    {
        $sql = "SELECT `ip` FROM contact WHERE ip = :ip;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ip', $ip);
        $stmt->execute();

        $row = $stmt->rowCount();
        return $row;
    }

    public function insertAction($pdo, $data)
    {
        $sql = "INSERT INTO 
                  `contact`
                  (`lastname`,
                   `name`,
                   `email`, 
                   `status`, 
                   `telephone`, 
                   `hour`, 
                   `object`, 
                   `message`,
                   `ip`)
                 VALUES (
                    :lastname,
                    :name,
                    :email,
                    :status,
                    :phone,
                    :hour,
                    :object,
                    :message,
                    :ip)
        ;";
        $stmt = $pdo ->prepare($sql);
        $stmt->bindParam(':lastname', $data['lastname']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['name']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':hour', $data['date']);
        $stmt->bindParam(':object', $data['object']);
        $stmt->bindParam(':message', $data['message']);
        $stmt->bindParam(':ip', $data['ip']);
        $stmt->execute();
        return true;
    }
}