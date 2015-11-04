<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:44
 */

namespace Curso\Model;

//imports Zend/InputFilter
use Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterInterface;

use Zend\Validator\NotEmpty,
    Zend\Validator\StringLength;

class Curso
{
    //Cursos
    public $id_curso;
    public $nome_curso;
    public $turno;
    public $tipo;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        //cursos
        $this->id_curso = (!empty($data['id_curso'])) ? $data['id_curso'] : null;
        $this->nome_curso = (!empty($data['nome_curso'])) ? $data['nome_curso'] : null;
        $this->turno = (!empty($data['turno'])) ? $data['turno'] : null;
        $this->tipo = (!empty($data['tipo'])) ? $data['tipo'] : null;
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
                'name'=>'id_curso',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),
            ));

            //input filter para campo de nome
            $inputFilter->add(array(
                'name'=>'nome_curso',
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

            $inputFilter->add(array(
                'name'     => 'turno',
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

            $inputFilter->add(array(
                'name'     => 'tipo',
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