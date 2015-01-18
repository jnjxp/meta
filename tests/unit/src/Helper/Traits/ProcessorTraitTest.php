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

namespace Jnjxp\Meta\Helper\Traits;
use Jnjxp\Meta\Helper\AbstractHelperTest;

/**
 * ProcessorTraitTest
 *
 * @category Meta
 * @package  Tests
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class ProcessorTraitTest extends AbstractHelperTest
{

    /**
    * testFluentInterface
    *
    * @return mixed
    *
    * @access public
    */
    public function testFluentInterface()
    {
        $cmds = [
            'setProcessed' => true,
            'process' => null
        ];

        foreach ($cmds as $cmd => $arg) {
             $this->resetHelper();
             $this->isFluent(
                 call_user_func([$this->helper, $cmd], $arg),
                 sprintf('%s is not fluent', $cmd)
             );
             $this->resetHelper();
        }
    }

    /**
    * testInitialState
    *
    * @return mixed
    *
    * @access public
    */
    public function testInitialState()
    {
        $this->assertFalse(
            $this->helper->isProcessed(),
            'Processed does not init false'
        );
    }

    /**
    * testValues
    *
    * @return mixed
    *
    * @access public
    */
    public function testValues()
    {
        $this->helper->setProcessed();

        $this->assertTrue(
            $this->helper->isProcessed(),
            'Does not set processed true'
        );

        $this->helper->setProcessed(false);

        $this->assertFalse(
            $this->helper->isProcessed(),
            'Does not set processed false'
        );
    }

    /**
    * testMultiprocessException
    *
    * @return mixed
    * @throws Jnjxp\Meta\Helper\Exceptions\MultiProcessException for multi
    *
    * @access public
    */
    public function testMultiprocessException()
    {
        $this->setExpectedException(
            'Jnjxp\Meta\Helper\Exceptions\MultiProcessException'
        );
        $this->helper->setProcessed();
        $this->helper->process();
        $this->helper->setProcessed(false);
    }

    /**
    * testProcess
    *
    * @return mixed
    *
    * @access public
    */
    public function testNullProcess()
    {
        $this->helper->process();
        $this->assertFalse($this->helper->isProcessed());
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
        $helper = $this->getMockBuilder('\Jnjxp\Meta\Helper\Traits\ProcessorTrait')
            ->getMockForTrait();

        $helper->expects($this->once())
            ->method('doProcess')
            ->will($this->returnValue(true));

        $helper->process();
        $this->assertTrue($helper->isProcessed());
    }

    /**
    * resetHelper
    *
    * @return mixed
    *
    * @access public
    */
    public function resetHelper()
    {
        $this->helper->setProcessed(false);
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
        return $this->getMockBuilder('\Jnjxp\Meta\Helper\Traits\ProcessorTrait')
            ->getMockForTrait();
    }

}

