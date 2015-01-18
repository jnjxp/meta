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
 * MetaPropertyTraitTest
 *
 * @category Meta
 * @package  Tests
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class MetaPropertyTraitTest extends AbstractHelperTest
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
            'setValue' => 'foo',
            'clearValue' => null,
            'setDefault' => 'foo',
            'clearDefault' => null,
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
        $this->assertNull(
            $this->helper->getValue(),
            'Value dies not init null'
        );

        $this->assertNull(
            $this->helper->getDefault(),
            'Default does not init null'
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
        $setValue = 'set';
        $defaultValue = 'default';

        $this->helper->setDefault($defaultValue);

        $this->assertSame(
            $this->helper->getValue(),
            $defaultValue,
            'Does not return default value'
        );

        $this->helper->setValue($setValue);

        $this->assertSame(
            $this->helper->getValue(),
            $setValue,
            'Does not return set value'
        );

        $this->helper->clearValue();

        $this->assertSame(
            $this->helper->getValue(),
            $defaultValue,
            'Does not clear value'
        );

        $this->helper->clearDefault();

        $this->assertNull(
            $this->helper->getValue(),
            'Does not clear default'
        );
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
        $value = 'foo';
        $helper = $this->helper;
        $helper($value);
        $this->assertEquals(
            $value,
            $helper->getValue()
        );
        $helper->clearValue();
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
        $value = 'foo';
        $expected = ['content' => $value];
        $this->helper->setValue($value);
        $this->assertEquals(
            $expected,
            $this->helper->toArray()
        );
        $this->helper->clearValue();
    }

    /**
    * testNullProcess
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
        $aura = $this->getMockAuraMetas();
        $aura->expects($this->once())
            ->method('add');

        $helper = $this->getMockBuilder(
            '\Jnjxp\Meta\Helper\Traits\MetaPropertyTrait'
        )->setConstructorArgs([$aura])
            ->getMockForTrait();

        $helper('foo');
        $helper->process();
        $this->assertTrue($helper->isProcessed());
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
        $aura = $this->getMockAuraMetas();
        return $this->getMockBuilder('\Jnjxp\Meta\Helper\Traits\MetaPropertyTrait')
            ->setConstructorArgs([$aura])
            ->getMockForTrait();
    }

}

