<?php
/**
 * Created by PhpStorm.
 * User: Cristiano GD
 * Date: 16/10/2015
 * Time: 09:27
 */

namespace Main\Model;

//imports Zend/InputFilter
use Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterInterface;

use Zend\Validator\NotEmpty,
    Zend\Validator\StringLength;

class Main
{
    //Dados pessoais
    public $id_pessoa;
    public $nome_pessoa;
    public $cpf;
    public $identidade;
    public $endereco;
    public $logradouro;
    public $numero;
    public $apto;
    public $bairro;
    public $cidade;
    public $estado;
    public $cep;
    public $data_nasc;
    public $data_cadastro;
    public $email;
    public $telefone_principal;
    public $telefone_secundario;
    public $sexo;
    public $situacao;

    //Cursos
    public $id_curso;
    public $nome_curso;
    public $turno;
    public $tipo;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        //Dados pessoais
        $this->id_pessoa = (!empty($data['id_pessoa'])) ? $data['id_pessoa'] : null;
        $this->nome_pessoa = (!empty($data['nome_pessoa'])) ? $data['nome_pessoa'] : null;
        $this->cpf = (!empty($data['cpf'])) ? $data['cpf'] : null;
        $this->identidade = (!empty($data['identidade'])) ? $data['identidade'] : null;

        $this->endereco = (!empty($data['endereco'])) ? $data['endereco'] : null;

        $this->logradouro = (!empty($data['logradouro'])) ? $data['logradouro'] : null;
        $this->numero = (!empty($data['numero'])) ? $data['numero'] : null;
        $this->apto = (!empty($data['apto'])) ? $data['apto'] : null;
        $this->bairro = (!empty($data['bairro'])) ? $data['bairro'] : null;
        $this->cidade = (!empty($data['cidade'])) ? $data['cidade'] : null;
        $this->estado = (!empty($data['estado'])) ? $data['estado'] : null;
        $this->cep = (!empty($data['cep'])) ? $data['cep'] : null;

        $this->data_nasc = (!empty($data['data_nasc'])) ? $data['data_nasc'] : null;
        $this->data_cadastro = (!empty($data['data_cadastro'])) ? $data['data_cadastro'] : null;

        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->telefone_principal = (!empty($data['telefone_principal'])) ? $data['telefone_principal'] : null;
        $this->telefone_secundario = (!empty($data['telefone_secundario'])) ? $data['telefone_secundario'] : null;

        $this->sexo = (!empty($data['sexo'])) ? $data['sexo'] : null;
        $this->situacao = (!empty($data['situacao'])) ? $data['situacao'] : null;

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
    public function getInputFilter($tabela){
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();

            switch($tabela){
                case 'dados_pessoais':
                    //input filter para campo id
                    $inputFilter->add(array(
                        'name'=>'id_pessoa',
                        'required'=>true,
                        'filters'=>array(
                            array('name'=>'Int'),#transforma string para inteiro
                        ),
                    ));

                    //input filter para campo de nome
                    $inputFilter->add(array(
                        'name'=>'nome_pessoa',
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

                    //input filter para campo de cpf
                    $inputFilter->add(array(
                        'name'=>'cpf',
                        'required'=>true,
                        'filters'=>array(
                            array('name'=>'StripTags'),#remove xml e html da string
                            array('name'=>'StringTrim'),#remove espaços do inicio e do final da string //array('name'=>'StringToUpper'),#transforma string em maiusculo
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
                                    'min'=>11,#xxxxxxxxxxx
                                    'max'=>14,#xxx.xxx.xxx-xx
                                    'messages'=>array(
                                        StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                        StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                                    ),
                                ),
                            ),
                        ),
                    ));

                    //input filter para campo de rg
                    $inputFilter->add(array(
                        'name'=>'identidade',
                        'required'=>true,
                        'filters'=>array(
                            array('name'=>'StripTags'),#remove xml e html da string
                            array('name'=>'StringTrim'),#remove espaços do inicio e do final da string //array('name'=>'StringToUpper'),#transforma string em maiusculo
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
                                    'min'=>8,#xxxxxxxx
                                    'max'=>12,#xx.xxx.xxx-x
                                    'messages'=>array(
                                        StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                        StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                                    ),
                                ),
                            ),
                        ),
                    ));

