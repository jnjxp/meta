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
 * IconsTest
 *
 * @category Meta
 * @package  Tests
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class IconsTest extends AbstractHelperTest
{

    /**
    * setUp
    *
    * @return mixed
    *
    * @access public
    */
    public function setUp()
    {
        parent::setUp();
        $this->favicon = 'favicon';
        $this->sizes = [1];
        $this->pattern = 'size:%s';

        $this->sizeArray = [
            'rel' => 'apple-touch-icon-precomposed',
            'sizes' => '1x1',
            'href' => 'size:1'
        ];

        $this->favArray = [
            ['rel'  => 'icon', 'href' => 'favicon'],
            ['rel'  => 'shortcut icon', 'href' => 'favicon']
        ];
    }

    /**
    * testInvoke
    *
    * @return mixed
    *
    * @access public
    */
    public function testInvoke()
    {
        $helper = $this->helper;
        $this->assertSame(
            $helper(),
            $this->helper
        );
    }

    /**
    * testSetters
    *
    * @return mixed
    *
    * @access public
    */
    public function testSetters()
    {
        $this->assertSame(
            $this->helper->setTouchSizes($this->sizes),
            $this->helper
        );

        $this->assertSame(
            $this->helper->setTouchPattern($this->pattern),
            $this->helper
        );

        $this->assertSame(
            $this->helper->setFavicon($this->favicon),
            $this->helper
        );

        return $this->helper;
    }

    /**
    * testGetters
    *
    * @param mixed $helper the helper
    *
    * @return mixed
    *
    * @access public
    * @depends testSetters
    */
    public function testGetters($helper)
    {
        $this->assertEquals(
            $helper->getTouchSizes(),
            $this->sizes
        );

        $this->assertEquals(
            $helper->getTouchPattern(),
            $this->pattern
        );

        $this->assertEquals(
            $helper->getFavicon(),
            $this->favicon
        );

        $this->assertEquals(
            [$this->sizeArray],
            $helper->getTouchArray()
        );
        return $helper;
    }

    /**
    * testProcess
    *
    * @return mixed
    *
    * @access public
    */
    public function testProcess()
    {
        $escaper = $this->getMockAuraEscaper();
        $links = $this->getMockBuilder('\Aura\Html\Helper\Links')
            ->setConstructorArgs([$escaper])
            ->getMock();

        $links->expects($this->exactly(3))
            ->method('add')
            ->withConsecutive(
                [$this->equalTo($this->sizeArray)],
                [$this->equalTo($this->favArray[0])],
                [$this->equalTo($this->favArray[1])]
            );

        $helper = new Icons($links);

        $helper->setTouchSizes($this->sizes);
        $helper->setTouchPattern($this->pattern);
        $helper->setFavicon($this->favicon);

        $ret = $helper->process();

        $this->assertSame(
            $ret,
            $helper
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
        $links = $this->getMockBuilder('\Aura\Html\Helper\Links')
            ->setConstructorArgs([$escaper])
            ->getMock();

        return new Icons($links);
    }

}

