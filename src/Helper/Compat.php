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
 * Compat
 *
 * @category Meta
 * @package  Helper
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class Compat
{

    use Traits\MetaPropertyTrait;

    /**
     * modes
     *
     * @var array
     * @access protected
     */
    protected $modes = [
        'IE=5',
        'IE=EmulateIE7',
        'IE=7',
        'IE=EmulateIE8',
        'IE=8',
        'IE=EmulateIE9',
        'IE=9',
        'IE=edge'
    ];

    /**
    * initDefault
    *
    * @return string
    *
    * @access protected
    */
    protected function initDefault()
    {
        return 'IE=edge';
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
            'http-equiv' => 'X-UA-Compatible',
            'content' => $this->getValue()
        ];
    }

    /**
    * isValid
    *
    * @param mixed $value Value to validate
    *
    * @return bool
    *
    * @access public
    */
    public function isValid($value)
    {
        return in_array($value, $this->modes);
    }

}


