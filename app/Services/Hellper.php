<?php

namespace Hallax\Clone\Services;

class Hellper
{

    public static function view(string $view, $data = [])
    {
        require_once __DIR__ . '/../../resources/views/' . $view . '.php';
    }

    public static function helldie($target)
    {
        die(var_dump($target));
    }

    public static function redirect(string $to)
    {
        header('Location: ' . $to);
        exit;
    }

    public static function back()
    {
        echo "<script> window.history.go(-1) </script>";
        exit;
    }

    public static function imageChecker(array $fileGuard,  string $from, string $deafaultImage = NULL)
    {
        $image = $_FILES[$from];
        if ($errorFiles = $image['error'] !== 4) {
            $extension = pathinfo($image['name'])['extension'];

            if (!in_array($extension, $fileGuard)) {
                Hellper::back();
                return;
            } else {
                $newName = hash('md5', pathinfo($image['name'])['filename']);
                $newFile = $newName . time() . '.' . $extension;

                $image['name'] = $newFile;

                $tmp = $image['tmp_name'];
                $filepath = UPLOAD_DIR . '/' . $newFile;
                move_uploaded_file($tmp, $filepath);

                return $newFile;
            }
        }
        
        return;
    }

    public static function imageDestroy(mixed $file){
        if(is_null($file)) return;

        $dir = UPLOAD_DIR . '/' . $file;
        if(file_exists($dir)) unlink($dir);
        return;
    }
}
