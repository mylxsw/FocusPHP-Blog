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
use Demo\Models\Post;
use Demo\Models\Setting;
use Focus\MVC\SimpleView;
use Focus\MVC\SmpJsonView;
use Focus\Request\Request;

class Index extends Controller {

    /**
     * 首页
     *
     * @param Request $request
     * @param Post $postModel
     *
     * @return string
     */
    public function indexAction(Request $request, Post $postModel) {
        $current = intval($request->get('page', 1));

        $key = "list_{$current}";
        $html = $this->getCache()->get($key);

        if (false === $html) {
            $posts = $postModel->getRecentlyPosts($current, 10);
            $this->assign('posts', $posts['data']);
            $this->assign('page', $posts['page']);

            $this->assign('parsedown', new \Parsedown());
            $this->assign('catModel', new Category());
            $html = $this->view('index')->render();
            $this->getCache()->set($key, $html);
        }

        return $html;
    }

    /**
     * 关于页面
     *
     * @return \Focus\MVC\SmpView
     */
    public function aboutAction() {
        $this->assign('__navcur__', '走过路过');
        return $this->view('about');
    }

    /**
     * 管理后台
     */
    public function adminAction() {
        header('Location: http://admin.aicode.cc');
        exit();
    }

    /**
     * 缓存管理API
     *
     * @param Request $request
     * @param Setting $settingModel
     * @param SmpJsonView $view
     *
     * @return \Focus\MVC\View
     */
    public function cacheAction(Request $request, Setting $settingModel, SmpJsonView $view) {
        // __tags__, __nav__, post_[id], list_[current], list_[cat]_[current], tag_[tagName]_[current]
        $key = $request->get('key');
        $clear = $request->get('clear', 'false');
        $token = $request->get('token', '');
        $byprefix = $request->get('byprefix', false);

        if (empty($key)) {
            return $view->assign('status', false)->assign('info', 'key_required');
        }

        $tokenEntity = $settingModel->getSetting('cache_token', 'system');
        if (empty($tokenEntity)
            || !isset($tokenEntity['setting_value'])
            || $token !== $tokenEntity['setting_value']) {
            return $view->assign('status', false)->assign('info', 'token_invalid');
        }

        // 通过前缀处理
        if ($byprefix === 'true') {
            $res = $this->getCache()->all($key);
            $view->assign('original', $res);
            if ($clear == 'true') {
                foreach ($res as $_key => $_val){
                    $this->getCache()->delete($_key);
                }
            }

            return $view->assign('status', true)->assign('info', 'clear ' + count($res) + ' items');
        }

        $res = $this->getCache()->get($key);
        if ($res !== false) {
            $this->assign('original', $res);
            if ($clear == 'true') {
                return $view->assign('status', $this->getCache()->delete($key));
            }
        }

        return $view->assign('status', $res);
    }
}