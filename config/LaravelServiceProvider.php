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
* @package   Config
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2015 Jake Johns
* @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
* @link      http://jakejohns.net
 */



namespace Jnjxp\Meta\_Config;

use \Jnjxp\Meta\MetaHelperFactory;
use \Illuminate\Support\ServiceProvider;

/**
 * LaravelServiceProvider
 *
 * @category Meta
 * @package  Config
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 */
class LaravelServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['aura/html:helper'] = $this->app->share(
            function ($app) {
                $app;
                $factory = new \Aura\Html\HelperLocatorFactory;
                return $factory->newInstance();
            }
        );

        $this->app['aura/html:escaper'] = $this->app->share(
            function ($app) {
                $app;
                $factory = new \Aura\Html\EscaperFactory();
                return $factory->newInstance();
            }
        );

        $this->app['jnjxp/meta:helper'] = $this->app->share(
            function ($app) {
                $factory = new MetaHelperFactory(
                    $app->make('aura/html:helper'),
                    $app->make('aura/html:escaper')
                );
                return $factory->newInstance();
            }
        );

        $this->app->booting(
            function () {
                $loader = \Illuminate\Foundation\AliasLoader::getInstance();
                $loader->alias('AuraHtml', 'Jnjxp\Meta\Facades\AuraHtmlHelper');
                $loader->alias('Meta', 'Jnjxp\Meta\Facades\MetaHelper');
            }
        );
    }

}


