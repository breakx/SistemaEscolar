<?php
/**
 * Created by PhpStorm.
 * User: LK
 * Date: 05/10/2015
 * Time: 19:26
 */

return [
    # definir e gerenciar controllers
    'controllers'  => [
        'invokables' => [
            'RelatorioController' => 'Relatorio\Controller\RelatorioController',
        ],
    ],

    # definir e gerenciar rotas
    'router'       => [
        'routes' => [
            # segment para controller fixos
            'relatorios' => [
                'type'    => 'Segment',
                'options' => [
                    'route'       => '/relatorios[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults'    => [
                        'controller' => 'RelatorioController',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    # definir e gerenciar layouts, erros, exceptions, doctype base
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],

        'strategies'          => [
            'ViewJsonStrategy',
        ],
    ],
];