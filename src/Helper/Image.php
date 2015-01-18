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

namespace Jnjxp\Meta\Helper;

use Aura\Html\Helper\Links as AuraLinks;
use Aura\Html\Helper\Metas as AuraMeta;

/**
 * Image
 *
 * @category Meta
 * @package  Helper
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class Image
{

    use Traits\ProcessorTrait;

    /**
     * links
     *
     * @var AuraLinks
     * @access protected
     */
    protected $links;

    /**
     * meta
     *
     * @var AuraMeta
     * @access protected
     */
    protected $meta;

    /**
     * value
     *
     * @var string
     * @access protected
     */
    protected $value;

    /**
    * __construct
    *
    * @param AuraMeta  $meta  Aura.Html Meta Helper
    * @param AuraLinks $links Aura.Html Links Helper
    *
    * @access public
    */
    public function __construct(AuraMeta $meta, AuraLinks $links)
    {
        $this->links = $links;
        $this->meta = $meta;
    }

    /**
    * __invoke
    *
    * @param string $val URL path to image
    *
    * @return mixed
    *
    * @access public
    */
    public function __invoke($val = null)
    {
        if ($val) {
            $this->setValue($val);
        }
        return $this;
    }

    /**
    * setValue
    *
    * @param string $value URL Path to image
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function setValue($value)
    {
        $this->value = $value;
    }


    /**
    * doProcess
    *
    * @return bool
    *
    * @access public
    */
    protected function doProcess()
    {
        $links = $this->links;
        $meta = $this->meta;

        if ($this->value) {
            $links->add(
                [
                    'rel'  => 'image_src',
                    'href' => $this->value
                ]
            );
            $meta->add(
                [
                    'name' => 'image',
                    'property' => 'og:image',
                    'content' => $this->value
                ]
            );
        }

        return true;
    }

}
