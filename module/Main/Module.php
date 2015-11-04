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
                'SeriesTableGateway' => function ($sm) {
                    $adapter = $sm->get('AdapterDb');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Main());

                    return new TableGateway('series', $adapter, NULL, $resultSetPrototype);
                },
                'ModelSeries' => function ($sm) {
                    return new MainTable($sm->get('SeriesTableGateway'));
                },
                'MateriasTableGateway' => function ($sm) {
                    $adapter = $sm->get('AdapterDb');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Main());

                    return new TableGateway('materias', $adapter, NULL, $resultSetPrototype);
                },
                'ModelMaterias' => function ($sm) {
                    return new MainTable($sm->get('MateriasTableGateway'));
                },
                'AlunosTableGateway' => function ($sm) {
                    $adapter = $sm->get('AdapterDb');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Main());

                    return new TableGateway('alunos', $adapter, NULL, $resultSetPrototype);
                },
                'ModelAlunos' => function ($sm) {
                    return new MainTable($sm->get('AlunosTableGateway'));
                },
                'FuncionariosTableGateway' => function ($sm) {
                    $adapter = $sm->get('AdapterDb');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Main());

                    return new TableGateway('funcionarios', $adapter, NULL, $resultSetPrototype);
                },
                'ModelFuncionarios' => function ($sm) {
                    return new MainTable($sm->get('FuncionariosTableGateway'));
                },
                'CargosFuncionariosTableGateway' => function ($sm) {
                    $adapter = $sm->get('AdapterDb');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Main());

                    return new TableGateway('cargos_funcionarios', $adapter, NULL, $resultSetPrototype);
                },
                'ModelCargosFuncionarios' => function ($sm) {
                    return new MainTable($sm->get('CargosFuncionariosTableGateway'));
                },
                'UsuariosTableGateway' => function ($sm) {
                    $adapter = $sm->get('AdapterDb');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Main());

                    return new TableGateway('usuarios', $adapter, NULL, $resultSetPrototype);
                },
                'ModelUsuarios' => function ($sm) {
                    return new MainTable($sm->get('UsuariosTableGateway'));
                },
                'TiposUsuariosTableGateway' => function ($sm) {
                    $adapter = $sm->get('AdapterDb');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Main());

                    return new TableGateway('tipos_usuarios', $adapter, NULL, $resultSetPrototype);
                },
                'ModelTiposUsuarios' => function ($sm) {
                    return new MainTable($sm->get('TiposUsuariosTableGateway'));
                },
            ]
        ];
    }
}
