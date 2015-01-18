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

namespace Jnjxp\Meta\Helper\Traits;

use Jnjxp\Meta\Helper\Exception\MultiProcessException;
use Aura\Html\Helper\Metas;

trait MetaPropertyTrait
{
    use ProcessorTrait;

    /**
     * value
     *
     * @var mixed
     * @access protected
     */
    protected $value;

    /**
     * default
     *
     * @var mixed
     * @access protected
     */
    protected $default;

    /**
     * metas
     *
     * @var Aura\Html\Helper\Metas
     * @access protected
     */
    protected $metas;

    /**
    * __construct
    *
    * @param Metas $metas Aura.Html Metas Helper
    *
    * @access public
    */
    public function __construct(Metas $metas)
    {
        $this->metas = $metas;
        $this->setDefault($this->initDefault());
    }

    /**
    * initDefault
    *
    * @return mixed
    *
    * @access protected
    */
    protected function initDefault()
    {
        return null;
    }


    /**
    * setValue
    *
    * @param mixed $value value to set
    *
    * @return MetaPropertyTrait
    *
    * @access public
    */
    public function setValue($value)
    {
        if ($this->isValid($value)) {
            $this->value = $value;
        }
        return $this;
    }

    /**
    * isValid
    *
    * @param mixed $value value to validate
    *
    * @return bool
    *
    * @access public
    */
    public function isValid($value)
    {
        $value;
        return true;
    }

    /**
    * getValue
    *
    * @return mixed
    *
    * @access public
    */
    public function getValue()
    {
        return ($this->value === null ? $this->getDefault() : $this->value);
    }

    /**
    * clearValue
    *
    * @return MetaPropertyTrait
    *
    * @access public
    */
    public function clearValue()
    {
        $this->value = null;
        return $this;
    }

    /**
    * setDefault
    *
    * @param mixed $default value to set as default
    *
    * @return MetaPropertyTrait
    *
    * @access public
    */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
    * getDefault
    *
    * @return mixed
    *
    * @access public
    */
    public function getDefault()
    {
        return $this->default;
    }

    /**
    * clearDefault
    *
    * @return MetaPropertyTrait
    *
    * @access public
    */
    public function clearDefault()
    {
        $this->default = null;
        return $this;
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
        return ['content' => $this->getValue()];
    }

    /**
    * getPosition
    *
    * @return int
    *
    * @access protected
    */
    protected function getPosition()
    {
        return 100;
    }

    /**
    * doProcess
    *
    * @return bool
    *
    * @access protected
    */
    protected function doProcess()
    {
        if ($this->getValue()) {
            $this->metas->add($this->toArray(), $this->getPosition());
            return true;
        }
        return false;
    }

    /**
    * __invoke
    *
    * @param mixed $value value to set
    *
    * @return mixed
    *
    * @access public
    */
    public function __invoke($value = null)
    {
        if ($value !== null) {
            $this->setValue($value);
        }
        return $this;
    }

}


