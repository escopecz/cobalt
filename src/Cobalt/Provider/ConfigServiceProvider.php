<?php
/**
 * @package    Cobalt.CRM
 *
 * @copyright  Copyright (C) 2013 Webspark, LLC. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Cobalt\Provider;

use JConfig;
use Cobalt\Container;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $config = new JConfig;

        // Set the error_reporting
        switch ($config->error_reporting) {
            case 'default':
            case '-1':
                break;

            case 'none':
            case '0':
                error_reporting(0);
                break;

            case 'simple':
                error_reporting(E_ERROR | E_WARNING | E_PARSE);
                ini_set('display_errors', 1);
                break;

            case 'maximum':
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                break;

            case 'development':
                error_reporting(-1);
                ini_set('display_errors', 1);
                break;

            default:
                error_reporting($config->error_reporting);
                ini_set('display_errors', 1);
                break;
        }

        define('JDEBUG', $config->debug);

        $container->bind('config', function () use ($config) {
                return $config;
            });
    }
}