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
 * AbstractHelperTest
 *
 * @category Meta
 * @package  Tests
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 * @see      PHPUnit_Framework_TestCase 
 * @abstract
 */
abstract class AbstractHelperTest extends \PHPUnit_Framework_TestCase
{
    protected $helper;

    /**
    * setUp
    *
    * @return mixed
    *
    * @access protected
    */
    protected function setUp()
    {
         parent::setUp();
         $this->helper = $this->newHelper();
    }

    /**
    * getMockAuraMetas
    *
    * @return mixed
    *
    * @access protected
    */
    protected function getMockAuraMetas()
    {
        $escaper = $this->getMockAuraEscaper();

        $metas = $this->getMockBuilder('\Aura\Html\Helper\Metas')
            ->setConstructorArgs([$escaper])
            ->getMock();

        return $metas;
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

        $html = $this->getMockBuilder('\Aura\Html\Escaper\HtmlEscaper')
            ->setConstructorArgs([null, null])
            ->getMock();

        $attr = $this->getMockBuilder('\Aura\Html\Escaper\AttrEscaper')
            ->setConstructorArgs([$html, null])
            ->getMock();

        $css = $this->getMockBuilder('\Aura\Html\Escaper\CssEscaper')
            ->setConstructorArgs([null])
            ->getMock();

        $jse = $this->getMockBuilder('\Aura\Html\Escaper\JsEscaper')
            ->setConstructorArgs([null])
            ->getMock();


        $escaper = $this->getMockBuilder('Aura\Html\Escaper')
            ->setConstructorArgs([$html, $attr, $css, $jse])
            ->getMock();

        return $escaper;
    }

    /**
    * isFluent
    *
    * @param mixed $fluent actual object
    * @param mixed $msg    msg to display
    *
    * @return mixed
    *
    * @access protected
    */
    protected function isFluent($fluent, $msg = null)
    {
        $this->assertSame(
            $fluent,
            $this->helper,
            $msg
        );
    }

    /**
    * resetHelper
    *
    * @return mixed
    *
    * @access protected
    */
    protected function resetHelper()
    {
        $this->helper->clearValue();
        $this->helper->clearDefault();
        $this->helper->setProcessed(false);
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
        $class = substr(get_class($this), 0, -4);
        return new $class($this->getMockAuraMetas());
    }
}

