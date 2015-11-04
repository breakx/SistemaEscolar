<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:44
 */

namespace Materia\Model;

//imports Zend/InputFilter
use Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterInterface;

use Zend\Validator\NotEmpty,
    Zend\Validator\StringLength;

class Materia
{
    //Materias
    public $id_materia;
    public $nome_materia;
    public $ano;
    public $tipo_materia;
    public $nome_professor;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        //materias
        $this->id_materia = (!empty($data['id_materia'])) ? $data['id_materia'] : null;
        $this->nome_materia = (!empty($data['nome_materia'])) ? $data['nome_materia'] : null;
        $this->ano = (!empty($data['ano'])) ? $data['ano'] : null;
        $this->tipo_materia = (!empty($data['tipo_materia'])) ? $data['tipo_materia'] : null;
        $this->nome_professor = (!empty($data['nome_professor'])) ? $data['nome_professor'] : null;
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
                'name'=>'id_materia',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),
            ));

            //input filter para campo de nome
            $inputFilter->add(array(
                'name'=>'nome_materia',
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

            //input filter para campo de nome professor
            $inputFilter->add(array(
                'name'=>'nome_professor',
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

            //input filter para campo de data nascimento
            $inputFilter->add(array(
                'name'=>'ano',
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
                ),
            ));

            //input filter para tipo da materia(anual,semestal,trimestal,bimestral)
            $inputFilter->add(array(
                'name'     => 'tipo_materia',
                'required' => true,
                /*'filters'  => array(
                    array('name' => 'Int'),
                ),*/
                'validators' => array(
                    array(
                        'name'    => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => 'Campo obrigatório.'
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