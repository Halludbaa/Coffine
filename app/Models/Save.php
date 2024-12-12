<?php

namespace Hallax\Clone\Models;

use Hallax\Clone\Services\Model;

class Save extends Model
{
    private string $table = 'tbl_save';
    public static function checkSave(string $saver, string $ownerp, string $slug)
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "SELECT * FROM {$instance->table} 
            WHERE saver = :saver AND slug = :slug AND owner_post = :ownerp"
        );
        $db->bind(':saver', $saver);
        $db->bind(':ownerp', $ownerp);
        $db->bind(':slug', $slug);

        $db->execute();
        return $db->rowCount();
    }


    public static function create(string $saver, string $ownerp, string $slug){
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "INSERT INTO {$instance->table} (saver, owner_post, slug)
            VALUES
                (:saver, :ownerp, :slug)"
        );

        $db->bind(':saver', $saver);
        $db->bind(':ownerp', $ownerp);
        $db->bind(':slug', $slug);
        $db->execute();
        return $db->rowCount();
    }


    public static function destroy(string $saver, string $ownerp, string $slug){
        $instance = new self();
        $db = $instance->db;
    
        $db->query(
            "DELETE FROM {$instance->table} 
            WHERE saver = :saver AND slug = :slug AND owner_post = :ownerp"
        );

        $db->bind(':saver', $saver);
        $db->bind(':ownerp', $ownerp);
        $db->bind(':slug', $slug);
        $db->execute();
        return $db->rowCount();
    }
}
