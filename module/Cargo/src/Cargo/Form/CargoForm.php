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
namespace Cargo\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class CargoForm extends Form
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
            'name' => 'id_cargo',
        ]);

        // elemento do tipo text
        $this->add([
            'type' => 'Text', # ou 'type' => 'ZendFormElementText'
            'name' => 'nome_cargo',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'inputNomeCargo',
                'placeholder'   => 'Digite o nome do cargo do funcionario.',
            ],
        ]);

        // elemento para evitar ataques Cross-Site Request Forgery
        //$this->add(new Element\Csrf('security'));
    }
}