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
namespace Pessoa\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class PessoaForm extends Form
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
            'name' => 'id_pessoa',
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'nome_pessoa',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputNomePessoa',
                'placeholder'   => 'Digite seu nome Completo.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'cpf',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputCpf',
                'placeholder'   => 'Digite seu cpf.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'identidade',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputIdentidade',
                'placeholder'   => 'Digite sua identidade.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'endereco',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputEndereco',
                'placeholder'   => 'Digite seu endereço completo.',
            ],
        ]);

        //---------
        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'logradouro',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputLogradouro',
                'placeholder'   => 'Digite sua rua, av...',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'numero',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputNumero',
                'placeholder'   => 'Numero.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'number', # ou 'type' => 'Text'
            'name' => 'apto',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputApto',
                'placeholder'   => 'Numero.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'bairro',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputBairro',
                'placeholder'   => 'Digite o nome do seu bairro.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'cidade',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputCidade',
                'value' => '',
                'placeholder'   => 'Digite o nome da sua cidade.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'estado',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputEstado',
                'value' => '',
                'placeholder'   => 'Digite o nome do seu estado.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'cep',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputCep',
                'value' => '',
                'placeholder'   => 'Digite seu cep.',
            ],
        ]);
        //------

        // elemento do tipo date
        $this->add([
            'type' => 'Date', # ou 'type' => 'Text'
            'name' => 'data_nasc',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputDataNasc',
                'placeholder'   => 'Digite sua data de nascimento.',
            ],
        ]);

        // elemento do tipo email
        $this->add([
            'type' => 'Email', # ou 'type' => 'Text'
            'name' => 'email',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputEmail',
                'placeholder'   => 'Digite seu email.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'telefone_principal',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputTelefonePrincipal',
                'placeholder'   => 'Digite seu telefone principal.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'telefone_secundario',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputTelefoneSecundario',
                'placeholder'   => 'Digite seu telefone secundário(opcional).',
            ],
        ]);

        $this->add([
            'type' => 'Radio',
            'name' => 'sexo',
            'options' => [
                'label' => 'Informe seu sexo.',
                'value_options' => [
                    ['value' => 'Masculino',
                        'label' => 'Masculino',
                        'selected' => false,
                        'disabled' => false,
                    ],
                    ['value' => 'Feminino',
                        'label' => 'Feminino',
                        'selected' => false,
                        'disabled' => false,
                    ],
                ],
            ],
        ]);

        $this->add([
            'type' => 'Radio',
            'name' => 'situacao',
            'options' => [
                'label' => 'Informe sua situação.',
                'value_options' => [
                    ['value' => 'Aluno',
                        'label' => 'Aluno',
                        'selected' => true,
                        'disabled' => false,
                    ],
                    ['value' => 'Ex Aluno',
                        'label' => 'Ex Aluno',
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