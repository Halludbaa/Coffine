<?php

namespace Hallax\Clone\Controller;

use Hallax\Clone\Models\Follow;
use Hallax\Clone\Models\Post;
use Hallax\Clone\Models\User;
use Hallax\Clone\Services\Controller;
use Hallax\Clone\Services\Hellper;

class UserController extends Controller
{

    public function login()
    {

        Hellper::view('user/login');
        unset($_SESSION['status']);
    }
    public function test()
    {

        Hellper::helldie($_POST);
    }
    public function processLogin()
    {
        $validate = User::getUser($_POST['username']);
        if (
            $_POST['username'] == @$validate['username']
            && password_verify($_POST['password'], $validate['password'])
        ) {
            //Make session with username
            $_SESSION['user'] = $validate['username'];
            // $_SESSION['display_name'] = $validate['display_name'];

            if (isset($_POST['remindme'])) {
                setcookie('user', $validate['username'], COOKIE_EXPIRED, '/');
            }

            echo json_encode(["say" => "Success"]);
            return;
        }
        echo json_encode(["say" => "Login Failed"]);
        exit;
    }

    public function register()
    {

        Hellper::view('user/register');
    }

    public function processRegister()
    {
        $listUser = User::getAllUser();

        foreach ($listUser as $user) {
            // Hellper::helldie($user);
            if ($_POST['username'] == $user['username'] || $_POST['username'] == '') {
                $msg = [
                    "msg" => "*Alredy Exist",
                    "for" => "username"
                ];
                echo json_encode($msg);
                return;
            }
        }


        if ($_POST['password'] != $_POST['confirm_password']) {
            $msg = [
                "msg" => "*Password Must be Same",
                "for" => "password"
            ];
            echo json_encode($msg);
            return;
        }


        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if (User::addUser($_POST) > 0) {
            $msg = [
                "msg" => "success",
                "for" => ""
            ];
            echo json_encode($msg);
        };
    }

    public function logout()
    {
        if (isset($_COOKIE['user'])) setcookie('user', $_SESSION['user'], COOKIE_DELETED, "/");
        if (isset($_SESSION['user'])) unset($_SESSION['user']);
        Hellper::redirect('/');
    }

    public function profile(string $user)
    {
        $validate = [
            "username" => $user
        ];
        $profile = User::getUser($validate['username'], @$_SESSION['user']);
        $getUser = User::getCurrentUser(@$_SESSION['user']);
        $getPost = Post::getFrom($user, @$_SESSION['user']);
        if (isset($profile['username'])) {
            $data = [
                'title' => $profile['display_name'],
                "profile" => $profile,
                "user" => $getUser['display_name'],
                "post" => $getPost,
                "pic" => $getUser['photo_profile'],


            ];
            Hellper::view('user/profile', $data);
            return;
        }

        http_response_code(404);
        echo "Not Found";
    }

    public function options()
    {
        $getUser = User::getCurrentUser($_SESSION['user']);
        $data = [
            "title" => 'Options',
            "user" => $getUser['display_name'],
            "options" => $getUser,
            "pic" => $getUser['photo_profile'] ?? 'none.jpg',
        ];
        Hellper::view('user/options', $data);
    }

    public function saveProfile()
    {
        $display = $_POST['display'];
        $user = $_POST['session'];
        $photo = Hellper::imageChecker(['png', 'jpg', 'jpeg'], 'profile') ?? $_POST['old_photo'];
        if ($_POST['old_photo'] !== $photo) {
            unlink(UPLOAD_DIR . '/' . $_POST['old_photo']);
        }
        $data = [
            'display' => $display,
            'user' => $user,
            'photo' => $photo,
        ];
        // echo json_encode($data);

        if (User::patch($data) > 0) {
            $patch = [
                'status' => 'Succes to Update Profile'
            ];

            echo json_encode($patch);
        }
    }

    public function followSystem()
    {
        $followed = $_POST['followed'];
        $follower = $_POST['follower'];
        if (Follow::checkFollow($followed, $follower) > 0) {
            if (Follow::destroy($followed, $follower) > 0) {
                $data = [
                    "status" => "Follow",
                    "condition" => "Success Unfollow",
                ];
                echo json_encode($data);
                return;
            }
        } else {
            if (Follow::create($followed, $follower) > 0) {
                $data = [
                    "status" => "Following",
                    "condition" => "Success Follow",
                ];
                echo json_encode($data);
                return;
            }
        }
    }
}
