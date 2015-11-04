<?php
/**
 * Created by PhpStorm.
 * User: LK
 * Date: 07/10/2015
 * Time: 20:21
 */

/**
 * namespace de localizacao do nosso formulario
 */
namespace Relatorio\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class RelatorioForm extends Form
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

        // elemento do tipo select
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
                //'value_options' => $this->tipo_usuario,
                'value_options' => array(
                    '0' => 'Estudante',
                    '1' => 'Professor',
                    '2' => 'Coordenador',
                    '3' => 'Administrador',
                ),
            )
        ));

        // elemento do tipo select
        $this->add(array(
            'type' => 'Select',
            'name' => 'usuario',
            'attributes' => array(
                'class'         => 'form-control',
                'id'            => 'inputUsuario',
            ),
            'options' => array(
                'label' => 'Usuario',
                'empty_option' => 'Selecione seu usuario',
                //'value_options' => $this->tipo_usuario,
                /*'value_options' => array(
                    '0' => 'Estudante',
                    '1' => 'Professor',
                    '2' => 'Coordenador',
                    '3' => 'Administrador',
                ),*/
            )
        ));

        // elemento do tipo select
        $this->add(array(
            'type' => 'Select',
            'name' => 'select_country',
            'attributes' => array(
                'class'         => 'form-control',
                'id'            => 'selectCountry',
            ),
            'options' => array(
                'label' => 'Usuario',
                'empty_option' => 'Selecione um pais',
                'value_options' => array(
                    '0' => 'Brasil',
                    '1' => 'Canada',
                    '2' => 'Holanda',
                    '3' => 'Australia',
                ),
            )
        ));

        // elemento do tipo select
        $this->add(array(
            'type' => 'Select',
            'name' => 'select_state',
            'attributes' => array(
                'class'         => 'form-control',
                'id'            => 'selectState',
            ),
            'options' => array(
                'label' => 'Usuario',
                'empty_option' => 'Selecione um estado',
            )
        ));

        // elemento do tipo select
        $this->add(array(
            'type' => 'Select',
            'name' => 'select_city',
            'attributes' => array(
                'class'         => 'form-control',
                'id'            => 'selectCity',
            ),
            'options' => array(
                'label' => 'Usuario',
                'empty_option' => 'Selecione uma cidade',
            )
        ));
    }

}