<?php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Model;

class Cookie extends Model
{
    /**
     * @param $name
     * @param $value
     */
    public static function set($name, $value)
    {
        setcookie($name, $value, time() + (86400 * 30), "/");
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function get($name)
    {
        return $_COOKIE[$name];

    }

    /**
     * @param Closure|string $name
     * @return bool|void
     */
    public static function destroy($name)
    {
        if (isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);
            setcookie($name, null, -1, '/');
            return true;
        } else {
            return false;
        }
    }
}
