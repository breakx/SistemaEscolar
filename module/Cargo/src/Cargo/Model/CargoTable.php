<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:45
 */

// namespace de localizacao do nosso model
namespace Cargo\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;

// import for fetchPaginator
use Zend\Db\Sql\Select,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

use Zend\Mvc\Controller\AbstractActionController;

class CargoTable extends AbstractActionController
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
     * Recuperar todos os elementos da tabela cargo
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id_cargo da tabela cargos
     *
     * @param $id_cargo
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function find($id_cargo)
    {
        $id_cargo  = (int) $id_cargo;
        $rowset = $this->tableGateway->select(array('id_cargo' => $id_cargo));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não foi encontrado contado de id_cargo = {$id_cargo}");
        }

        return $row;
    }

    /**
     * @param Cargo $cargo
     */
    function save(Cargo $cargo)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $timeNow = new \DateTime();

        $data = [
            'nome_cargo'                  => $cargo->nome_cargo,
        ];

        $this->tableGateway->insert($data);

        $this->flashMessenger()
            ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> Cargo Funciaonario adicionado com sucesso!');
    }

    /**
     * Atualizar um cargo existente
     *
     * @param Cargo $cargo
     * @throws \Exception
     */
    public function update(Cargo $cargo)
    {
        $timeNow = new \DateTime();

        $data = [
            'nome_cargo'                  => $cargo->nome_cargo,
        ];

        $id_cargo = (int) $cargo->id_cargo;
        if ($this->find($id_cargo)) {
            $this->tableGateway->update($data, array('id_cargo' => $id_cargo));
        } else {
            throw new \Exception("Cargo #{$id_cargo} inexistente");
        }
    }

    /**
     * Deletar um cargos existente
     *
     * @param type $id_cargo
     */
    public function delete($id_cargo)
    {
        $this->tableGateway->delete(array('id_cargo' => (int) $id_cargo));
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
        // preparar um select para tabela cargos com uma ordem
        $select = (new Select('cargos'))->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_cargo', "%{$like}%")
                ->or
                ->like('nome_cargo', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Cargo());

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
     * Localizar cargos pelo nome
     *
     * @param type $nome
     * @return type Array
     */
    public function search($nome)
    {
        // preparar objeto SQL
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new \Zend\Db\Sql\Sql($adapter);

        // montagem do select com where, like e limit para tabela cargos
        $select = (new Select('cargos'))->limit(8);
        $select
            ->columns(array('id_cargo', 'nome_cargo'))
            ->where
            ->like('nome_cargo', "%{$nome}%")
        ;

        // executar select
        $statement = $sql->getSqlStringForSqlObject($select);
        $results   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}