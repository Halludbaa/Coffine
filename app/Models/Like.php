<?php

namespace Hallax\Clone\Models;

use Hallax\Clone\Services\Model;

class Like extends Model
{
    private string $table = 'tbl_like';
    public static function checkLike(string $fan, string $ownerp, string $slug)
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "SELECT * FROM {$instance->table} 
            WHERE fan = :fan AND slug = :slug AND owner_post = :ownerp"
        );
        $db->bind(':fan', $fan);
        $db->bind(':ownerp', $ownerp);
        $db->bind(':slug', $slug);

        $db->execute();
        return $db->rowCount();
    }


    public static function create(string $fan, string $ownerp, string $slug){
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "INSERT INTO {$instance->table} (fan, owner_post, slug)
            VALUES
                (:fan, :ownerp, :slug)"
        );

        $db->bind(':fan', $fan);
        $db->bind(':ownerp', $ownerp);
        $db->bind(':slug', $slug);
        $db->execute();
        return $db->rowCount();
    }


    public static function destroy(string $fan, string $ownerp, string $slug){
        $instance = new self();
        $db = $instance->db;
    
        $db->query(
            "DELETE FROM {$instance->table} 
            WHERE fan = :fan AND slug = :slug AND owner_post = :ownerp"
        );

        $db->bind(':fan', $fan);
        $db->bind(':ownerp', $ownerp);
        $db->bind(':slug', $slug);
        $db->execute();
        return $db->rowCount();
    }
}
