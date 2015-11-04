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
namespace Materia\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class MateriaForm extends Form
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
            'name' => 'id_materia',
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'nome_materia',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputNomeMateria',
                'placeholder'   => 'Digite o nome da matéria.',
            ],
        ]);

        // elemento do tipo select
        $this->add([
            'type' => 'Select',
            'name' => 'tipo_materia',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'selectTipoMateria',
            ],
            'options' => [
                'label' => 'Situacao',
                'empty_option' => 'Selecione uma opção',
                'value_options' => [
                    'Anual' => 'Anual',
                    'Semestral' => 'Semestral',
                    'Trimestral' => 'Trimestral',
                ],
            ]
        ]);

        $this->add([
            'type' => 'Date', # ou 'type' => 'Text'
            'name' => 'ano',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputAno',
                'placeholder'   => 'Digite o ano.',
            ],
            'options' => [
                'label' => 'Select a month and a year',
                'min_year' => 1986,
                'max_year' => 2020
            ]
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'nome_professor',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputNomeProfessor',
                'placeholder'   => 'Digite o nome do professor.',
            ],
        ]);

        // elemento para evitar ataques Cross-Site Request Forgery
        //$this->add(new Element\Csrf('security'));
    }
}