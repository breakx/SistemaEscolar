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
                $error="CPF ".$main->cpf." ja cadastrado";
                $row = false;
                break;
            case 'series':
                ///
                break;
            case 'materias':
                //
                break;
            case 'usuarios':
                //
                break;
            case 'funcionarios':
                //
                break;
            case 'alunos':
                //
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