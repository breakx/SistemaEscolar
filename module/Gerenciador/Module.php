<?php
/**
 * namespace para nosso modulo gerenciadores
 */
namespace Gerenciador;

// import Gerenciador\Model
use Gerenciador\Model\Gerenciador,
    Gerenciador\Model\GerenciadorTable;

// import Zend\Db
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class Module
{
    /**
     * include de arquivo para outras configuracoes desse modulo
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * autoloader para nosso modulo
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Register View Helper
     */
    public function getViewHelperConfig()
    {
        return array(
            # registrar View Helper com injecao de dependecia
            'factories' => array(
                'menuAtivo'  => function($sm) {
                    return new View\Helper\MenuAtivo($sm->getServiceLocator()->get('Request'));
                },
                'message' => function($sm) {
                    return new View\Helper\Message($sm->getServiceLocator()->get('ControllerPluginManager')->get('flashmessenger'));
                },
            ),
            'invokables' => array(
                'filter_gerenciador' => 'Gerenciador\View\Helper\GerenciadorFilter'
            )
        );
    }

    /**
     * Register Services
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'GerenciadorTableGateway' => function ($sm) {
                    // obter adapter db atraves do service manager
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');

                    // configurar ResultSet com nosso model Gerenciador
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Gerenciador());

                    // return TableGateway configurado para nosso model Gerenciador
                    return new TableGateway('gerenciadores', $adapter, null, $resultSetPrototype);
                },
                'ModelGerenciador' => function ($sm) {
                    // return instacia Model GerenciadorTable
                    return new GerenciadorTable($sm->get('GerenciadorTableGateway'));
                },
            )
        );
    }

    /**
     * Register Controller Plugin
     */
    public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'cache' => function($sm) {
                    return new Controller\Plugin\Cache($sm->getServiceLocator()->get('Cache\FileSystem'));
                },
            ),
        );
    }
}
