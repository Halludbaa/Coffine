<?php

namespace Hallax\Clone\Models;

use Hallax\Clone\Services\Model;

class Follow extends Model
{
    private string $table = 'tbl_follow';
    public static function checkFollow(string $followed, string $follower)
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "SELECT * FROM {$instance->table} 
            WHERE followed = :followed AND follower = :follower "
        );
        $db->bind(':followed', $followed);
        $db->bind(':follower', $follower);

        $db->execute();
        return $db->rowCount();
    }


    public static function create(string $followed, string $follower){
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "INSERT INTO {$instance->table} (followed, follower)
            VALUES
                (:followed, :follower)"
        );

        $db->bind(':followed', $followed);
        $db->bind(':follower', $follower);
        $db->execute();
        return $db->rowCount();
    }


    public static function destroy(string $followed, string $follower){
        $instance = new self();
        $db = $instance->db;
    
        $db->query(
            "DELETE FROM {$instance->table} 
            WHERE followed = :followed AND follower = :follower"
        );
    
        $db->bind(':followed', $followed);
        $db->bind(':follower', $follower);
        $db->execute();
        return $db->rowCount();
    }
}
