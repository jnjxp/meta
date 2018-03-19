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

use Aura\Html\Helper\Title as AuraTitle;
use Aura\Html\Helper\Metas as AuraMetas;
use Aura\Html\Escaper;

/**
 * Title
 *
 * @category Meta
 * @package  Helper
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class Title
{
    use Traits\ProcessorTrait;

    /**
     * auraTitle
     *
     * @var AuraTitle
     * @access protected
     */
    protected $auraTitle;

    /**
     * auraMetas
     *
     * @var AuraMetas
     * @access protected
     */
    protected $auraMetas;

    /**
     * escaper
     *
     * @var Escaper
     * @access protected
     */
    protected $escaper;

    /**
     * titles
     *
     * @var array
     * @access protected
     */
    protected $titles = array();

    /**
     * siteTitle
     *
     * @var string
     * @access protected
     */
    protected $siteTitle = '';

    /**
     * titleSeparator
     *
     * @var string
     * @access protected
     */
    protected $titleSeparator = ' - ';

    /**
     * includeMeta
     *
     * @var bool
     * @access protected
     */
    protected $includeMeta = true;

    /**
     * includeSiteName
     *
     * @var bool
     * @access protected
     */
    protected $includeSiteName = true;


    /**
    * __construct
    *
    * @param AuraTitle $title   Aura.Html Title Helper
    * @param AuraMetas $metas   Aure.Html Metas Helper
    * @param Escaper   $escaper Aura.Html Escaper
    *
    * @access public
    */
    public function __construct(AuraTitle $title, AuraMetas $metas, Escaper $escaper)
    {
        $this->auraTitle = $title;
        $this->auraMeta = $metas;
        $this->escaper = $escaper;
    }

    /**
    * __invoke
    *
    * @param mixed $title title to add
    *
    * @return Title
    *
    * @access public
    */
    public function __invoke($title = null)
    {
        if ($title) {
            $this->addTitle($title);
        }
        return $this;
    }

    /**
    * __toString
    *
    * @return string
    *
    * @access public
    */
    public function __toString()
    {
        if (! $this->isProcessed()) {
            $this->process();
        }
        $auraTitle = $this->auraTitle;
        return (string) $auraTitle();
    }

    /**
    * getMetaArray
    *
    * @param string $title Title to get meta array for
    *
    * @return array
    *
    * @access protected
    */
    protected function getMetaArray($title)
    {
        return [
            'name' => 'title',
            'property' => 'og:title',
            'content' => $title
        ];
    }

    /**
    * getSiteNameArray
    *
    * @return array
    *
    * @access protected
    */
    protected function getSiteNameArray()
    {
        return [
            'property' => 'og:site_name',
            'content' => $this->siteTitle
        ];
    }

    /**
    * doProcess
    *
    * @return bool
    *
    * @access public
    */
    public function doProcess()
    {
        $title = $this->getTitleString();

        $this->auraTitle->set($title);

        if ($this->includeMeta) {
            $this->auraMeta->add($this->getMetaArray($title));
        }
        if ($this->includeSiteName) {
            $this->auraMeta->add($this->getSiteNameArray());
        }

        return true;
    }

    /**
    * setIncludeSiteName
    *
    * @param bool $val include site name tag?
    *
    * @return Title
    *
    * @access public
    */
    public function setIncludeSiteName($val)
    {
        $this->includeSiteName = (bool) $val;
        return $this;
    }

    /**
    * setIncludeMeta
    *
    * @param bool $val include meta tag?
    *
    * @return Title
    *
    * @access public
    */
    public function setIncludeMeta($val)
    {
        $this->includeMeta = (bool) $val;
        return $this;
    }

    /**
    * setSiteTitle
    *
    * @param string $txt site title
    *
    * @return Title
    *
    * @access public
    */
    public function setSiteTitle($txt)
    {
        $this->siteTitle = $txt;
        return $this;
    }

    /**
    * setTitleSeparator
    *
    * @param string $string title part separator
    *
    * @return Title
    *
    * @access public
    */
    public function setTitleSeparator($string)
    {
        $this->titleSeparator = $string;
        return $this;
    }

    /**
    * getTitleString
    *
    * @return string
    *
    * @access public
    */
    public function getTitleString()
    {
        $sep = $this->titleSeparator;
        $raw = trim(
            implode(
                $sep,
                [
                    implode($sep, $this->titles),
                    $this->siteTitle
                ]
            ),
            $sep
        );
        return $raw;
    }

    /**
    * title
    *
    * @param string $string title part to add
    *
    * @return Title
    *
    * @access public
    */
    public function addTitle($string)
    {
        array_unshift($this->titles, $string);
        return $this;
    }

}

