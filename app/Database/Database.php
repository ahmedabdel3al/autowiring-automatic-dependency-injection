<?php
namespace App\Database;

use App\Config\Config;

class Database
{
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }
    public function connect()
    {
        return $this->config;
    }
}
