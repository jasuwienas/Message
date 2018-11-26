<?php

namespace Jasuwienas\MessageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\Kernel;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MessageExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $parameters = [
            'queue_object_class',
            'smtp_mailer_user',
            'smtp_mailer_sender',
            'freshmail_api_host',
            'freshmail_api_prefix',
            'freshmail_api_api_key',
            'freshmail_api_secret_key',
            'sms_api_host',
            'sms_api_access_token',
        ];
        foreach ($parameters as $parameter) {
            $container->setParameter(
                'message.'.$parameter,
                array_key_exists($parameter, $config) ? $config[$parameter] : null
            );
        }
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $symfonyVersion = Kernel::VERSION;
        $loader->load(
            (int) $symfonyVersion[0] === 4 ? 'services.yaml' : 'services.yml'
        );
    }
}
