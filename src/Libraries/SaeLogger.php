<?php
/**
 * FocusPHP-Blog
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Libraries;


use Focus\Log\Logger;

class SaeLogger extends Logger {
    public function log( $level, $message, array $context = array() ) {
        if (function_exists('sae_debug')) {
            sae_debug("{$level} - {$message}");
        }
    }
}