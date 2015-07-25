<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Libraries;

use Demo\Models\Navigator;
use Demo\Models\Tags;
use Focus\ContainerAwareTrait;
use Focus\MVC\SmpView;

class Controller {

    use ContainerAwareTrait;

    /**
     * @var SmpView
     */
    protected $view;

    /**
     * @var array
     */
    protected $sidebars = [];

    public function __init__() {}

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function assign($key, $value) {
        if (empty($this->view)) {
            $this->view = new SmpView();
        }
        $this->view->assign($key, $value);
    }

    /**
     * @param string $templateName Template name
     *
     * @return SmpView
     */
    public function view($templateName) {
        if (empty($this->view)) {
            $this->view = new SmpView();
        }

        $this->view->setTemplate(BASE_PATH . "/Views/{$templateName}");
        $this->view->setLayout(BASE_PATH . '/Views/_layouts/default');

        $about = (new SmpView(null, $this->view->data(), null))->render(BASE_PATH . '/Views/_includes/about');

//        $tags = $this->getCache()->get('__tags__');
//        if ($tags === false) {
            $tags = (new SmpView(null, $this->view->data(), null))->render(BASE_PATH . '/Views/_includes/recently',
                ['__tags__' => (new Tags())->getAllTags()]);
//            $this->getCache()->set('__tags__', $tags);
//        }

        $weibo = (new SmpView(null, $this->view->data(), null))->render(BASE_PATH . '/Views/_includes/weibo');
        $comment = (new SmpView(null, $this->view->data(), null))->render(BASE_PATH . '/Views/_includes/recent-comment');

        $relatedPosts = (new SmpView(null, $this->view->data(), null))->render(BASE_PATH . '/Views/_includes/related-posts');

        $this->view->assign('__sidebars__', [
            $about,
            $tags,
            $relatedPosts,
            $weibo,
            $comment
        ]);
        $navTrees = $this->getCache()->get('__nav__');
        if ($navTrees === false) {
            $navTrees = (new SmpView(
                null,
                ['__navigator__'=> (new Navigator())->getNavTrees(0, 'top')],
                null
            ))->render(BASE_PATH . '/Views/_includes/navigator', $this->view->data());
            $this->getCache()->set('__nav__', $navTrees);
        }
        $this->view->assign('__nav__', $navTrees);

        return $this->view;
    }

    /**
     * @return Cache
     */
    protected function getCache() {
        return $this->getContainer()->get(Cache::class);
    }
} 