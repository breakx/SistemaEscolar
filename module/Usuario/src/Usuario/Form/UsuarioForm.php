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
namespace Usuario\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class UsuarioForm extends Form
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
            'name' => 'id_usuario',
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'matricula',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputMatricula',
                'placeholder'   => 'Gerado automaticamente.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Password', # ou 'type' => 'ZendFormElementText'
            'name' => 'senha',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputSenha',
                'placeholder'   => 'Digite sua senha.',
            ],
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Password', # ou 'type' => 'ZendFormElementText'
            'name' => 'repetir_senha',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputRepetirSenha',
                'placeholder'   => 'Repita a senha.',
            ],
        ]);

        // elemento para evitar ataques Cross-Site Request Forgery
        //$this->add(new Element\Csrf('security'));
    }
}