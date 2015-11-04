<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:45
 */

// namespace de localizacao do nosso model
namespace Pessoa\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;

// import for fetchPaginator
use Zend\Db\Sql\Select,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

use Zend\Mvc\Controller\AbstractActionController;

class PessoaTable extends AbstractActionController
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
     * Recuperar todos os elementos da tabela dadospessoais
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id_pessoa da tabela dadospessoais
     *
     * @param $id_pessoa
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function find($id_pessoa)
    {
        $id_pessoa  = (int) $id_pessoa;
        $rowset = $this->tableGateway->select(array('id_pessoa' => $id_pessoa));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não foi encontrado dados pessoais de id_pessoa = {$id_pessoa}");
        }
        return $row;
    }

    /**
     * @param Pessoa $pessoa
     */
    function save(Pessoa $pessoa)
    {
        $row = false;
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $timeNow = new \DateTime();

        $data = [
            'nome_pessoa'                  => $pessoa->nome_pessoa,
            'cpf'                  => $pessoa->cpf,
            'identidade'                  => $pessoa->identidade,
            'endereco'                  => $pessoa->endereco,

            'logradouro'                  => $pessoa->logradouro,
            'numero'                  => $pessoa->numero,
            'apto'                  => $pessoa->apto,
            'bairro'                  => $pessoa->bairro,
            'cidade'                  => $pessoa->cidade,
            'estado'                  => $pessoa->estado,
            'cep'                  => $pessoa->cep,

            'data_nasc'                  => $pessoa->data_nasc,
            'email'                  => $pessoa->email,
            'telefone_principal'    => $pessoa->telefone_principal,
            'telefone_secundario'    => $pessoa->telefone_secundario,
            'sexo'                  => $pessoa->sexo,
            //'situacao'                  => $pessoa->situacao,
            'data_cadastro'          => $timeNow->format('Y-m-d H:i:s'),
        ];

        $rowset = $this->tableGateway->select(['cpf' => $pessoa->cpf]);
        $row = $rowset->current();

        if (!$row) {
            //throw new \Exception('CPF '.$main->cpf. ' nao cadastrado');
            $this->tableGateway->insert($data);

            $this->flashMessenger()
                ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> Dados pessoais adicionados com sucesso!');
        }else{
            //throw new \Exception('CPF '.$main->cpf. ' ja cadastrado');
            $this->flashMessenger()
                ->addErrorMessage('<i class="glyphicon glyphicon-remove"></i> CPF '.$pessoa->cpf.' ja cadastrado');
        }
    }

    /**
     * Atualizar um dadospessoais existente
     *
     * @param Pessoa\Model\Pessoa $pessoa
     * @throws Exception
     */
    public function update(Pessoa $pessoa)
    {
        $timeNow = new \DateTime();

        $data = [
            'nome_pessoa'                  => $pessoa->nome_pessoa,
            'cpf'                  => $pessoa->cpf,
            'identidade'                  => $pessoa->identidade,
            'endereco'                  => $pessoa->endereco,

            'logradouro'                  => $pessoa->logradouro,
            'numero'                  => $pessoa->numero,
            'apto'                  => $pessoa->apto,
            'bairro'                  => $pessoa->bairro,
            'cidade'                  => $pessoa->cidade,
            'estado'                  => $pessoa->estado,
            'cep'                  => $pessoa->cep,

            'data_nasc'                  => $pessoa->data_nasc,
            'email'                  => $pessoa->email,
            'telefone_principal'    => $pessoa->telefone_principal,
            'telefone_secundario'    => $pessoa->telefone_secundario,
            'sexo'                  => $pessoa->sexo,
            //'situacao'                  => $pessoa->situacao,
            'data_cadastro'          => $timeNow->format('Y-m-d H:i:s'),
        ];

        $id_pessoa = (int) $pessoa->id_pessoa;
        if ($this->find($id_pessoa)) {
            $this->tableGateway->update($data, array('id_pessoa' => $id_pessoa));
        } else {
            throw new \Exception("Pessoa #{$id_pessoa} inexistente");
        }
    }

    /**
     * Deletar um dadospessoais existente
     *
     * @param type $id_pessoa
     */
    public function delete($id_pessoa)
    {
        $this->tableGateway->delete(array('id_pessoa' => (int) $id_pessoa));
    }

    /**
     * Localizar itens por paginação
     *
     * @param type $pagina
     * @param type $itensPagina
     * @param type $ordem
     * @param type $like
     * @param type $itensPaginacao
     * @return type Paginator
     */
    public function fetchPaginator($pagina = 1, $itensPagina = 10, $ordem = 'nome ASC', $like = null, $itensPaginacao = 5)
    {
        // preparar um select para tabela dadospessoais com uma ordem
        $select = (new Select('dados_pessoais'))->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_pessoa', "%{$like}%")
                ->or
                ->like('nome_pessoa', "%{$like}%")
                ->or
                ->like('cpf', "%{$like}%")
                ->or
                ->like('data_nasc', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Pessoa());

        // criar um objeto adapter paginator
        $paginatorAdapter = new DbSelect(
        // nosso objeto select
            $select,
            // nosso adapter da tabela
            $this->tableGateway->getAdapter(),
            // nosso objeto base para ser populado
            $resultSet
        );

        // resultado da paginação
        return (new Paginator($paginatorAdapter))
            // pagina a ser buscada
            ->setCurrentPageNumber((int) $pagina)
            // quantidade de itens na página
            ->setItemCountPerPage((int) $itensPagina)
            ->setPageRange((int) $itensPaginacao);
    }

    /**
     * Localizar dadospessoais pelo nome
     *
     * @param type $nome
     * @return type Array
     */
    public function search($nome)
    {
        // preparar objeto SQL
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new \Zend\Db\Sql\Sql($adapter);

        // montagem do select com where, like e limit para tabela dadospessoais
        $select = (new Select('dados_pessoais'))->limit(8);
        $select
            ->columns(array('id_pessoa', 'nome_pessoa'))
            ->where
            ->like('nome_pessoa', "%{$nome}%")
        ;

        // executar select
        $statement = $sql->getSqlStringForSqlObject($select);
        $results   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}