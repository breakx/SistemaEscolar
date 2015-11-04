<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:45
 */

// namespace de localizacao do nosso model
namespace Funcionario\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;

// import for fetchPaginator
use Zend\Db\Sql\Select,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

use Zend\Mvc\Controller\AbstractActionController;

class FuncionarioTable extends AbstractActionController
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
     * Recuperar todos os elementos da tabela funcionario
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }


    /**
     * Localizar linha especifico pelo id_funcionario da tabela funcionarios
     *
     * @param $id_funcionario
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function find($id_funcionario)
    {
        $id_funcionario  = (int) $id_funcionario;
        $rowset = $this->tableGateway->select(array('id_funcionario' => $id_funcionario));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não foi encontrado contado de id_funcionario = {$id_funcionario}");
        }

        return $row;
    }

    /**
     * @param Funcionario $funcionario
     */
    function save(Funcionario $funcionario)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $timeNow = new \DateTime();

        $data = [
            'nome_funcionario'                  => $funcionario->nome_funcionario,
            'cargo_funcionario'                  => $funcionario->cargo_funcionario,
            'formacao'                  => $funcionario->formacao,
            'especialidade'                  => $funcionario->especialidade,
        ];

        $this->tableGateway->insert($data);

        $this->flashMessenger()
            ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> Funciaonario adicionado com sucesso!');
    }

    /**
     * Atualizar um funcionarios existente
     *
     * @param Funcionario $funcionario
     * @throws \Exception
     */
    public function update(Funcionario $funcionario)
    {
        $timeNow = new \DateTime();

        $data = [
            'nome_funcionario'                  => $funcionario->nome_funcionario,
            'cargo_funcionario'                  => $funcionario->cargo_funcionario,
            'formacao'                  => $funcionario->formacao,
            'especialidade'                  => $funcionario->especialidade,
        ];

        $id_funcionario = (int) $funcionario->id_funcionario;
        if ($this->find($id_funcionario)) {
            $this->tableGateway->update($data, array('id_funcionario' => $id_funcionario));
        } else {
            throw new \Exception("Funcionario #{$id_funcionario} inexistente");
        }
    }

    /**
     * Deletar um funcionarios existente
     *
     * @param $id_funcionario
     */
    public function delete($id_funcionario)
    {
        $this->tableGateway->delete(array('id_funcionario' => (int) $id_funcionario));
    }

    /**
     * Localizar itens por paginação
     *
     * @param int $pagina
     * @param int $itensPagina
     * @param string $ordem
     * @param null $like
     * @param int $itensPaginacao
     * @return Paginator
     */
    public function fetchPaginator($pagina = 1, $itensPagina = 10, $ordem = 'nome ASC', $like = null, $itensPaginacao = 5)
    {
        // preparar um select para tabela funcionarios com uma ordem
        $select = (new Select('funcionarios'))->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_funcionario', "%{$like}%")
                ->or
                ->like('nome_funcionario', "%{$like}%")
                ->or
                ->like('formacao', "%{$like}%")
                ->or
                ->like('especialidade', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Funcionario());

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
     * Localizar funcionarios pelo nome
     *
     * @param type $nome
     * @return type Array
     */
    public function search($nome)
    {
        // preparar objeto SQL
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new \Zend\Db\Sql\Sql($adapter);

        // montagem do select com where, like e limit para tabela funcionario
        $select = (new Select('funcionarios'))->limit(8);
        $select
            ->columns(array('id_funcionario', 'nome_funcionario'))
            ->where
            ->like('nome_funcionario', "%{$nome}%")
        ;

        // executar select
        $statement = $sql->getSqlStringForSqlObject($select);
        $results   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}