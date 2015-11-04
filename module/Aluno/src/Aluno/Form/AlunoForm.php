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
namespace Aluno\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class AlunoForm extends Form
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
            'name' => 'id_aluno',
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'nome_aluno',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputNomeAluno',
                'placeholder'   => 'Digite o nome do aluno.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'matricula_aluno',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputMatriculaAluno',
                'placeholder'   => 'Digite a matricula do aluno.',
                'disabled' => false,
            ],
        ]);

        // elemento do tipo select
        $this->add([
            'type' => 'Select',
            'name' => 'curso_aluno',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'selectCursoAluno',
            ],
            'options' => [
                'label' => 'Selecione o Curso',
                'empty_option' => 'Selecione uma opção',
                'value_options' => [
                    'Curso A' => 'Curso A',
                    'Curso B' => 'Curso B',
                ],
            ]
        ]);

        // elemento do tipo select
        $this->add([
            'type' => 'Select',
            'name' => 'serie_aluno',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'selectSerieAluno',
            ],
            'options' => [
                'label' => 'Selecione o Serie',
                'empty_option' => 'Selecione uma opção',
                'value_options' => [
                    'Serie A' => 'Serie A',
                    'Serie B' => 'Serie B',
                ],
            ]
        ]);

        // elemento do tipo select
        $this->add([
            'type' => 'Select',
            'name' => 'materia_aluno',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'selectMateriaAluno',
            ],
            'options' => [
                'label' => 'Selecione o Materia',
                'empty_option' => 'Selecione uma opção',
                'value_options' => [
                    'Materia A' => 'Materia A',
                    'Materia B' => 'Materia B',
                ],
            ]
        ]);

        // elemento do tipo select
        $this->add([
            'type' => 'Select',
            'name' => 'professor_aluno',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'selectProfessorAluno',
            ],
            'options' => [
                'label' => 'Selecione o Professor',
                'empty_option' => 'Selecione uma opção',
                'value_options' => [
                    'Professor A' => 'Professor A',
                    'Professor B' => 'Professor B',
                ],
            ]
        ]);

        // elemento do tipo number para nota das provas
        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'prova1',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputProva1',
                'min'  => 0,
                //'max'  => 10,
                'step' => 0.1, // default step interval is 1
                'value' => 0,
            ],
        ]);
        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'prova2',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputProva2',
                'min'  => 0,
                //'max'  => 10,
                'step' => 0.1, // default step interval is 1
                'value' => 0,
            ],
        ]);
        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'prova3',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputProva3',
                'min'  => 0,
                //'max'  => 10,
                'step' => 0.1, // default step interval is 1
                'value' => 0,
            ],
        ]);
        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'prova4',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputProva4',
                'min'  => 0,
                //'max'  => 10,
                'step' => 0.1, // default step interval is 1
                'value' => 0,
            ],
        ]);

        // elemento do tipo number para nota das trabalhos
        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'trabalho1',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputTrabalho1',
                'min'  => 0,
                //'max'  => 10,
                'step' => 0.1, // default step interval is 1
                'value' => 0,
            ],
        ]);
        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'trabalho2',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputTrabalho2',
                'min'  => 0,
                //'max'  => 10,
                'step' => 0.1, // default step interval is 1
                'value' => 0,
            ],
        ]);
        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'trabalho3',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputTrabalho3',
                'min'  => 0,
                //'max'  => 10,
                'step' => 0.1, // default step interval is 1
                'value' => 0,
            ],
        ]);
        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'trabalho4',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputTrabalho4',
                'min'  => 0,
                //'max'  => 10,
                'step' => 0.1, // default step interval is 1
                'value' => 0,
            ],
        ]);

        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'faltas',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputFaltas',
                'min'  => 0,
                'value' => 0,
            ],
        ]);

        $this->add([
            'type' => 'Radio',
            'name' => 'situacao_aluno',
            'options' => [
                'label' => 'Informe sua situação.',
                'value_options' => [
                    ['value' => 'Ativo',
                        'label' => 'Ativo',
                        'selected' => true,
                        'disabled' => false,
                    ],
                    ['value' => 'Inativo',
                        'label' => 'Inativo',
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