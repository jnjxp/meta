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

use Aura\Html\Escaper;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * ContainerClass
 *
 * @category Meta
 * @package  Helper
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class ContainerClass
{
    const DEFAULT_PREFIX = 'extra';
    const PREFIX_KEY     = 'prefix';
    const CLASS_KEY      = 'classes';

    const SEP_MINOR  = '-';
    const SEP_MAJOR  = '_';
    const SEP_MULTI  = 2;

    const ID_PREFIX  = 'id';

    protected $escaper;

    protected $components;

    /**
    * __construct
    *
    * @param Escaper $escaper Auta\Html Escaper
    *
    * @access public
    */
    public function __construct(Escaper $escaper)
    {
        $this->escaper = $escaper;
        $this->components = new Collection();
    }

    /**
    * getComponents
    *
    * @return Collection
    *
    * @access public
    */
    public function getComponents()
    {
        return $this->components;
    }

    /**
    * __invoke
    *
    * @param mixed  $classes Classes to add
    * @param string $prefix  Namespace for group of classes
    * @param bool   $path    Treat like a path or like properties?
    *
    * @return ContainerClass
    *
    * @access public
    */
    public function __invoke($classes = null, $prefix = null, $path = false)
    {
        if ($classes) {
            $this->add($classes, $prefix, $path);
        }
        return $this;
    }

    /**
    * add
    *
    * @param mixed  $classes Classes to add string|array|object|closure
    * @param string $prefix  String to prefix all classes with
    * @param bool   $path    Treat as path or properties
    *
    * @return ContainerClass
    *
    * @access public
    */
    public function add($classes, $prefix = null, $path = false)
    {
        $prefix = $this->fixString(($prefix ? $prefix : static::DEFAULT_PREFIX));

        $this->getComponents()->push(
            (object) [
                static::PREFIX_KEY => $prefix,
                static::CLASS_KEY  => $this->fixClasses($prefix, $classes, $path)
            ]
        );

        return $this;
    }

    /**
    * fixClasses
    *
    * @param string $prefix  String to prefix with
    * @param mixed  $classes Data to build classes from
    * @param bool   $path    Treat as path or properties
    *
    * @return Collection
    *
    * @access protected
    */
    protected function fixClasses($prefix, $classes, $path = false)
    {
        $classes = value($classes);

        if (is_string($classes)) {
            $classes = explode(' ', $classes);
        }

        return Collection::make($classes)
            ->map($this->getBuilder($prefix, $path))
            ->flatten();
    }

    /**
    * getBuilder
    *
    * @param string $prefix Namespace for classes
    * @param bool   $path   Get path builder or property builder?
    *
    * @return Closure
    *
    * @access protected
    */
    protected function getBuilder($prefix, $path = false)
    {
        return (
            $path
            ? $this->getPathBuilder($prefix)
            : $this->getPropertyBuilder($prefix)
        );
    }

    /**
    * getPathBuilder
    *
    * @param string $prefix Namespace for classes
    *
    * @return Closure
    *
    * @access protected
    */
    protected function getPathBuilder($prefix)
    {
        return function ($value) use (&$prefix) {
            $prefix .= static::SEP_MAJOR . $this->fixString($value);
            return $prefix;
        };
    }

    /**
    * getPropertyBuilder
    *
    * @param string $prefix Namespace for classes
    *
    * @return Closure
    *
    * @access protected
    */
    protected function getPropertyBuilder($prefix)
    {
        $build = function ($value, $key, $sub = null) use (&$prefix, &$build) {
            $sub = ($sub ? $sub : $prefix);

            if (!is_numeric($key)) {
                $sub .= static::SEP_MAJOR . $this->fixString($key);
            }

            if (is_array($value)) {
                return array_map(
                    $build,
                    $value,
                    array_keys($value),
                    array_fill(0, count($value), $sub)
                );
            }

            $sep = (
                $prefix === $sub
                ? static::SEP_MINOR
                : str_repeat(static::SEP_MAJOR, static::SEP_MULTI)
            );

            return $sub . $sep . $this->fixString($value);
        };

        return $build;
    }

    /**
    * fixString
    *
    * @param mixed $value String to fix
    *
    * @return mixed
    *
    * @access protected
    */
    protected function fixString($value)
    {
        if (is_numeric($value)) {
            $value = [static::ID_PREFIX, $value];
        }

        if (is_array($value)) {
            $value = implode(static::SEP_MINOR, $value);
        }

        if (in_array($value, [false, true, null], true)) {
            return strtolower(var_export($value, true));
        }

        return Str::slug($value, static::SEP_MINOR);
    }


    /**
    * getClassString
    *
    * @param mixed $include components to include false for none
    *
    * @return string
    *
    * @access public
    */
    public function getClassString($include = null)
    {
        return (
            ( false === $include ) ? ''
            : implode(
                ' ',
                $this->getClassCollection($include)->all()
            )
        );
    }

    /**
    * getClassCollection
    *
    * @param mixed $include DESCRIPTION
    *
    * @return Collection
    *
    * @access public
    */
    public function getClassCollection($include = null)
    {
        if (false === $include) {
            return Collection::make([]);
        }

        $components = $this->getComponents();

        if ($include) {
            $components = $components->filter(
                function ($component) use ($include) {
                    return in_array($component->prefix, (array) $include);
                }
            );
        }

        $escaper = function ($class) {
            return $this->escaper->attr($class);
        };

        return $components->fetch(static::CLASS_KEY)
            ->collapse()
            ->transform($escaper)
            ->unique();
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
        $string = $this->getClassString();
        $this->components = new Collection();
        return $string;
    }

}


