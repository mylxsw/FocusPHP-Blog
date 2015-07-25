<?php
/**
 * FocusPHP-Blog
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Models;


use Demo\Libraries\PDOAwareTrait;
use Focus\MVC\Model;

class Setting implements Model {

    use PDOAwareTrait;
    /**
     * Initialize the model
     *
     * @return void
     */
    public function init() {
        // TODO: Implement init() method.
    }

    public function getSetting($key, $namespace) {
        $sql = 'SELECT * FROM `ar_setting` WHERE isvalid=1 AND setting_key=:key AND namespace=:namespace';
        $stat = $this->getPDO()->prepare($sql);
        $stat->execute([
            ':key'  => $key,
            ':namespace'    => $namespace
        ]);

        $res = $stat->fetch(\PDO::FETCH_ASSOC);
        return $res;
    }
}