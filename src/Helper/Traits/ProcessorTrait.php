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
* @package   Traits
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */

namespace Jnjxp\Meta\Helper\Traits;

use Jnjxp\Meta\Helper\Exceptions\MultiProcessException;
use Aura\Html\Helper\Metas;

trait ProcessorTrait
{

    /**
     * processed
     *
     * @var bool
     * @access protected
     */
    protected $processed = false;

    /**
    * isProcessed
    *
    * @return bool
    *
    * @access public
    */
    public function isProcessed()
    {
        return (bool) $this->processed;
    }

    /**
    * setProcessed
    *
    * @param bool $val Boolean value to set processed to
    *
    * @return ProcessorTrait
    *
    * @access public
    */
    public function setProcessed($val = true)
    {
        $this->processed = (bool) $val;
        return $this;
    }

    /**
    * process
    *
    * @return ProcessorTrait
    *
    * @access public
    */
    public function process()
    {
        if ($this->isProcessed()) {
            throw new MultiProcessException('Already Processed!');
        }

        if ($this->doProcess()) {
            $this->setProcessed(true);
        }

        return $this;
    }

    /**
    * doProcess
    *
    * @return mixed
    *
    * @access protected
    */
    abstract protected function doProcess();

}


