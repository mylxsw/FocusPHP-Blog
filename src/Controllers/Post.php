<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Controllers;

use Demo\Libraries\Controller;
use Demo\Models\Category;
use Demo\Models\Tags;
use Focus\Request\Request;

class Post extends Controller {

    /**
     * 文章展示页
     *
     * @param Request $request
     * @param \Demo\Models\Post $postModel
     *
     * @return string
     */
    public function showAction( Request $request,
        \Demo\Models\Post $postModel,
        Tags $tagModel
    ) {
        $id   = intval( $request->get( 'id' ) );

        $html = $this->getCache()->get("post_{$id}");
        if (false === $html) {
            $post = $postModel->getPostById( $id );
            $tags = $tagModel->getTagsByPostId($id);

            $this->assign('post', $post);
            $this->assign('tags', $tags);
            $this->assign('parsedown', new \Parsedown());
            $this->assign('catModel', new Category());

            if (!empty($tags) && is_array($tags)) {
                $tagIds = [];
                foreach ($tags as $tag) {
                    $tagIds[] = $tag['id'];
                }

                $this->assign('relates', $postModel->getPostsInfoByTags($tagIds, 10));
            }

            $html = $this->view('post')->render();
            $this->getCache()->set("post_{$id}", $html);
        }

        return $html;
    }

    /**
     * 文章列表页（分类）
     *
     * @param Request $request
     * @param \Demo\Models\Post $postModel
     *
     * @return string
     */
    public function listAction(Request $request, \Demo\Models\Post $postModel) {
        $current = intval($request->get('page', 1));
        $cat = intval($request->get('cat'));

        $key = "list_{$cat}_{$current}";
        $html = $this->getCache()->get($key);
        if (false === $html) {
            $posts = $postModel->getPostsInCate($cat, $current);
            $this->assign('posts', $posts['data']);
            $this->assign('page', $posts['page']);
            $this->assign('__cat__', $cat);
            $this->assign('__navcur__', '技不压身');

            $this->assign('parsedown', new \Parsedown());
            $this->assign('catModel', new Category());

            $html = $this->view('index')->render();
            $this->getCache()->set($key, $html);
        }

        return $html;
    }

    /**
     * 文章列表页 (标签)
     *
     * @param Request $request
     * @param \Demo\Models\Post $postModel
     * @param \Demo\Models\Tags $tagModel
     *
     * @return string
     */
    public function tagAction(Request $request, \Demo\Models\Post $postModel, \Demo\Models\Tags $tagModel) {
        $tagName = $request->get('tag');
        $current = intval($request->get('page', 1));

        $key = "tag_{$tagName}_{$current}";
        $html = $this->getCache()->get($key);
        if (false === $html) {
            $tag = $tagModel->getTagByName($tagName);
            $posts = $postModel->getPostsByTag($tag['id'], $current);

            $this->assign('posts', $posts['data']);
            $this->assign('page', $posts['page']);
            $this->assign('__tag__', $tag);
            $this->assign('__navcur__', '技不压身');

            $this->assign('parsedown', new \Parsedown());
            $this->assign('catModel', new Category());

            $html = $this->view('index')->render();
            $this->getCache()->set($key, $html);
        }

        return $html;
    }
} 