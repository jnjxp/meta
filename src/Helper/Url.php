<?php
/**
* Jnjxp\Meta
*
* PHP version 5
*
* This program is free software: you can redistribute it and/or modify it
* under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or (at your
* option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @category  Meta
* @package   Helper
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace Jnjxp\Meta\Helper;


/**
 * Url
 *
 * @category Meta
 * @package  Helper
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class Url
{

    use Traits\MetaPropertyTrait;

    /**
    * isCli
    *
    * @return bool
    *
    * @access protected
    */
    protected function isCli()
    {
        return (bool) (php_sapi_name() == 'cli');
    }

    /**
    * initDefault
    *
    * @return string
    *
    * @access protected
    */
    protected function initDefault()
    {
        if ($this->isCli()) {
            return null;
        }

        $uri = (empty($_SERVER['HTTPS']) ? 'http' : 'https')
            . '://'
            . $_SERVER['HTTP_HOST']
            . $_SERVER['REQUEST_URI'];
        return  rtrim(preg_replace('/\?.*/', '', $uri), '/');
    }

    /**
    * toArray
    *
    * @return array
    *
    * @access public
    */
    public function toArray()
    {
        return [
            'property' => 'og:url',
            'content' => $this->getValue()
        ];
    }
}


