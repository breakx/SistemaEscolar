<?php
/**
 * namespace para nosso modulo materias
 */
namespace Materia;

// import Materia\Model
use Materia\Model\Materia,
    Materia\Model\MateriaTable;

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
                'filter_materia' => 'Materia\View\Helper\MateriaFilter'
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
                'MateriaTableGateway' => function ($sm) {
                    // obter adapter db atraves do service manager
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');

                    // configurar ResultSet com nosso model Materia
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Materia());

                    // return TableGateway configurado para nosso model Materia
                    return new TableGateway('materias', $adapter, null, $resultSetPrototype);
                },
                'ModelMateria' => function ($sm) {
                    // return instacia Model MateriaTable
                    return new MateriaTable($sm->get('MateriaTableGateway'));
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
