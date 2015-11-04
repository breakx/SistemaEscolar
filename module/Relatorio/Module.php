<?php
/**
 * Created by PhpStorm.
 * User: LK
 * Date: 05/10/2015
 * Time: 19:23
 */

namespace Relatorio;

// import Contato\Model
use Relatorio\Model\Relatorio,
    Relatorio\Model\RelatorioTable;

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
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * Register Services
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'RelatorioTableGateway' => function ($sm) {
                    $adapter = $sm->get('AdapterDb');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Relatorio());

                    return new TableGateway('contatos', $adapter, NULL, $resultSetPrototype);
                },
                'ModelRelatorio' => function ($sm) {
                    return new RelatorioTable($sm->get('RelatorioTableGateway'));
                },
            ]
        ];
    }


}