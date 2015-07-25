<?php
/**
 * FocusPHP-Blog
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the
 *            LICENSE file)
 */

namespace Demo\Controllers;


use Demo\Libraries\Controller;
use Demo\Models\Post;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class Rss extends Controller
{

    public function showAction(Post $postModel)
    {

        $posts = $postModel->getRecentlyPosts(1, 20);

        $feed    = new Feed();
        $channel = new Channel();
        $channel->title('Aicode')
            ->description('爱生活，爱代码')
            ->url('http://aicode.cc')
            ->lastBuildDate($posts['data'][0]['publish_date'])
            ->appendTo($feed);

        foreach ($posts['data'] as $art) {
            $item = new Item();
            $item->title($art['title'])
                ->description('<p><img src="' . $art['feature_img'] . '" /></p>'
                    . (new \Parsedown())->parse($art['content']))
                ->url('http://aicode.cc/article/' . $art['id'] . '.html')
                ->pubDate($art['publish_date'])
                ->guid('http://aicode.cc/article/' . $art['id'] . '.html')
                ->appendTo($channel);
        }
        header('Content-Type:text/xml; charset=utf-8');
        return $feed->render();
    }
} 