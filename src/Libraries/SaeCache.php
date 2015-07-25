<?php
/**
 * FocusPHP-Blog
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Libraries;


class SaeCache implements Cache {

    private $_kvdb;

    public function __construct() {
        $this->_kvdb = new \SaeKV();
        $this->_kvdb->init();
    }

    public function set($key, $val) {
        if ($this->_kvdb->get($key) === false) {
            $this->_kvdb->add($key, $val);
        } else {
            $this->_kvdb->set($key, $val);
        }
    }

    public function get($key) {
        return $this->_kvdb->get($key);
    }

    public function delete($key) {
        return $this->_kvdb->delete($key);
    }


    public function all( $prefix = '' ) {
        return $this->_kvdb->pkrget($prefix, 100);
    }
}