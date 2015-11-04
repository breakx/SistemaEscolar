<?php
/**
 * namespace para nosso modulo aluno
 */
namespace Aluno;

// import Aluno\Model
use Aluno\Model\Aluno,
    Aluno\Model\AlunoAlunoTable;

// import Zend\Db
use Aluno\Model\AlunoTable;
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
                'filter_aluno' => 'Aluno\View\Helper\AlunoFilter'
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
                'AlunoTableGateway' => function ($sm) {
                    // obter adapter db atraves do service manager
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');

                    // configurar ResultSet com nosso model Aluno
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Aluno());

                    // return TableGateway configurado para nosso model Aluno
                    return new TableGateway('alunos', $adapter, null, $resultSetPrototype);
                },
                'ModelAluno' => function ($sm) {
                    // return instacia Model AlunoTable
                    return new AlunoTable($sm->get('AlunoTableGateway'));
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
