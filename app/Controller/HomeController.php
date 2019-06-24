<?php
namespace App\Controller;

use App\Config\Config;
use App\Database\Database;

class HomeController
{
    protected $config , $database ; 
    public function __construct(Config $config, Database $database)
    {
        $this->config = $config;
        $this->database = $database;
    }

    public function index()
    { 
        return [
            $this->config ,
            $this->database->connect()
        ];
    }
}
