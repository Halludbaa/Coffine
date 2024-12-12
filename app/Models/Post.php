<?php

namespace Hallax\Clone\Models;

use Hallax\Clone\Services\Hellper;
use Hallax\Clone\Services\Model;

class Post extends Model
{
    private $table = 'tbl_post';
    public static function getAllPost(string $session = "")
    {
        $instance = new self();
        $instance->db->query(
            "WITH total_like AS(
	        SELECT tl.slug AS slug, COUNT(tl.*) AS total_like FROM tbl_like tl GROUP BY tl.slug
            )
            SELECT p.*,
            u.display_name,
            u.photo_profile as pp,
            CASE WHEN f.follower IS NOT NULL THEN TRUE ELSE FALSE END AS is_following,
            CASE WHEN l.fan IS NOT NULL THEN TRUE ELSE FALSE END AS is_like,
            CASE WHEN s.saver IS NOT NULL THEN TRUE ELSE FALSE END AS is_save,
            CASE WHEN tl.total_like > 0 THEN tl.total_like ELSE 0 END AS total_like
            FROM tbl_post p
            INNER JOIN tbl_user u USING (username)
            LEFT JOIN tbl_follow f ON u.username = f.followed AND f.follower = :user
            LEFT JOIN tbl_like l ON p.slug = l.slug AND l.fan = :user
            LEFT JOIN tbl_save s ON p.slug = s.slug AND s.saver = :user
            LEFT JOIN total_like tl ON p.slug = tl.slug
            WHERE NOT p.username = :user AND p.reply IS NULL AND p.username NOT IN ('hacuk', 'byy_kind')
            ORDER BY p.create_at DESC
            ;"
        );

        $instance->db->bind(':user', $session);

