<?php
/**
* HeadMeta
*
* PHP version 5
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @category  HeadMEta
* @package   Tests
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2014 Jake Johns
* @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
* @link      http://jakejohns.net
 */


namespace Jnjxp\Meta\Helper;

// @codingStandardsIgnoreStart
/**
* php_sapi_name
*
* @return mixed
* @throws exceptionclass [description]
*
* @access
*/
function php_sapi_name()
{
    return UrlTest::$sapi;
}
// @codingStandardsIgnoreEnd


/**
 * UrlTest
 *
 * @category Meta
 * @package  Tests
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class UrlTest extends AbstractHelperTest
{

    public static $sapi;

    /**
    * setUp
    *
    * @return mixed
    *
    * @access public
    */
    public function setUp()
    {
        global $_SERVER;
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['REQUEST_URI'] = '/test';
        parent::setUp();
    }

    /**
    * testArray
    *
    * @return mixed
    *
    * @access public
    */
    public function testArray()
    {
        self::$sapi = 'cli';
        $this->helper = $this->newHelper();

        $val = 'http://example.com';

        $expected = [
            'property' => 'og:url',
            'content' => $val
        ];

        $this->helper->setValue($val);
        $this->assertEquals(
            $expected,
            $this->helper->toArray()
        );
    }

    /**
    * testArray
    *
    * @return mixed
    *
    * @access public
    */
    public function testArray2()
    {
        self::$sapi = 'web';
        $this->helper = $this->newHelper();

        $expected = [
            'property' => 'og:url',
            'content' => 'http://example.com/test'
        ];

        $this->assertEquals(
            $expected,
            $this->helper->toArray()
        );
    }



}

