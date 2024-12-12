<?php

namespace Hallax\Clone\Models;

use PDO;
use Hallax\Clone\Services\Model;
use Hallax\Clone\Config\Database;

class User extends Model
{

    protected $table = 'tbl_user';

    public static function getCurrentUser($user)
    {
        $instance = new self();
        $instance->db->query("SELECT * FROM " . $instance->table . " WHERE username = :username");
        $instance->db->bind(':username', $user);

        return $instance->db->single();
    }
    public static function getUser($user, $session = "")
    {
        $instance = new self();
        $instance->db->query(
            "SELECT u.*,
            CASE 
                WHEN f.follower IS NOT NULL THEN TRUE
                ELSE FALSE
            END AS is_following
            FROM {$instance->table} u
            LEFT JOIN tbl_follow f ON u.username = f.followed AND f.follower = :follower
            WHERE username = :username"
        );
        $instance->db->bind(':username', $user, PDO::PARAM_STR);
        $instance->db->bind(":follower", $session);

        return $instance->db->single();
    }

    public static function getAllUser()
    {
        $instance = new self();
        $instance->db->query("SELECT * FROM " . $instance->table);
        return $instance->db->resultSet();
    }
    public static function addUser($data)
    {
        $instance = new self();
        $instance->db->query("INSERT INTO " . $instance->table  . "(username, password, display_name) VALUES (:username, :password, :display)");
        $instance->db->bind(':username', strtolower($data['username']));
        $instance->db->bind(':display', $data['username']);
        $instance->db->bind(':password', $data['password']);

        $instance->db->execute();
        return $instance->db->rowCount();
    }

    public static function patch($data){
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "UPDATE {$instance->table} SET display_name = :display, photo_profile = :photo WHERE username = :username"
        );

        $db->bind(':display', $data['display']);
        $db->bind(':photo', $data['photo']);
        $db->bind(':username', $data['user']);

        $db->execute();

        return $db->rowCount();
    }
}
