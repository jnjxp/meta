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
* @package   Meta
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */


namespace Jnjxp\Meta;

use Jnjxp\Support\Traits\HelpersTrait;
use Jnjxp\Support\Interfaces\HelpersInterface;


/**
 * MetaHelper
 *
 * @category Meta
 * @package  Meta
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 * @see      HelpersInterface
 */
class MetaHelper implements HelpersInterface
{

    use HelpersTrait;

    const TITLE    = 'title';
    const METAS    = 'metas';
    const LINKS    = 'links';
    const STYLES   = 'styles';
    const SCRIPTS  = 'scripts';
    const ROBOTS   = 'robots';
    const ICONS    = 'icons';
    const CHARSET  = 'charset';
    const COMPAT   = 'compat';
    const VIEWPORT = 'viewport';
    const URL      = 'url';
    const LOC      = 'locale';
    const DESC     = 'description';
    const IMG      = 'image';

    protected $defaults = [
        self::TITLE,
        self::METAS,
        self::LINKS,
        self::STYLES,
        self::SCRIPTS,
        self::ROBOTS,
        self::ICONS,
        self::CHARSET,
        self::COMPAT,
        self::VIEWPORT,
        self::URL,
        self::LOC,
        self::DESC,
        self::IMG
    ];

    /**
    * invoke
    *
    * @return MetaHelper
    *
    * @access public
    */
    public function __invoke()
    {
        return $this;
    }


    /**
    * head
    *
    * @param array $include components to include
    *
    * @return string
    *
    * @access public
    */
    public function head($include = null)
    {
        if (null === $include) {
            $include = $this->defaults;
        }

        $include = (array) $include;

        $this->process($include);

        return "\n"
            . ( in_array(self::METAS, $include)   ? $this->metas() : '')
            . ( in_array(self::TITLE, $include)   ? $this->title() : '')
            . ( in_array(self::LINKS, $include)   ? $this->links() : '')
            . ( in_array(self::STYLES, $include)  ? $this->styles() : '')
            . ( in_array(self::SCRIPTS, $include) ? $this->scripts() : '')
            ;
    }

    /**
    * process
    *
    * @param array $include components to process
    *
    * @return MetaHelper
    *
    * @access protected
    */
    protected function process(array $include)
    {
        $process = [
            self::TITLE,
            self::ROBOTS,
            self::ICONS,
            self::CHARSET,
            self::COMPAT,
            self::VIEWPORT,
            self::URL,
            self::LOC,
            self::DESC,
            self::IMG
        ];

        foreach ($include as $inc) {
            if (in_array($inc, $process)) {
                $this->{$inc}()->process();
            }
        }

        return $this;
    }

    /**
    * foot
    *
    * @return string
    *
    * @access public
    */
    public function foot()
    {
        return "\n"
            . $this->scriptsFoot();
    }


}