                    //input filter para campo de endereço
                    $inputFilter->add(array(
                        'name'=>'endereco',
                        'required'=>false,
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

                    //input filter para campo logradouro
                    $inputFilter->add(array(
                        'name'=>'logradouro',
                        'required'=>false,
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

                    //input filter para campo numero
                    $inputFilter->add(array(
                        'name'=>'numero',
                        'required'=>false,
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
                                    'min'=>1,
                                    'max'=>5,
                                    'messages'=>array(
                                        StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                        StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                                    ),
                                ),
                            ),
                        ),
                    ));

                    //input filter para campo numero
                    $inputFilter->add(array(
                        'name'=>'apto',
                        'required'=>false,
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
                                    'min'=>1,
                                    'max'=>4,
                                    'messages'=>array(
                                        StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                        StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                                    ),
                                ),
                            ),
                        ),
                    ));

                    //input filter para campo bairro
                    $inputFilter->add(array(
                        'name'=>'bairro',
                        'required'=>false,
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

                    //input filter para campo cidade
                    $inputFilter->add(array(
                        'name'=>'cidade',
                        'required'=>false,
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

                    //input filter para campo estado
                    $inputFilter->add(array(
                        'name'=>'estado',
                        'required'=>false,
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
                                    'min'=>2,
                                    'max'=>100,
                                    'messages'=>array(
                                        StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                        StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                                    ),
                                ),
                            ),
                        ),
                    ));

                    //input filter para campo cep
                    $inputFilter->add(array(
                        'name'=>'cep',
                        'required'=>false,
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
                                    'min'=>2,
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
                        'name'=>'data_nasc',
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

                    //input filter para campo de email
                    $inputFilter->add(array(
                        'name'=>'email',
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
                                    'min'=>7,#x@x.xxx
                                    'max'=>100,#nome@email.com.br
                                    'messages'=>array(
                                        StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                        StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                                    ),
                                ),
                            ),
                        ),
                    ));

                    //input filter para campo de telefone_principal
                    $inputFilter->add(array(
                        'name'=>'telefone_principal',
                        'required'=>true,
                        'filters'=>array(
                            array('name'=>'StripTags'),#remove xml e html da string
                            array('name'=>'StringTrim'),#remove espaços do inicio e do final da string //array('name'=>'StringToUpper'),#transforma string em maiusculo
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
                                    'min'=>12,#xxxxxxxxxxx
                                    'max'=>15,#(xx)xxxxx-xxxx
                                    'messages'=>array(
                                        StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                        StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                                    ),
                                ),
                            ),
                        ),
                    ));

                    //input filter para campo de telefone_secundario
                    $inputFilter->add(array(
                        'name'=>'telefone_secundario',
                        'required'=>false,
                        'filters'=>array(
                            array('name'=>'StripTags'),#remove xml e html da string
                            array('name'=>'StringTrim'),#remove espaços do inicio e do final da string //array('name'=>'StringToUpper'),#transforma string em maiusculo
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
                                    'min'=>12,#xxxxxxxxxxx
                                    'max'=>15,#(xx)xxxxx-xxxx
                                    'messages'=>array(
                                        StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                        StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                                    ),
                                ),
                            ),
                        ),
                    ));

                    $inputFilter->add(array(
                        'name'     => 'sexo',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'Int'),
                        ),
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
                        'name'     => 'situacao',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'Int'),
                        ),
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
                    break;
                case 'cursos':
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
                        'filters'  => array(
                            array('name' => 'Int'),
                        ),
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
                        'filters'  => array(
                            array('name' => 'Int'),
                        ),
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
                    break;
                case 'series':
                    //input filter para campo id
                    $inputFilter->add(array(
                        'name'=>'id_serie',
                        'required'=>true,
                        'filters'=>array(
                            array('name'=>'Int'),#transforma string para inteiro
                        ),
                    ));

                    //input filter para campo de nome
                    $inputFilter->add(array(
                        'name'=>'nome_serie',
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
                        'name'     => 'subtipo',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'Int'),
                        ),
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
                    break;
                case 'materias':
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
                        'name'     => 'tipo_mat',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'Int'),
                        ),
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
                    break;
                case 'usuarios':
                    //input filter para campo id
                    $inputFilter->add(array(
                        'name'=>'id_usuarios',
                        'required'=>true,
                        'filters'=>array(
                            array('name'=>'Int'),#transforma string para inteiro
                        ),
                    ));

                    //input filter para campo de nome
                    $inputFilter->add(array(
                        'name'=>'matricula',
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
                        'name'=>'senha',
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
                    break;
                case 'funcionarios':
                    //
                    break;
                case 'alunos':
                    //
                    break;
            }

            /*//input filter para campo de data cadastro
            $inputFilter->add(array(
                'name'=>'data_cadadastro',
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
                            'min'=>8,#xxxxxxxxxxxxxx
                            'max'=>21,#xx/xx/xxxx - xx:xx:xx
                            'messages'=>array(
                                StringLength::TOO_SHORT=>'Mínimo de caracteres aceitáveis %min%.',
                                StringLength::TOO_LONG=>'Máximo de caracteres aceitáveis %max%.',
                            ),
                        ),
                    ),
                ),
            ));*/

            $this->inputFilter=$inputFilter;
        }
        return $this->inputFilter;
    }
}