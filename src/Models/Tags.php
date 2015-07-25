<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Models;


use Demo\Libraries\PDOAwareTrait;
use Focus\MVC\Model;

class Tags implements Model {

    use PDOAwareTrait;
    /**
     * Initialize the model
     *
     * @return void
     */
    public function init() {}

    /**
     * 查询所有tags
     *
     * @return array
     */
    public function getAllTags() {
        $stat = $this->getPDO()->query('SELECT id, name FROM `ar_tag` WHERE isvalid=1');
        return $stat->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 根据标签名获取单个标签信息
     *
     * @param $tagName
     *
     * @return mixed
     */
    public function getTagByName($tagName) {
    
        $stat = $this->getPDO()->prepare('SELECT id, name FROM `ar_tag` WHERE isvalid=1 AND name=:name');
        $stat->execute([':name'=> $tagName]);
        
        return $stat->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * 获取多个tag名称对应的标签信息
     *
     * @param array $tagNames
     *
     * @return array
     */
    public function getTagsByNames(array $tagNames) {
        if (empty($tagNames)) {
            return [];
        }

        $placeHolders = implode(',', array_fill(0, count($tagNames), '?'));
        $stat = $this->getPDO()->prepare("SELECT id, name FROM `ar_tag` WHERE isvalid=1 AND name in ({$placeHolders})");
        $stat->execute($tagNames);
        return $stat->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 根据文章ID获取所有标签
     *
     * @param $id
     *
     * @return array
     */
    public function getTagsByPostId($id) {
        $sql = "SELECT id, name FROM `ar_tag`
                WHERE isvalid=1 AND id IN (
                SELECT tag_id FROM `ar_article_tag` WHERE article_id = :id)";

        $stat = $this->getPDO()->prepare($sql);
        $stat->execute([':id'=> $id]);

        return $stat->fetchAll(\PDO::FETCH_ASSOC);
    }

}