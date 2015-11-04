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
namespace Serie\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class SerieForm extends Form
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
            'name' => 'id_serie',
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'nome_serie',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputNomeSerie',
                'placeholder'   => 'Digite o nome da serie.',
            ],
        ]);

        // elemento do tipo select
        /*$this->add([
            'type' => 'Select',
            'name' => 'nome_serie',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'selectSituacao',
            ],
            'options' => [
                'label' => 'Situacao',
                'empty_option' => 'Selecione uma opção',
                'value_options' => [
                    '1' => '1º ano',
                    '2' => '2º ano',
                ],
            ]
        ]);*/

        $this->add([
            'type' => 'Radio',
            'name' => 'subtipo',
            'options' => [
                'label' => 'Informe o subtipo da serie.',
                'value_options' => [
                    ['value' => 'A',
                        'label' => ' A',
                        'selected' => false,
                        'disabled' => false,
                    ],
                    ['value' => 'B',
                        'label' => ' B',
                        'selected' => false,
                        'disabled' => false,
                    ],
                    ['value' => 'C',
                        'label' => ' C',
                        'selected' => false,
                        'disabled' => false,
                    ],
                    ['value' => 'D',
                        'label' => ' D',
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