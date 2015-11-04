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
namespace Funcionario\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class FuncionarioForm extends Form
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
            'name' => 'id_funcionario',
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'nome_funcionario',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputNomeFuncionario',
                'placeholder'   => 'Digite o nome do funcionario.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'formacao',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputFormacao',
                'placeholder'   => 'Digite a sua formação.',
            ],
        ]);

        // elemento do tipo select
        $this->add([
            'type' => 'Select',
            'name' => 'cargo_funcionario',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'selectCargoFuncionario',
            ],
            'options' => [
                'label' => 'Selecione o Cargo',
                'empty_option' => 'Selecione o Cargo',
                'value_options' => [
                    'Cargo1' => 'Cargo1',
                    'Cargo2' => 'Cargo2',
                    'Cargo3' => 'Cargo3',
                ],
            ]
        ]);

        // elemento do tipo textarea
        $this->add([
            'type' => 'Textarea', # ou 'type' => 'ZendFormElementText'
            'name' => 'especialidade',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputEspecialidade',
                'placeholder' => 'Descreva a(s) especialidade(s)',
            ],
        ]);

        // elemento para evitar ataques Cross-Site Request Forgery
        //$this->add(new Element\Csrf('security'));
    }
}