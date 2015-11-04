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

    //Series
    public $id_serie;
    public $nome_serie;
    public $subtipo;

    //Materias
    public $id_materia;
    public $nome_materia;
    public $ano;
    public $tipo_materia;
    public $nome_professor;

    //Usuarios
    public $id_usuario;
    public $matricula;
    public $senha;
    public $repetir_senha;

    //Tipo Usuarios
    public $id_tipo_usuario;
    public $nome_tipo_usuario;

    //Funcionarios
    public $id_funcionario;
    public $nome_funcionario;
    public $atuacao;
    public $formacao;

    //Cargos Funcionarios
    public $id_cargo_funcionario;
    public $nome_cargo_funcionario;

    //Alunos
    public $id_aluno;
    public $nome_aluno;
    public $curso_aluno;
    public $serie_aluno;
    public $materia_aluno;
    public $professor_aluno;
    public $nota1;
    public $nota2;
    public $nota3;
    public $nota4;
    public $trabalho1;
    public $trabalho2;
    public $trabalho3;
    public $trabalho4;

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

        //serie
        $this->id_serie = (!empty($data['id_serie'])) ? $data['id_serie'] : null;
        $this->nome_serie = (!empty($data['nome_serie'])) ? $data['nome_serie'] : null;
        $this->subtipo = (!empty($data['subtipo'])) ? $data['subtipo'] : null;

        //materias
        $this->id_materia = (!empty($data['id_materia'])) ? $data['id_materia'] : null;
        $this->nome_materia = (!empty($data['nome_materia'])) ? $data['nome_materia'] : null;
        $this->ano = (!empty($data['ano'])) ? $data['ano'] : null;
        $this->tipo_materia = (!empty($data['tipo_materia'])) ? $data['tipo_materia'] : null;
        $this->nome_professor = (!empty($data['nome_professor'])) ? $data['nome_professor'] : null;

        //usuarios
        $this->id_usuario = (!empty($data['id_usuario'])) ? $data['id_usuario'] : null;
        $this->matricula = (!empty($data['matricula'])) ? $data['matricula'] : null;
        $this->senha = (!empty($data['senha'])) ? $data['senha'] : null;
        $this->repetir_senha = (!empty($data['repetir_senha'])) ? $data['repetir_senha'] : null;

        //tipo usuarios
        $this->id_tipo_usuario = (!empty($data['id_tipo_usuario'])) ? $data['id_tipo_usuario'] : null;
        $this->nome_tipo_usuario = (!empty($data['nome_tipo_usuario'])) ? $data['nome_tipo_usuario'] : null;

        //funcionario
        $this->id_funcionario = (!empty($data['id_funcionario'])) ? $data['id_funcionario'] : null;
        $this->nome_funcionario = (!empty($data['nome_funcionario'])) ? $data['nome_funcionario'] : null;
        $this->atuacao = (!empty($data['atuacao'])) ? $data['atuacao'] : null;
        $this->formacao = (!empty($data['formacao'])) ? $data['formacao'] : null;

        //cargo funcionario
        $this->id_cargo_funcionario = (!empty($data['id_cargo_funcionario'])) ? $data['id_cargo_funcionario'] : null;
        $this->nome_cargo_funcionario = (!empty($data['nome_cargo_funcionario'])) ? $data['nome_cargo_funcionario'] : null;

        //alunos
        $this->id_aluno = (!empty($data['id_aluno'])) ? $data['id_aluno'] : null;
        $this->nome_aluno = (!empty($data['nome_aluno'])) ? $data['nome_aluno'] : null;
        $this->curso_aluno = (!empty($data['curso_aluno'])) ? $data['curso_aluno'] : null;
        $this->serie_aluno = (!empty($data['serie_aluno'])) ? $data['serie_aluno'] : null;
        $this->materia_aluno = (!empty($data['materia_aluno'])) ? $data['materia_aluno'] : null;
        $this->nome_professor = (!empty($data['nome_professor'])) ? $data['nome_professor'] : null;
        $this->nota1 = (!empty($data['nota1'])) ? $data['nota1'] : null;
        $this->nota2 = (!empty($data['nota2'])) ? $data['nota2'] : null;
        $this->nota3 = (!empty($data['nota3'])) ? $data['nota3'] : null;
        $this->nota4 = (!empty($data['nota4'])) ? $data['nota4'] : null;
        $this->trabalho1 = (!empty($data['trabalho1'])) ? $data['trabalho1'] : null;
        $this->trabalho2 = (!empty($data['trabalho2'])) ? $data['trabalho2'] : null;
        $this->trabalho3 = (!empty($data['trabalho3'])) ? $data['trabalho3'] : null;
        $this->trabalho4 = (!empty($data['trabalho4'])) ? $data['trabalho4'] : null;
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
                        'name'     => 'situacao',
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

                    //input filter para campo de nome professor
                    $inputFilter->add(array(
                        'name'=>'repetir_senha',
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
                case 'tipos_usuarios':
                    //input filter para campo id
                    $inputFilter->add(array(
                        'name'=>'id_tipo_usuarios',
                        'required'=>true,
                        'filters'=>array(
                            array('name'=>'Int'),#transforma string para inteiro
                        ),
                    ));

                    //input filter para campo de nome
                    $inputFilter->add(array(
                        'name'=>'nome_tipo_usuarios',
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
                    //input filter para campo id
                    $inputFilter->add(array(
                        'name'=>'id_funcioanrio',
                        'required'=>true,
                        'filters'=>array(
                            array('name'=>'Int'),#transforma string para inteiro
                        ),
                    ));

                    //input filter para campo de nome
                    $inputFilter->add(array(
                        'name'=>'nome_funcionario',
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

                    //input filter para campo de atuacao
                    $inputFilter->add(array(
                        'name'=>'atuacao',
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

                    //input filter para campo de atuacao
                    $inputFilter->add(array(
                        'name'=>'formacao',
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
                case 'cargos_funcionarios':
                    //input filter para campo id
                    $inputFilter->add(array(
                        'name'=>'id_cargo_funcioanrio',
                        'required'=>true,
                        'filters'=>array(
                            array('name'=>'Int'),#transforma string para inteiro
                        ),
                    ));

                    //input filter para campo de nome
                    $inputFilter->add(array(
                        'name'=>'nome_cargo_funcionario',
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
                case 'alunos':
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