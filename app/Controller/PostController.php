<?php

namespace Hallax\Clone\Controller;

use Hallax\Clone\Models\Comment;
use PHPUnit\TextUI\Help;
use Hallax\Clone\Models\Like;
use Hallax\Clone\Models\Post;
use Hallax\Clone\Models\Save;
use Hallax\Clone\Models\User;
use Hallax\Clone\Services\Hellper;
use Hallax\Clone\Services\Controller;

use function PHPUnit\Framework\isNull;

class PostController extends Controller
{

    public function index()
    {
        $getUser = User::getCurrentUser($_SESSION['user']);
        $getPost = Post::getFollowedPost($_SESSION['user']);
        $data = [
            "pic" => $getUser['photo_profile'] ?? 'none.jpg',
            'post' => $getPost,
            "title" => 'Home',
            'user' => $getUser['display_name']
        ];
        Hellper::view('post/home', $data);
    }

    public function media()
    {
        $getPost = Post::getAllPost($_SESSION['user']);
        $getUser = User::getCurrentUser($_SESSION['user']);
        $data = [
            'title' => 'Media',
            'user' => $getUser['display_name'] ?? '@' . $getUser['username'],
            'post' => $getPost,
            "pic" => $getUser['photo_profile'] ?? 'none.jpg',

        ];
        Hellper::view('post/media', $data);
    }

    public function createPost()
    {
        // Hellper::helldie($_POST);
        $image = Hellper::imageChecker(['png', 'jpeg', 'jpg', 'gif', 'JPG'], 'media');
        if (!is_null($image) || $_POST['body-post'] !== "") {
            $data = [
                "username" => $_SESSION['user'],
                "body_post" => $_POST['body-post'],
                "slug" => time() . uniqid(),
                "media" => $image ?? NULL,
            ];
            if (Post::create($data) > 0) {
                echo "Ok";
                return;
            }
            echo "Failed";
        }
    }

    public function createReply()
    {
        // Hellper::helldie($_POST);
        $image = Hellper::imageChecker(['png', 'jpeg', 'jpg', 'gif', 'JPG'], 'media');
        if (!is_null($image) || $_POST['body-post'] !== "") {
            $data = [
                "username" => $_SESSION['user'],
                "body_post" => $_POST['body-post'],
                "slug" => time() . uniqid(),
                "media" => $image ?? NULL,
                "reply" => $_POST['reply'],
            ];
            if (Post::createReply($data) > 0) {
                echo "Ok";
                return;
            }
        }
        echo "Failed";
    }

    public function delete()
    {
        $slug = $_POST['slug'];
        $data = [
            "slug" => $slug,
        ];
        $post = Post::getPost($slug);
        Hellper::imageDestroy($post['media']);
        if (Post::destroy($data) > 0) {
            $send = [
                "status" => "Success",
            ];
            echo json_encode($send);
        }
    }

    public function patch()
    {
       
        if ($_POST['old_media'] == "") $_POST['old_media'] = NULL;
        $media = Hellper::imageChecker(['png', 'jpg', 'jpeg', 'gif', 'JPG'], 'media') ?? $_POST['old_media'];
        if ($_POST['old_media'] !== $media) {
            Hellper::imageDestroy($_POST['old_media']);
        }
        $patch = [
            "slug" => $_POST['slug'],
            "media" => $media,
            "body" => $_POST['body-post'],
        ];

        if (Post::patch($patch) > 0) {
            $send = [
                "status" => "ok",
            ];
            echo json_encode($send);
            return;
        }
    }
    public function search()
    {
        $getPost = Post::getSome($_GET['q'], $_SESSION['user']);
        $getUser = User::getCurrentUser($_SESSION['user']);
        // Hellper::helldie($getPost);
        $data = [
            'title' => 'Search',
            "post" => $getPost,
            "user" => $getUser['display_name'] ?? '@' . $getUser['username'],
            "pic" => $getUser['photo_profile'] ?? 'none.jpg',
        ];
        Hellper::view('post/media', $data);
    }

    public function getPost($user, $slug)
    {
        $getPost = Post::getPostOnce($slug, $_SESSION['user']);
        $getUser = User::getCurrentUser($_SESSION['user']);
        $getComment = Post::getReply($getPost['slug'], $_SESSION['user']);
        // Hellper::helldie($getComment);
        $data = [
            'title' => $getPost['username'],
            "post" => $getPost,
            "comment" => $getComment,
            "user" => $getUser['display_name'] ?? '@' . $getUser['username'],
            "pic" => $getUser['photo_profile'] ?? 'none.jpg',
        ];
        Hellper::view('post/once', $data);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (Save::checkSave($_POST['saver'], $_POST['owner'], $_POST['slug']) > 0) {
                Save::destroy($_POST['saver'], $_POST['owner'], $_POST['slug']);
            } else {
                Save::create($_POST['saver'], $_POST['owner'], $_POST['slug']);
            }

            exit;
        }
        $getPost = Post::getSave($_SESSION['user']);
        $getUser = User::getCurrentUser($_SESSION['user']);
        // Hellper::helldie($getPost);
        $data = [
            'title' => 'Save',
            "post" => $getPost,
            "user" => $getUser['display_name'] ?? '@' . $getUser['username'],
            "pic" => $getUser['photo_profile'] ?? 'none.jpg',
        ];
        Hellper::view('post/media', $data);
    }
    public function like()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (Like::checkLike($_POST['fan'], $_POST['owner'], $_POST['slug']) > 0) {
                Like::destroy($_POST['fan'], $_POST['owner'], $_POST['slug']);
                echo "-1";
            } else {
                Like::create($_POST['fan'], $_POST['owner'], $_POST['slug']);
                echo "+1";
            }

            exit;
        }
        $getPost = Post::getLike($_SESSION['user']);
        $getUser = User::getCurrentUser($_SESSION['user']);
        // Hellper::helldie($getPost);
        $data = [
            'title' => 'Like',
            "post" => $getPost,
            "user" => $getUser['display_name'] ?? '@' . $getUser['username'],
            "pic" => $getUser['photo_profile'] ?? 'none.jpg',
        ];
        Hellper::view('post/media', $data);
    }
}
