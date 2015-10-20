<?php
namespace Main;

// import Contato\Model
use Main\Model\Main,
    Main\Model\MainTable;

// import Zend\Db
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

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
     * Register Services
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'DadosPessoaisTableGateway' => function ($sm) {
                    $adapter = $sm->get('AdapterDb');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Main());

                    return new TableGateway('dados_pessoais', $adapter, NULL, $resultSetPrototype);
                },
                'ModelDadosPessoais' => function ($sm) {
                    return new MainTable($sm->get('DadosPessoaisTableGateway'));
                },
                'CursosTableGateway' => function ($sm) {
                    $adapter = $sm->get('AdapterDb');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Main());

                    return new TableGateway('cursos', $adapter, NULL, $resultSetPrototype);
                },
                'ModelCursos' => function ($sm) {
                    return new MainTable($sm->get('CursosTableGateway'));
                },
            ]
        ];
    }
}
