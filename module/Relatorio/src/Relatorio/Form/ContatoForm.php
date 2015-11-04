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
namespace DadosPessoais\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class DadosPessoaisForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct($name);

        // config form atributes
        $this->setAttributes(array(
            'method'    => 'POST',
            'class'     => 'form-horizontal',
        ));

        // elemento do tipo hidden
        $this->add(array(
            'type' => 'Hidden', # ou 'type' => 'ZendFormElementHidden'
            'name' => 'id',
        ));

        // elemento do tipo text
        $this->add(array(
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'nome_pessoa',
            'attributes' => array(
                'class'         => 'form-control',
                'id'            => 'inputNome',
                'placeholder'   => 'Nome Completo',
            ),
        ));

        // elemento do tipo text
        $this->add(array(
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'telefone_principal',
            'attributes' => array(
                'class'         => 'form-control',
                'id'            => 'inputTelefonePrincipal',
                'placeholder'   => 'Digite seu telefone principal',
            ),
        ));

        // elemento do tipo text
        $this->add(array(
            'type' => 'Text', # ou 'type' => 'Text'
            'name' => 'telefone_secundario',
            'attributes' => array(
                'class'         => 'form-control',
                'id'            => 'inputTelefoneSecundario',
                'placeholder'   => 'Digite seu telefone secundário(opcional)',
            ),
        ));

        /*// elemento do tipo select
        $this->add(array(
            'type' => 'Select',
            'name' => 'tipo_usuario',
            'attributes' => array(
                'class'         => 'form-control',
                'id'            => 'inputTipoUsuario',
            ),
            'options' => array(
                'label' => 'Tipo de Usuario',
                'empty_option' => 'Selecione o tipo de usuario',
                'value_options' => $this->tipo_usuario,
                'value_options' => array(
                    '0' => 'Estudante',
                    '1' => 'Professor',
                    '2' => 'Coordenador',
                    '3' => 'Administrador',
                ),
            )
        ));*/

        // elemento do tipo captcha para evitar ataques de robos
        $this->add(
            (new Element\Captcha())
                ->setName('captcha')
                ->setOptions(array(
                    'captcha' => (new Captcha\Figlet(array(
                        'wordLen'       => 3,      # quantidade de caracteres para o nosso captcha
                        'timeout'       => 300,     # tempo de validade do captcha em milisegundos
                        'outputWidth'   => '500',   # quantidade de strings por linha do capcha
                        'font'          => 'data/fonts/banner3.flf', # font para o captcha do tipo figlet
                    )))->setMessage("Campo faltando ou digitado incorretamente.")
                ))
                ->setAttributes([
                    'class'         => 'form-control',
                    'id'            => 'inputCaptcha',
                    'placeholder'   => 'Digite a palavra acima, aqui, para proseguir',
                ])
        );

        // elemento para evitar ataques Cross-Site Request Forgery
        $this->add(new Element\Csrf('security'));
    }

}