<?php
/**
 * Created by PhpStorm.
 * User: Cristiano GD
 * Date: 16/10/2015
 * Time: 10:23
 */

/**
 * namespace de localizacao do nosso formulario
 */
namespace Main\Form;

// import Captcha
use Zend\Captcha;
// import Form
use Zend\Form\Form;
// import Element
use Zend\Form\Element;

class MainForm extends Form
{

    protected $tabela;

    public function __construct($tabela, $name = NULL)
    {

        parent::__construct($name);

        // config form atributes
        $this->setAttributes([
            'method'    => 'POST',
            'class'     => 'form-horizontal',
        ]);

        switch($tabela){
            case 'dados_pessoais':
                // elemento do tipo hidden
                $this->add([
                    'type' => 'Hidden', # ou 'type' => 'ZendFormElementHidden'
                    'name' => 'id_pessoa',
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'nome_pessoa',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputNomePessoa',
                        'placeholder'   => 'Digite seu nome Completo.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'Text'
                    'name' => 'cpf',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputCpf',
                        'placeholder'   => 'Digite seu cpf.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'Text'
                    'name' => 'identidade',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputIdentidade',
                        'placeholder'   => 'Digite sua identidade.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'Text'
                    'name' => 'endereco',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputEndereco',
                        'placeholder'   => 'Digite seu endereço completo.',
                    ],
                ]);

                //---------
                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'Text'
                    'name' => 'logradouro',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputLogradouro',
                        'placeholder'   => 'Digite sua rua, av...',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'number', # ou 'type' => 'Text'
                    'name' => 'numero',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputNumero',
                        'placeholder'   => 'Numero.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'number', # ou 'type' => 'Text'
                    'name' => 'apto',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputApto',
                        'placeholder'   => 'Numero.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'Text'
                    'name' => 'bairro',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputBairro',
                        'placeholder'   => 'Digite o nome do seu bairro.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'Text'
                    'name' => 'cidade',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputCidade',
                        'value' => '',
                        'placeholder'   => 'Digite o nome da sua cidade.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'Text'
                    'name' => 'estado',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputEstado',
                        'value' => '',
                        'placeholder'   => 'Digite o nome do seu estado.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'Text'
                    'name' => 'cep',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputCep',
                        'value' => '',
                        'placeholder'   => 'Digite seu cep.',
                    ],
                ]);
                //------

                // elemento do tipo date
                $this->add([
                    'type' => 'Date', # ou 'type' => 'Text'
                    'name' => 'data_nasc',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputDataNasc',
                        'placeholder'   => 'Digite sua data de nascimento.',
                    ],
                ]);

                // elemento do tipo email
                $this->add([
                    'type' => 'Email', # ou 'type' => 'Text'
                    'name' => 'email',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputEmail',
                        'placeholder'   => 'Digite seu email.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'Text'
                    'name' => 'telefone_principal',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputTelefonePrincipal',
                        'placeholder'   => 'Digite seu telefone principal.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'Text'
                    'name' => 'telefone_secundario',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputTelefoneSecundario',
                        'placeholder'   => 'Digite seu telefone secundário(opcional).',
                    ],
                ]);

                $this->add([
                    'type' => 'Radio',
                    'name' => 'sexo',
                    'options' => [
                        'label' => 'Informe seu sexo.',
                        'value_options' => [
                            ['value' => 'Masculino',
                                'label' => 'Masculino',
                                'selected' => false,
                                'disabled' => false,
                            ],
                            ['value' => 'Feminino',
                                'label' => 'Feminino',
                                'selected' => false,
                                'disabled' => false,
                            ],
                        ],
                    ],
                ]);

                $this->add([
                    'type' => 'Radio',
                    'name' => 'situacao',
                    'options' => [
                        'label' => 'Informe sua situação.',
                        'value_options' => [
                            ['value' => 'Ativo',
                                'label' => 'Ativo',
                                'selected' => true,
                                'disabled' => false,
                            ],
                            ['value' => 'Inativo',
                                'label' => 'Inativo',
                                'selected' => false,
                                'disabled' => false,
                            ],
                        ],
                    ],
                ]);
                break;

            case 'cursos':
                // elemento do tipo hidden
                $this->add([
                    'type' => 'Hidden', # ou 'type' => 'ZendFormElementHidden'
                    'name' => 'id_curso',
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'nome_curso',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputNomeCurso',
                        'placeholder'   => 'Digite o nome do curso.',
                    ],
                ]);

                $this->add([
                    'type' => 'Radio',
                    'name' => 'turno',
                    'options' => [
                        'label' => 'Informe o turno do curso.',
                        'value_options' => [
                            ['value' => 'Manha',
                                'label' => 'Manha',
                                'selected' => false,
                                'disabled' => false,
                            ],
                            ['value' => 'Tarde',
                                'label' => 'Tarde',
                                'selected' => false,
                                'disabled' => false,
                            ],
                            ['value' => 'Noite',
                                'label' => 'Noite',
                                'selected' => false,
                                'disabled' => false,
                            ],
                        ],
                    ],
                ]);

                $this->add([
                    'type' => 'Radio',
                    'name' => 'tipo',
                    'options' => [
                        'label' => 'Informe o tipo de curso.',
                        'value_options' => [
                            ['value' => 'Interno',
                                'label' => 'Interno',
                                'selected' => true,
                                'disabled' => false,
                            ],
                            ['value' => 'Comunidade',
                                'label' => 'Comunidade',
                                'selected' => false,
                                'disabled' => false,
                            ],
                        ],
                    ],
                ]);
                break;
            case 'series':
                // elemento do tipo hidden
                $this->add([
                    'type' => 'Hidden', # ou 'type' => 'ZendFormElementHidden'
                    'name' => 'id_serie',
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'nome_serie',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputNomeSerie',
                        'placeholder'   => 'Digite o nome da serie.',
                    ],
                ]);

                // elemento do tipo select
                /*$this->add([
                    'type' => 'Select',
                    'name' => 'nome_serie',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'selectSituacao',
                    ],
                    'options' => [
                        'label' => 'Situacao',
                        'empty_option' => 'Selecione uma opção',
                        'value_options' => [
                            '1' => '1º ano',
                            '2' => '2º ano',
                        ],
                    ]
                ]);*/

                $this->add([
                    'type' => 'Radio',
                    'name' => 'subtipo',
                    'options' => [
                        'label' => 'Informe o subtipo da serie.',
                        'value_options' => [
                            ['value' => 'A',
                                'label' => 'A',
                                'selected' => false,
                                'disabled' => false,
                            ],
                            ['value' => 'B',
                                'label' => 'B',
                                'selected' => false,
                                'disabled' => false,
                            ],
                            ['value' => 'C',
                                'label' => 'C',
                                'selected' => false,
                                'disabled' => false,
                            ],
                            ['value' => 'D',
                                'label' => 'D',
                                'selected' => false,
                                'disabled' => false,
                            ],
                        ],
                    ],
                ]);
                break;
            case 'materias':
                // elemento do tipo hidden
                $this->add([
                    'type' => 'Hidden', # ou 'type' => 'ZendFormElementHidden'
                    'name' => 'id_materia',
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'nome_materia',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputNomeMateria',
                        'placeholder'   => 'Digite o nome da matéria.',
                    ],
                ]);

                // elemento do tipo select
                $this->add([
                    'type' => 'Select',
                    'name' => 'tipo_materia',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'selectTipoMateria',
                    ],
                    'options' => [
                        'label' => 'Situacao',
                        'empty_option' => 'Selecione uma opção',
                        'value_options' => [
                            'Anual' => 'Anual',
                            'Semestral' => 'Semestral',
                            'Trimestral' => 'Trimestral',
                        ],
                    ]
                ]);

                $this->add([
                    'type' => 'Date', # ou 'type' => 'Text'
                    'name' => 'ano',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputAno',
                        'placeholder'   => 'Digite o ano.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'nome_professor',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputNomeProfessor',
                        'placeholder'   => 'Digite o nome do professor.',
                    ],
                ]);
                break;
            case 'usuarios':
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
                break;
            case 'funcionarios':
            //// elemento do tipo hidden
                $this->add([
                    'type' => 'Hidden', # ou 'type' => 'ZendFormElementHidden'
                    'name' => 'id_funcionario',
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'nome_funcionario',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputNomeFuncionario',
                        'placeholder'   => 'Digite o nome do funcionario.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'formacao',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputFormacao',
                        'placeholder'   => 'Digite a sua formação.',
                    ],
                ]);

                // elemento do tipo select
                $this->add([
                    'type' => 'Select',
                    'name' => 'cargo_funcionario',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'selectCargoFuncioanrio',
                    ],
                    'options' => [
                        'label' => 'Selecione o Cargo',
                        'empty_option' => 'Selecione uma opção',
                        'value_options' => [
                            '1' => 'Cargo1',
                            '2' => 'Cargo2',
                            '3' => 'Cargo3',
                        ],
                    ]
                ]);

                // elemento do tipo textarea
                $this->add([
                    'type' => 'Textarea', # ou 'type' => 'ZendFormElementText'
                    'name' => 'especialidade',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputEspecialidade',
                        'placeholder' => 'Descreva a(s) especialidade(s)',
                    ],
                ]);
                break;
            case 'cargos_funcionarios':
                //// elemento do tipo hidden
                $this->add([
                    'type' => 'Hidden', # ou 'type' => 'ZendFormElementHidden'
                    'name' => 'id_cargo_funcionario',
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'nome_cargo_funcionario',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputNomeCargoFuncionario',
                        'placeholder'   => 'Digite o nome do cargo do funcionario.',
                    ],
                ]);
                break;
            case 'alunos':
                // elemento do tipo hidden
                $this->add([
                    'type' => 'Hidden', # ou 'type' => 'ZendFormElementHidden'
                    'name' => 'id_aluno',
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'nome_aluno',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputNomeAluno',
                        'placeholder'   => 'Digite o nome do aluno.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'matricula_aluno',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputMatriculaAluno',
                        'placeholder'   => 'Digite a matricula do aluno.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'curso_aluno',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputCursoAluno',
                        'placeholder'   => 'Digite a curso do aluno.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'serie_aluno',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputSerieAluno',
                        'placeholder'   => 'Digite a serie do aluno.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'materia_aluno',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputMateriaAluno',
                        'placeholder'   => 'Digite a materia do aluno.',
                    ],
                ]);

                // elemento do tipo text
                $this->add([
                    'type' => 'Text', # ou 'type' => 'ZendFormElementText'
                    'name' => 'professor_aluno',
                    'attributes' => [
                        'class'         => 'form-control',
                        'id'            => 'inputProfessorAluno',
                        'placeholder'   => 'Digite a professor do aluno.',
                    ],
                ]);
                break;
        }

        /*
        // elemento do tipo select
        $this->add([
            'type' => 'Select',
            'name' => 'situacao',
            'attributes' => [
                'class'         => 'form-control',
                'id'            => 'selectSituacao',
            ],
            'options' => [
                'label' => 'Situacao',
                'empty_option' => 'Selecione uma opção',
                'value_options' => [
                    '1' => 'Aluno',
                    '2' => 'Ex-Aluno',
                ],
            ]
        ]);


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
        );*/

        // elemento para evitar ataques Cross-Site Request Forgery
        //$this->add(new Element\Csrf('security'));
    }
}