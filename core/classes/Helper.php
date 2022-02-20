<?php

class Helper
{
    public static function redirect($page)
    {
        header("Location:$page");
    }

    public static function filter($str)
    {
        $str = trim($str);
        $str = htmlspecialchars($str);
        return $str;
    }
    public static function slug($str)
    {
        $str = strtolower($str);
        $str = str_replace(' ', '-', $str);
        $str .= '-' . time();
        return $str;
    }
}
