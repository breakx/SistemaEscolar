<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:44
 */

namespace Cargo\Model;

//imports Zend/InputFilter
use Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterInterface;

use Zend\Validator\NotEmpty,
    Zend\Validator\StringLength;

class Cargo
{
    //Cargos Funcionarios
    public $id_cargo;
    public $nome_cargo;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        //cargo funcionario
        $this->id_cargo = (!empty($data['id_cargo'])) ? $data['id_cargo'] : null;
        $this->nome_cargo = (!empty($data['nome_cargo'])) ? $data['nome_cargo'] : null;
    }


    /**
     * @param InputFilterInterface $inputFilter
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter){
        throw new \Exception('Não utilizado.');
    }

    /**
     * @return InputFilter
     */
    public function getInputFilter(){
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();

            //input filter para campo id
            $inputFilter->add(array(
                'name'=>'id_cargo',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),
            ));

            //input filter para campo de nome
            $inputFilter->add(array(
                'name'=>'nome_cargo',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'StripTags'),#remove xml e html da string
                    array('name'=>'StringTrim'),#remove espaços do inicio e do final da string
                    //array('name'=>'StringToUpper'),#transforma string em maiusculo
                ),
                'validators'=>array(
                    array(
                        'name'=>'NotEmpty',
                        'options'=>array(
                            'messages'=>array(
                                NotEmpty::IS_EMPTY=>'Campo obrigatório.'
                            ),
                        ),
                    ),
                    array(
                        'name'=>'StringLength',
                        'options'=>array(
                            'encoding'=>'UTF-8',
                            'min'=>3,
                            'max'=>100,
                            'messages'=>array(
                                StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                            ),
                        ),
                    ),
                ),
            ));

            $this->inputFilter=$inputFilter;
        }
        return $this->inputFilter;
    }
}