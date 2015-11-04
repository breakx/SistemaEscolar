<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 30/09/2015
 * Time: 10:35
 */

/**
 * namespace de localizacao do nosso formulario
 */
namespace Curso\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class CursoForm extends Form
{

    public function __construct($name = NULL)
    {

        parent::__construct($name);

        // config form atributes
        $this->setAttributes(array(
            'method'    => 'POST',
            'class'     => 'form-horizontal',
        ));

        // elemento do tipo hidden
        $this->add([
            'type' => 'Hidden', # ou 'type' => 'ZendFormElementHidden'
            'name' => 'id_curso',
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'nome_curso',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputNomeCurso',
                'placeholder'   => 'Digite o nome do curso.',
            ],
        ]);

        $this->add([
            'type' => 'Radio',
            'name' => 'turno',
            'options' => [
                'label' => 'Informe o turno do curso.',
                'value_options' => [
                    ['value' => 'Manha',
                        'label' => ' Manha',
                        'selected' => false,
                        'disabled' => false,
                    ],
                    ['value' => 'Tarde',
                        'label' => ' Tarde',
                        'selected' => false,
                        'disabled' => false,
                    ],
                    ['value' => 'Noite',
                        'label' => ' Noite',
                        'selected' => false,
                        'disabled' => false,
                    ],
                ],
            ],
        ]);

        $this->add([
            'type' => 'Radio',
            'name' => 'tipo',
            'options' => [
                'label' => 'Informe o tipo de curso.',
                'value_options' => [
                    ['value' => 'Interno',
                        'label' => ' Interno',
                        'selected' => true,
                        'disabled' => false,
                    ],
                    ['value' => 'Comunidade',
                        'label' => 'Comunidade',
                        'selected' => false,
                        'disabled' => false,
                    ],
                ],
            ],
        ]);

        // elemento para evitar ataques Cross-Site Request Forgery
        //$this->add(new Element\Csrf('security'));
    }
}