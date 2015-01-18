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
* @package   Tests
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace Jnjxp\Meta\Helper;

/**
 * RobotsTest
 *
 * @category Meta
 * @package  Tests
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class RobotsTest extends AbstractHelperTest
{

    /**
    * testArray
    *
    * @return mixed
    *
    * @access public
    */
    public function testArray()
    {
        $val = 'index, nofollow';

        $expected = [
            'name'    => 'robots',
            'content' => $val,
        ];

        $this->helper->setValue($val);
        $this->assertEquals(
            $expected,
            $this->helper->toArray()
        );
    }

    /**
    * testExtra
    *
    * @return mixed
    *
    * @access public
    */
    public function testExtra()
    {
        $val = 'index, follow, nocache';

        $this->helper->setValue($val);

        $expected = [
            'name'    => 'robots',
            'content' => $val
        ];

        $this->assertEquals(
            $expected,
            $this->helper->toArray()
        );
    }

    /**
    * testHelperMethods
    *
    * @return mixed
    *
    * @access public
    */
    public function testHelperMethods()
    {
        $helper = $this->helper;

        $helper->noIndex();
        $this->assertEquals(
            'noindex, follow',
            $this->helper->toArray()['content']
        );

        $helper->index();
        $this->assertEquals(
            'index, follow',
            $this->helper->toArray()['content']
        );

        $helper->noFollow();
        $this->assertEquals(
            'index, nofollow',
            $this->helper->toArray()['content']
        );

        $helper->follow();
        $this->assertEquals(
            'index, follow',
            $this->helper->toArray()['content']
        );
    }

}

