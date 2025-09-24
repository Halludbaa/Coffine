<?php

namespace Hallax\Clone\Services;

class Env
{

    public function __construct()
    {
        define('BASEURL', 'http://0.0.0.0');

        define('UPLOAD_DIR', __DIR__ . '/../../resources/img/uploads');

        define('COOKIE_EXPIRED', time() + (3600 * 24 * 30));
        define('COOKIE_DELETED', time() - (3600 * 24 * 30));

        define('DB_ENGINE', 'pgsql');
        define('DB_HOST', '127.0.0.1');
        define('DB_PORT', '5432');
        define('DB_USER', 'postgres');
        define('DB_PASS', 'root');
        define('DB_NAME', 'coffine');
    }
}
