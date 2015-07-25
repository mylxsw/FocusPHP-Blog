<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

use Focus\Config\Config;
use Focus\Config\ArrayConfig;
use Demo\Libraries\Cache;
use Demo\Libraries\SaeCache;
use Psr\Log\LoggerInterface;

return [

    Config::class   => function () {
        return new ArrayConfig(__DIR__ . '/config.php');
    },

    PDO::class      => function (\Interop\Container\ContainerInterface $container) {
        $driver     = $container->get(Config::class)->get('db.driver', 'mysql');
        $dbname     = $container->get(Config::class)->get('db.dbname', '');
        $host       = $container->get(Config::class)->get('db.host', '127.0.0.1');
        $charset    = $container->get(Config::class)->get('db.charset', 'utf8');
        $user       = $container->get(Config::class)->get('db.user', 'root');
        $password   = $container->get(Config::class)->get('db.password', '');
        $port       = $container->get(Config::class)->get('db.port', 3306);

        $pdo = new \PDO("{$driver}:dbname={$dbname};host={$host};port={$port};charset={$charset}", $user, $password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    },

    Cache::class    => function () {
        return new SaeCache();
    },

    LoggerInterface::class  => function(\Interop\Container\ContainerInterface $container) {
        return new \Demo\Libraries\SaeLogger($container);
    }

];