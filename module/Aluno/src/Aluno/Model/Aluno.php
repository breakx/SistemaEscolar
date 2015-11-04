<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:44
 */

namespace Aluno\Model;

//imports Zend/InputFilter
use Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterInterface;

use Zend\Validator\NotEmpty,
    Zend\Validator\StringLength;

class Aluno
{
    //Alunos
    public $id_aluno;
    public $nome_aluno;
    public $matricula_aluno;
    public $curso_aluno;
    public $serie_aluno;
    public $materia_aluno;
    public $professor_aluno;
    public $prova1;
    public $prova2;
    public $prova3;
    public $prova4;
    public $trabalho1;
    public $trabalho2;
    public $trabalho3;
    public $trabalho4;
    public $faltas;
    public $situacao_aluno;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        //alunos
        $this->id_aluno = (!empty($data['id_aluno'])) ? $data['id_aluno'] : null;
        $this->nome_aluno = (!empty($data['nome_aluno'])) ? $data['nome_aluno'] : null;
        $this->matricula_aluno = (!empty($data['matricula_aluno'])) ? $data['matricula_aluno'] : null;
        $this->curso_aluno = (!empty($data['curso_aluno'])) ? $data['curso_aluno'] : null;
        $this->serie_aluno = (!empty($data['serie_aluno'])) ? $data['serie_aluno'] : null;
        $this->materia_aluno = (!empty($data['materia_aluno'])) ? $data['materia_aluno'] : null;
        $this->professor_aluno = (!empty($data['professor_aluno'])) ? $data['professor_aluno'] : null;
        $this->prova1 = (!empty($data['prova1'])) ? $data['prova1'] : null;
        $this->prova2 = (!empty($data['prova2'])) ? $data['prova2'] : null;
        $this->prova3 = (!empty($data['prova3'])) ? $data['prova3'] : null;
        $this->prova4 = (!empty($data['prova4'])) ? $data['prova4'] : null;
        $this->trabalho1 = (!empty($data['trabalho1'])) ? $data['trabalho1'] : null;
        $this->trabalho2 = (!empty($data['trabalho2'])) ? $data['trabalho2'] : null;
        $this->trabalho3 = (!empty($data['trabalho3'])) ? $data['trabalho3'] : null;
        $this->trabalho4 = (!empty($data['trabalho4'])) ? $data['trabalho4'] : null;
        $this->faltas = (!empty($data['faltas'])) ? $data['faltas'] : null;
        $this->situacao_aluno = (!empty($data['situacao_aluno'])) ? $data['situacao_aluno'] : null;
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
                'name'=>'id_aluno',
                'required'=>true,
                'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),
            ));

            //input filter para campo de nome
            $inputFilter->add(array(
                'name'=>'nome_aluno',
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

            //input filter para campo matricula
            $inputFilter->add(array(
                'name'=>'matricula_aluno',
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

            //input filter para campo curso
            $inputFilter->add(array(
                'name'=>'curso_aluno',
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
                            /*'min'=>3,
                            'max'=>100,
                            'messages'=>array(
                                StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                            ),*/
                        ),
                    ),
                ),
            ));

            //input filter para campo serie
            $inputFilter->add(array(
                'name'=>'serie_aluno',
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
                            /*'min'=>3,
                            'max'=>100,
                            'messages'=>array(
                                StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                            ),*/
                        ),
                    ),
                ),
            ));

            //input filter para campo materia
            $inputFilter->add(array(
                'name'=>'materia_aluno',
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
                            /*'min'=>3,
                            'max'=>100,
                            'messages'=>array(
                                StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                            ),*/
                        ),
                    ),
                ),
            ));

            //input filter para campo curso
            $inputFilter->add(array(
                'name'=>'professor_aluno',
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
                            /*'min'=>3,
                            'max'=>100,
                            'messages'=>array(
                                StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                            ),*/
                        ),
                    ),
                ),
            ));

            //input filter para nota provas
            $inputFilter->add(array(
                'name'=>'prova1',
                'required'=>false,
                /*'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),*/
            ));
            $inputFilter->add(array(
                'name'=>'prova2',
                'required'=>false,
                /*'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),*/
            ));
            $inputFilter->add(array(
                'name'=>'prova3',
                'required'=>false,
                /*'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),*/
            ));
            $inputFilter->add(array(
                'name'=>'prova4',
                'required'=>false,
                /*'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),*/
            ));

            //input filter para nota trabalhos
            $inputFilter->add(array(
                'name'=>'trabalho1',
                'required'=>false,
                /*'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),*/
            ));
            $inputFilter->add(array(
                'name'=>'trabalho2',
                'required'=>false,
                /*'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),*/
            ));
            $inputFilter->add(array(
                'name'=>'trabalho3',
                'required'=>false,
                /*'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),*/
            ));
            $inputFilter->add(array(
                'name'=>'trabalho4',
                'required'=>false,
                /*'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),*/
            ));

            //input faltas
            $inputFilter->add(array(
                'name'=>'faltas',
                'required'=>false,
                'filters'=>array(
                    array('name'=>'Int'),#transforma string para inteiro
                ),
            ));

            //input situacao
            $inputFilter->add(array(
                'name'     => 'situacao_aluno',
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

            $inputFilter->setData(array(
                'float'    => '1.234,56',  // (float) 1.234; should be 1,234.56 (it_IT to en_US)
                'integer'  => '1.234',     // (float) 1.234; should be 1,234 (it_IT to en_US)
                'nfloat'   => '-1.234,56', // (float) -1.234; should be -1,234.56 (it_IT to en_US)
                'ninteger' => '-1.234'     // (float) -1.234; should be -1,234 (it_IT to en_US)
            ));

            $this->inputFilter=$inputFilter;
        }
        return $this->inputFilter;
    }
}