<?php
/**
 * FocusPHP-Blog
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Libraries;


interface Cache {
    public function get($key);
    public function set($key, $value);
    public function delete($key);
    public function all($prefix = '');
} 