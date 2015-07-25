<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

$config = [

    'db.driver'    => 'mysql',
    'db.host'      => '127.0.0.1',
    'db.port'      => 3306,
    'db.dbname'    => 'focusphp',
    'db.user'      => 'root',
    'db.password'  => '',
    'db.charset'   => 'utf8',

];

if (file_exists(__DIR__ . '/config_db.php')) {
    $config_db = include __DIR__ . '/config_db.php';
    $config = array_merge($config, $config_db);
}


return $config;
