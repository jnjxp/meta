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
 * TitleTest
 *
 * @category Meta
 * @package  Tests
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class TitleTest extends AbstractHelperTest
{

    /**
    * testString
    *
    * @return mixed
    *
    * @access public
    */
    public function testAll()
    {
        $helper = $this->helper;
        $this->assertSame(
            $helper('Foo'),
            $this->helper
        );

        $helper->setIncludeSiteName(true);
        $helper->setIncludeMeta(true);

        $this->assertSame(
            $this->helper->setSiteTitle('Site'),
            $this->helper
        );

        $this->assertSame(
            $this->helper->setTitleSeparator(' * '),
            $this->helper
        );

        $this->assertEquals(
            "    <title>Foo * Site</title>\n",
            (string) $this->helper
        );

    }



    /**
    * getMockMeta
    *
    * @return mixed
    *
    * @access protected
    */
    protected function getMockMeta()
    {
        $escaper = $this->getMockAuraEscaper();
        return $this->getMockBuilder('\Aura\Html\Helper\Metas')
            ->setConstructorArgs([$escaper])
            ->getMock();
    }

    /**
    * getMockTitle
    *
    * @return mixed
    *
    * @access protected
    */
    protected function getMockTitle()
    {
        $escaper = $this->getMockAuraEscaper();
        return $this->getMockBuilder('\Aura\Html\Helper\Title')
            ->setConstructorArgs([$escaper])
            ->getMock();
    }

    /**
    * newHelper
    *
    * @return mixed
    *
    * @access protected
    */
    protected function newHelper()
    {
        $eFac = new \Aura\Html\EscaperFactory();
        $esc = $eFac->newInstance();
        $metas = $this->getMockMeta();
        $title = new \Aura\Html\Helper\Title($esc);

        return new Title(
            $title,
            $metas,
            $esc
        );
    }

    /**
    * getMockAuraEscaper
    *
    * @return mixed
    *
    * @access protected
    */
    protected function getMockAuraEscaper()
    {
        $escaper = parent::getMockAuraEscaper();
        $escaper->expects($this->any())
            ->method('html')
            ->will(
                $this->returnCallback(
                    function () {
                        return func_get_args()[0];
                    }
                )
            );

        return $escaper;
    }

}

