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
 * ContainerClassTest
 *
 * @category Meta
 * @package  Tests
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class ContainerClassTest extends AbstractHelperTest
{

    /**
    * testFoo
    *
    * @return mixed
    *
    * @access public
    */
    public function testPath()
    {
        $data = [
            'products',
            'read',
            13
        ];

        $prefix = 'request';

        $helper = $this->helper;
        $helper($data, $prefix, true);

        $expected = implode(
            ' ',
            [
                'request_products',
                'request_products_read',
                'request_products_read_id-13',
            ]
        );

        $this->assertEquals(
            $expected,
            $helper->__toString()
        );
    }

    /**
    * testProperties
    *
    * @return mixed
    *
    * @access public
    */
    public function testProperties()
    {
        $data = [
            'title' => 'Foo Bar',
            'status' => [
                'pub'   => false,
                'draft' => true,
                'star'  => null
            ]
        ];

        $prefix = 'article';

        $helper = $this->helper;
        $helper($data, $prefix);

        $expected = implode(
            ' ',
            [
                'article_title__foo-bar',
                'article_status_pub__false',
                'article_status_draft__true',
                'article_status_star__null'
            ]
        );

        $this->assertEquals(
            $expected,
            $helper->__toString()
        );
    }

    /**
    * testTakesString
    *
    * @return mixed
    *
    * @access public
    */
    public function testTakesString()
    {

        $helper = $this->helper;
        $helper('special classes');

        $expected = implode(
            ' ',
            [
                'extra-special',
                'extra-classes'
            ]
        );

        $this->assertEquals(
            $expected,
            $helper->__toString()
        );
    }

    /**
    * testInclude
    *
    * @return mixed
    *
    * @access public
    */
    public function testInclude()
    {

        $helper = $this->helper;
        $helper('special classes');
        $helper('other stuff', 'other');

        $expected = implode(
            ' ',
            [
                'extra-special',
                'extra-classes'
            ]
        );

        $this->assertEquals(
            $expected,
            $helper->getClassString('extra')
        );
    }

    /**
    * testEmptyIncludeCollection
    *
    * @return mixed
    *
    * @access public
    */
    public function testEmptyIncludeCollection()
    {

        $helper = $this->helper;
        $helper('special classes');
        $helper('other stuff', 'other');

        $expected = [];

        $this->assertEquals(
            $expected,
            $helper->getClassCollection(false)->all()
        );
    }


    /**
    * newHelper
    *
    * @return mixed
    *
    * @access public
    */
    public function newHelper()
    {
        $escaper = $this->getMockAuraEscaper();
        $escaper->expects($this->any())
            ->method('attr')
            ->will($this->returnArgument(0));

        return new ContainerClass($escaper);
    }

}

