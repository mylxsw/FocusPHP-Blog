<?php
/**
 * FocusPHP-Blog
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Controllers;


use Demo\Libraries\Controller;
use Demo\Models\Post;
use Demo\Models\Tags;
use Focus\MVC\SmpJsonView;
use Focus\Request\Request;

class Api extends Controller {

    /**
     * 根据标签名称获取相关文章
     *
     * @param Request $request
     * @param Tags $tagModel
     * @param Post $postModel
     * @param SmpJsonView $jsonView
     *
     * @return SmpJsonView
     */
    public function relatedPostsAction(
        Request $request,
        Tags $tagModel,
        Post $postModel,
        SmpJsonView $jsonView) {

        $tags = $tagModel->getTagsByNames(explode(',', $request->get('tags', '')));
        $tag_ids = [];
        foreach ($tags as $tag) {
            $tag_ids[] = $tag['id'];
        }
        $posts = $postModel->getPostsInfoByTags($tag_ids, 10);
        $jsonView->assign('posts', $posts);
        $jsonView->assign('status', true);
        return $jsonView;
    }
} 