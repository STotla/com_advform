<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_advform
 *
 * @copyright   Copyright (C) 2026 Sam Web Technologies. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\CategoryFactory;
use Joomla\CMS\HTML\Registry;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use SamWebTechnologies\Component\Advform\Administrator\Extension\AdvformComponent;

/**
 * The advform service provider.
 *
 * @since  1.0.0
 */
return new class () implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function register(Container $container): void
    {
        $container->registerServiceProvider(new CategoryFactory('\\SamWebTechnologies\\Component\\Advform'));
        $container->registerServiceProvider(new MVCFactory('\\SamWebTechnologies\\Component\\Advform'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\SamWebTechnologies\\Component\\Advform'));

        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new AdvformComponent($container->get(ComponentDispatcherFactoryInterface::class));
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));

                return $component;
            }
        );
    }
};
