<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the
 *            LICENSE file)
 */

require __DIR__ . '/vendor/autoload.php';

define('BASE_PATH', __DIR__ . '/src');

$basicContainer = new \Focus\BasicContainer(__DIR__
    . '/src/Configs/container.php');
$server         = \Focus\Server::init(\Focus\Container::instance()
        ->setContainer($basicContainer));

$server->registerExceptionHandler(function ($exception) {
    echo "<pre>";
    echo $exception;
    echo "</pre>";
});

$server->setNotFoundRouter(new \Demo\Libraries\NotFoundRouter());

// 先注册者优先
$server->registerRouter(new \Focus\MVC\Router('Demo\Controllers', [
    '/^article\/([0-9]+).html$/'        => 'post/show?id=$1',
    '/^category\/([0-9]+).html$/'       => 'post/list?cat=$1',
    '/^tag\/(.*?).html$/'               => 'post/tag?tag=$1',
    '/^about.html$/'                    => 'index/about',
    '/^api\/blog\/related-(.*?).json$/' => 'api/relatedPosts?tags=$1',
    '/^管宜尧$/'                           => 'index/admin',
    '/^cache$/'                         => 'index/cache',
    '/^rss.xml$/'                           => 'rss/show'
]));

$server->run();
