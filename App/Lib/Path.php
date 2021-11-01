<?php


class Path
{
    private const PROJECT_ROOT = __DIR__ . "/../../";
    private const APP_ROOT = __DIR__ . "/../";

    public static function get_path(string $type, string $name): string
    {
        $dir = null;
        switch ($type)
        {
            case "c":
            case "controller":
                $dir = 'Controller'; break;

            case "m":
            case "model":
                $dir = 'Model'; break;

            case "l":
            case "lib":
                $dir = 'Lib'; break;

            case "v":
            case 'view':
                $dir = 'view'; break;

            default:
                throw new RuntimeException("Wrong type ($type) provided.");
        }

        return self::APP_ROOT . "$dir/$name.php";
    }

    public static function get_config_path(): string
    {
        return self::PROJECT_ROOT . "config/env.php";
    }
}