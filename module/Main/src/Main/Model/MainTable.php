<?php
/**
 * Created by PhpStorm.
 * User: Cristiano GD
 * Date: 16/10/2015
 * Time: 09:33
 */

// namespace de localizacao do nosso model
namespace Main\Model;

// import ZendDb
use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

use Zend\Mvc\Controller\AbstractActionController;

class MainTable extends AbstractActionController
{
    protected $tableGateway;

    /**
     * Contrutor com dependencia da classe TableGateway
     *
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Recuperar todos os elementos da tabela contatos
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id da tabela contatos
     *
     * @param type $id
     * @return ModelContato
     * @throws \Exception
     */
    public function find($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não foi encontrado contado de id = {$id}");
        }

        return $row;
    }

    /**
     * Inserir uma nova informação
     *
     * @param Main|Main\Model\Main $main
     * @param $tabela
     * @return int 1/0
     */
    public function save(Main $main, $tabela)
    {
        $msg="";
        $error="";
        $row = false;
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $timeNow = new \DateTime();

        switch($tabela){
            case 'dados_pessoais':
                $data = [
                    'nome_pessoa'                  => $main->nome_pessoa,
                    'cpf'                  => $main->cpf,
                    'identidade'                  => $main->identidade,
                    'endereco'                  => $main->endereco,

                    'logradouro'                  => $main->logradouro,
                    'numero'                  => $main->numero,
                    'apto'                  => $main->apto,
                    'bairro'                  => $main->bairro,
                    'cidade'                  => $main->cidade,
                    'estado'                  => $main->estado,
                    'cep'                  => $main->cep,

                    'data_nasc'                  => $main->data_nasc,
                    'email'                  => $main->email,
                    'telefone_principal'    => $main->telefone_principal,
                    'telefone_secundario'    => $main->telefone_secundario,
                    'sexo'                  => $main->sexo,
                    'situacao'                  => $main->situacao,
                    'data_cadastro'          => $timeNow->format('Y-m-d H:i:s'),
                ];
                $msg="Dados pessoais adicionados com sucesso!";
                $error="CPF ".$main->cpf." ja cadastrado";

                $rowset = $this->tableGateway->select(['cpf' => $main->cpf]);
                $row = $rowset->current();
                break;

            case 'cursos':
                $data = [
                    'nome_curso'                  => $main->nome_curso,
                    'turno'                  => $main->turno,
                    'tipo'                  => $main->tipo,
                ];
                $msg="Curso adicionado com sucesso!";
                break;
            case 'series':
                $data = [
                    'nome_serie'                  => $main->nome_serie,
                    'subtipo'                  => $main->subtipo,
                ];
                $msg="Serie adicionada com sucesso!";
                break;
            case 'materias':
                $data = [
                    'nome_materia'                  => $main->nome_materia,
                    'ano'                  => $main->ano,
                    'tipo_materia'                  => $main->tipo_materia,
                    'nome_professor'                  => $main->nome_professor,
                ];
                $msg="Materia adicionada com sucesso!";
                break;
            case 'usuarios':
                $data = [
                    'matricula'                  => $main->matricula,
                    'senha'                  => $main->senha,
                ];
                $msg="Usuario adicionado com sucesso!";
                break;
            case 'tipo_usuarios':
                $data = [
                    'nome_tipo_usuario'                  => $main->nome_tipo_usuario,
                ];
                $msg="Tipo de Usuario adicionado com sucesso!";
                break;
            case 'funcionarios':
                $data = [
                    'nome_funcionario'                  => $main->nome_funcionario,
                    'formacao'                  => $main->formacao,
                    'cargo_funcionario'                  => $main->cargo_funcionario,
                    'especialidade'                  => $main->especialidade,
                ];
                $msg="Funciaonario adicionado com sucesso!";
                break;
            case 'cargo_funcionarios':
                $data = [
                    'nome_cargo_funcionario'                  => $main->nome_funcionario,
                ];
                $msg="Funciaonario adicionado com sucesso!";
                break;
            case 'alunos':
                $data = [
                    'nome_aluno'                  => $main->nome_aluno,
                    'matricula_aluno'                  => $main->matricula_aluno,
                    'curso_aluno'                  => $main->curso_aluno,
                    'serie_aluno'                  => $main->serie_aluno,
                    'materia_aluno'                  => $main->materia_aluno,
                    'curso_aluno'                  => $main->curso_aluno,
                    'professor_aluno'                  => $main->professor_aluno,
                    /*'nota1'                  => $main->nota1,
                    'nota2'                  => $main->nota2,
                    'nota3'                  => $main->nota3,
                    'nota4'                  => $main->nota4,
                    'trabalho1'                  => $main->trabalho1,
                    'trabalho2'                  => $main->trabalho2,
                    'trabalho3'                  => $main->trabalho3,
                    'trabalho4'                  => $main->trabalho4,*/
                ];
                $msg="Aluno adicionado com sucesso!";
                break;
        }

        if (!$row) {
            //throw new \Exception('CPF '.$main->cpf. ' nao cadastrado');
            $this->tableGateway->insert($data);

            $this->flashMessenger()
                ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> ' . $msg);
        }else{
            //throw new \Exception('CPF '.$main->cpf. ' ja cadastrado');
            $this->flashMessenger()
                ->addErrorMessage('<i class="glyphicon glyphicon-remove"></i> ' . $error);
        }

        return $this;
    }
}