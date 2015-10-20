<?php
return [
    # definir e gerenciar controllers
    'controllers'  => [
        'invokables' => [
            'MainController' => 'Main\Controller\MainController',
        ],
    ],

    # definir e gerenciar rotas
    'router'       => [
        'routes' => [
            # segment para controller fixos
            'main' => [
                'type'    => 'Segment',
                'options' => [
                    'route'       => '/main[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults'    => [
                        'controller' => 'MainController',
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