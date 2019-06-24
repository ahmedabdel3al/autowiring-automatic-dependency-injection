<?php
namespace App\Config;

class Config
{
    public function __construct()
    {
      
    }
    /**
     * The loaded config
     *
     * @var array
     */
    protected $config  = [
        'app' => [
            'name' => 'Boyfci'
        ],
        'db' => [
            'host' => '127.0.0.1',
            'database' => 'autowiring',
            'username' => 'root',
            'password' => ''
        ]
    ];
}
