<?php

namespace Nathand\Doctrine\kernel;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class init
{
    private static ?EntityManager $entityManager = null;
    private static array $path = ['src/entities'];
    private static bool $isDev = true;
    private static array $dbParams = array(
        'driver'   => 'pdo_mysql',
        'user'     => 'doctrine',
        'password' => 'doctrine',
        'dbname'   => 'doctrine',
    );
    private Configuration $config;

    private Connection $connection;

    private function __construct()
    {
        //set up configuration
        $this->config = ORMSetup::createAttributeMetadataConfiguration(self::$path, self::$isDev);

        // Create EntityManager
        $this->connection = DriverManager::getConnection(self::$dbParams, $this->config);
    }

    public static function getEntityManager()
    {
        if (self::$entityManager == null) {
            $object = new static;
            self::$entityManager = self::$entityManager = new EntityManager($object->connection, $object->config);
        }
        return self::$entityManager;
    }
}
