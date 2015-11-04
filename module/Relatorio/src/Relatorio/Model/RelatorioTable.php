<?php
/**
 * Created by PhpStorm.
 * User: LK
 * Date: 05/10/2015
 * Time: 19:36
 */

namespace Relatorio\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select,
    Zend\Db\Sql\Sql,
    Zend\Db\Sql\Predicate,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

class RelatorioTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getRelatorio($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('$id_pessoa' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
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
        // preparar um select para tabela dado-pessoal com uma ordem
        $select = (new Select('dados_pessoais'))->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('nome_pessoa', "%{$like}%")
                ->or
                ->like('telefone_principal', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Relatorio());

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

    public function getSelect($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id_pessoa' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
}