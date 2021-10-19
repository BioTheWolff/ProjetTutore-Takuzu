<?php
require_once 'Path.php';

class   Config
{
    /**
     * @var Config $instance
     * @var array $env
     */
    private static $instance = null;
    private $env;

    private function __construct()
    {
        $this->env = require_once(Path::get_config_path());
    }

    /**
     * @return Config
     */
    public static function getInstance(): ?Config
    {
        if (is_null(self::$instance)) self::$instance = new Config;
        return self::$instance;
    }

    public function get(string $key, string $default = null)
    {
        return $this->env[$key] ?? $default;
    }
}