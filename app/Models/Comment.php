<?php

namespace Hallax\Clone\Models;

use Hallax\Clone\Services\Model;

class Comment extends Model
{
    private string $table = 'tbl_comment';
    public static function check(string $slug, string $username)
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "SELECT * FROM {$instance->table} 
            WHERE slug = :slug AND username = :username "
        );
        $db->bind(':slug', $slug);
        $db->bind(':username', $username);

        $db->execute();
        return $db->rowCount();
    }

    public static function get(string $slug)
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "SELECT c.*,
            u.display_name,
            u.photo_profile AS pp
            FROM {$instance->table} c
            INNER JOIN tbl_user u USING (username)
            WHERE slug = :slug AND reply IS NULL"
        );
        $db->bind(':slug', $slug);

        return $db->resultSet();
    }


    public static function create(array $data){
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "INSERT INTO {$instance->table} (slug, username, reply, bdy_comment)
            VALUES
                (:slug, :username, :reply, :body)"
        );

        $db->bind(':slug', $data['slug']);
        $db->bind(':username', $data['username']);
        $db->bind(':reply', $data['reply']);
        $db->bind(':body', $data['bdy_comment']);
        $db->execute();
        return $db->rowCount();
    }


    public static function destroy(string $id_comment){
        $instance = new self();
        $db = $instance->db;
    
        $db->query(
            "DELETE FROM {$instance->table} 
            WHERE id_comment = :id "
        );
    
        $db->bind(':id', $id_comment);
        $db->execute();
        return $db->rowCount();
    }
}