        return $instance->db->resultSet();
    }

    public static function getReply(string $slug, string $session = "")
    {
        $instance = new self();
        $instance->db->query(
            "WITH total_like AS(
	        SELECT tl.slug AS slug, COUNT(tl.*) AS total_like FROM tbl_like tl GROUP BY tl.slug
            )
            SELECT p.*,
            u.display_name,
            u.photo_profile as pp,
            CASE WHEN f.follower IS NOT NULL THEN TRUE ELSE FALSE END AS is_following,
            CASE WHEN l.fan IS NOT NULL THEN TRUE ELSE FALSE END AS is_like,
            CASE WHEN s.saver IS NOT NULL THEN TRUE ELSE FALSE END AS is_save,
            CASE WHEN tl.total_like > 0 THEN tl.total_like ELSE 0 END AS total_like
            FROM tbl_post p
            INNER JOIN tbl_user u USING (username)
            LEFT JOIN tbl_follow f ON u.username = f.followed AND f.follower = :user
            LEFT JOIN tbl_like l ON p.slug = l.slug AND l.fan = :user
            LEFT JOIN tbl_save s ON p.slug = s.slug AND s.saver = :user
            LEFT JOIN total_like tl ON p.slug = tl.slug
            WHERE p.reply = :reply
            ORDER BY create_at DESC
            ;"
        );

        $instance->db->bind(':user', $session);
        $instance->db->bind(':reply', $slug);

        return $instance->db->resultSet();
    }

    public static function getFollowedPost(string $session)
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "WITH total_like AS(
	        SELECT tl.slug AS slug, COUNT(tl.*) AS total_like FROM tbl_like tl GROUP BY tl.slug
            )
            SELECT p.*,
            u.display_name,
            u.photo_profile as pp,
            CASE WHEN f.follower IS NOT NULL THEN TRUE ELSE FALSE END AS is_following,
            CASE WHEN l.fan IS NOT NULL THEN TRUE ELSE FALSE END AS is_like,
            CASE WHEN s.saver IS NOT NULL THEN TRUE ELSE FALSE END AS is_save,
            CASE WHEN tl.total_like > 0 THEN tl.total_like ELSE 0 END AS total_like
            FROM tbl_post p
            INNER JOIN tbl_user u USING (username)
            LEFT JOIN tbl_follow f ON u.username = f.followed AND f.follower = :user
            LEFT JOIN tbl_like l ON p.slug = l.slug AND l.fan = :user
            LEFT JOIN tbl_save s ON p.slug = s.slug AND s.saver = :user
            LEFT JOIN total_like tl ON p.slug = tl.slug
            WHERE f.follower = :user OR p.username = :user
            ORDER BY create_at DESC
            "
        );

        $instance->db->bind(':user', $session);
        return $db->resultSet();
    }

    public static function getSave(string $session = "")
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "WITH total_like AS(
	        SELECT tl.slug AS slug, COUNT(tl.*) AS total_like FROM tbl_like tl GROUP BY tl.slug
            )
            SELECT p.*,
            u.display_name,
            u.photo_profile as pp,
            CASE WHEN f.follower IS NOT NULL THEN TRUE ELSE FALSE END AS is_following,
            CASE WHEN l.fan IS NOT NULL THEN TRUE ELSE FALSE END AS is_like,
            CASE WHEN s.saver IS NOT NULL THEN TRUE ELSE FALSE END AS is_save,
            CASE WHEN tl.total_like > 0 THEN tl.total_like ELSE 0 END AS total_like
            FROM tbl_post p
            INNER JOIN tbl_user u USING (username)
            LEFT JOIN tbl_follow f ON u.username = f.followed AND f.follower = :user
            LEFT JOIN tbl_like l ON p.slug = l.slug AND l.fan = :user
            LEFT JOIN tbl_save s ON p.slug = s.slug AND s.saver = :user
            LEFT JOIN total_like tl ON p.slug = tl.slug
            WHERE s.slug IS NOT NULL
            ORDER BY create_at DESC
            "
        );

        $instance->db->bind(':user', $session);
        return $db->resultSet();
    }

    public static function getLike(string $session = "")
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "WITH total_like AS(
	        SELECT tl.slug AS slug, COUNT(tl.*) AS total_like FROM tbl_like tl GROUP BY tl.slug
            )
            SELECT p.*,
            u.display_name,
            u.photo_profile as pp,
            CASE WHEN f.follower IS NOT NULL THEN TRUE ELSE FALSE END AS is_following,
            CASE WHEN l.fan IS NOT NULL THEN TRUE ELSE FALSE END AS is_like,
            CASE WHEN s.saver IS NOT NULL THEN TRUE ELSE FALSE END AS is_save,
            CASE WHEN tl.total_like > 0 THEN tl.total_like ELSE 0 END AS total_like
            FROM tbl_post p
            INNER JOIN tbl_user u USING (username)
            LEFT JOIN tbl_follow f ON u.username = f.followed AND f.follower = :user
            LEFT JOIN tbl_like l ON p.slug = l.slug AND l.fan = :user
            LEFT JOIN tbl_save s ON p.slug = s.slug AND s.saver = :user
            LEFT JOIN total_like tl ON p.slug = tl.slug
            WHERE l.slug IS NOT NULL 
            ORDER BY create_at DESC
            "
        );

        $instance->db->bind(':user', $session);
        return $db->resultSet();
    }

    public static function getPost(string $slug)
    {
        $instance = new self();

        $instance->db->query(
            "SELECT * FROM {$instance->table} WHERE slug = :slug"
        );
        $instance->db->bind(':slug', $slug);
        return $instance->db->single();
    }

    public static function getPostOnce(string $slug, string $session = "")
    {
        $instance = new self();

        $instance->db->query(
            "WITH total_like AS(
	        SELECT tl.slug AS slug, COUNT(tl.*) AS total_like FROM tbl_like tl GROUP BY tl.slug
            )
            SELECT p.*,
            u.display_name,
            u.photo_profile as pp,
            CASE WHEN f.follower IS NOT NULL THEN TRUE ELSE FALSE END AS is_following,
            CASE WHEN l.fan IS NOT NULL THEN TRUE ELSE FALSE END AS is_like,
            CASE WHEN s.saver IS NOT NULL THEN TRUE ELSE FALSE END AS is_save,
            CASE WHEN tl.total_like > 0 THEN tl.total_like ELSE 0 END AS total_like
            FROM tbl_post p
            INNER JOIN tbl_user u USING (username)
            LEFT JOIN tbl_follow f ON u.username = f.followed AND f.follower = :user
            LEFT JOIN tbl_like l ON p.slug = l.slug AND l.fan = :user
            LEFT JOIN tbl_save s ON p.slug = s.slug AND s.saver = :user
            LEFT JOIN total_like tl ON p.slug = tl.slug
            WHERE p.slug = :slug
            ORDER BY create_at DESC
            "
        );
        $instance->db->bind(':slug', $slug);
        $instance->db->bind(":user", $session);
        return $instance->db->single();
    }

    public static function create($parms)
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "INSERT INTO {$instance->table} (username, body_post, slug, media)
            VALUES
            (:username, :body, :slug, :media)
            "
        );
        // Hellper::helldie($parms);
        $db->bind(':username', $parms['username']);
        $db->bind(':body', $parms['body_post']);
        $db->bind(':slug', $parms['slug']);
        $db->bind(':media', $parms['media']);

        $db->execute();
        return $db->rowCount();
    }

    public static function createReply($parms)
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "INSERT INTO {$instance->table} (username, body_post, slug, media, reply)
            VALUES
            (:username, :body, :slug, :media, :reply)
            "
        );
        // Hellper::helldie($parms);
        $db->bind(':username', $parms['username']);
        $db->bind(':body', $parms['body_post']);
        $db->bind(':slug', $parms['slug']);
        $db->bind(':media', $parms['media']);
        $db->bind(':reply', $parms['reply']);

        $db->execute();
        return $db->rowCount();
    }

    public static function getSome($parms, string $session = "")
    {
        $instance = new self();
        $db = $instance->db;
        $parms = strtolower($parms);

        $db->query(
            "WITH total_like AS(
	        SELECT tl.slug AS slug, COUNT(tl.*) AS total_like FROM tbl_like tl GROUP BY tl.slug
            )
            SELECT p.*,
            u.display_name,
            u.photo_profile as pp,
            CASE WHEN f.follower IS NOT NULL THEN TRUE ELSE FALSE END AS is_following,
            CASE WHEN l.fan IS NOT NULL THEN TRUE ELSE FALSE END AS is_like,
            CASE WHEN s.saver IS NOT NULL THEN TRUE ELSE FALSE END AS is_save,
            CASE WHEN tl.total_like > 0 THEN tl.total_like ELSE 0 END AS total_like
            FROM tbl_post p
            INNER JOIN tbl_user u USING (username)
            LEFT JOIN tbl_follow f ON u.username = f.followed AND f.follower = :user
            LEFT JOIN tbl_like l ON p.slug = l.slug AND l.fan = :user
            LEFT JOIN tbl_save s ON p.slug = s.slug AND s.saver = :user
            LEFT JOIN total_like tl ON p.slug = tl.slug
            WHERE LOWER(p.body_post) LIKE '%{$parms}%'  OR LOWER(u.display_name) LIKE '%{$parms}%'
        "
        );



        $db->bind(":user", $session);

        return $db->resultSet();
    }
    public static function getFrom($user, $session = "")
    {
        $instance = new self();
        $db = $instance->db;


        $db->query(
            "WITH total_like AS(
	        SELECT tl.slug AS slug, COUNT(tl.*) AS total_like FROM tbl_like tl GROUP BY tl.slug
            )
            SELECT p.*,
            u.display_name,
            u.photo_profile as pp,
            CASE WHEN f.follower IS NOT NULL THEN TRUE ELSE FALSE END AS is_following,
            CASE WHEN l.fan IS NOT NULL THEN TRUE ELSE FALSE END AS is_like,
            CASE WHEN s.saver IS NOT NULL THEN TRUE ELSE FALSE END AS is_save,
            CASE WHEN tl.total_like > 0 THEN tl.total_like ELSE 0 END AS total_like
            FROM tbl_post p
            INNER JOIN tbl_user u USING (username)
            LEFT JOIN tbl_follow f ON u.username = f.followed AND f.follower = :user
            LEFT JOIN tbl_like l ON p.slug = l.slug AND l.fan = :user
            LEFT JOIN tbl_save s ON p.slug = s.slug AND s.saver = :user
            LEFT JOIN total_like tl ON p.slug = tl.slug
            WHERE username = :username AND p.reply IS NULL
            ORDER BY p.create_at DESC
            "
        );


        $db->bind(":user", $session);
        $db->bind(':username', $user);

        return $db->resultSet();
    }

    public static function destroy($parms)
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "DELETE FROM {$instance->table} WHERE slug = :parms"
        );

        $db->bind(':parms', $parms['slug']);
        $db->execute();
        return $db->rowCount();
    }

    public static function patch($parms)
    {
        $instance = new self();
        $db = $instance->db;

        $db->query(
            "UPDATE {$instance->table} SET
            body_post = :body,
            media = :media
            WHERE slug = :slug"
        );

        $db->bind(':body', $parms['body']);
        $db->bind(':media', $parms['media']);
        $db->bind(':slug', $parms['slug']);

        $db->execute();
        return $db->rowCount();
    }
}
