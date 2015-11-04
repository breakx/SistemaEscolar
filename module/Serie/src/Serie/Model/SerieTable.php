<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:45
 */

// namespace de localizacao do nosso model
namespace Serie\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;

// import for fetchPaginator
use Zend\Db\Sql\Select,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

use Zend\Mvc\Controller\AbstractActionController;

class SerieTable extends AbstractActionController
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
     * Recuperar todos os elementos da tabela serie
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id_serie da tabela serie
     *
     * @param $id_serie
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function find($id_serie)
    {
        $id_serie  = (int) $id_serie;
        $rowset = $this->tableGateway->select(array('id_serie' => $id_serie));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não foi encontrado contado de id_serie = {$id_serie}");
        }

        return $row;
    }

    /**
     * @param Serie $serie
     */
    function save(Serie $serie)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $timeNow = new \DateTime();

        $data = [
            'nome_serie'                  => $serie->nome_serie,
            'subtipo'                  => $serie->subtipo,
        ];

        $this->tableGateway->insert($data);
        $this->flashMessenger()
            ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> Serie adicionada com sucesso!');
    }

    /**
     * Atualizar um serie existente
     *
     * @param Serie $serie
     * @throws \Exception
     */
    public function update(Serie $serie)
    {
        $timeNow = new \DateTime();

        $data = [
            'nome_serie'                  => $serie->nome_serie,
            'subtipo'                  => $serie->subtipo,
        ];

        $id_serie = (int) $serie->id_serie;
        if ($this->find($id_serie)) {
            $this->tableGateway->update($data, array('id_serie' => $id_serie));
        } else {
            throw new \Exception("Serie #{$id_serie} inexistente");
        }
    }

    /**
     * Deletar um serie existente
     *
     * @param type $id_serie
     */
    public function delete($id_serie)
    {
        $this->tableGateway->delete(array('id_serie' => (int) $id_serie));
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
        // preparar um select para tabela serie com uma ordem
        $select = (new Select('series'))->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_serie', "%{$like}%")
                ->or
                ->like('nome_serie', "%{$like}%")
                ->or
                ->like('subserie', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Serie());

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
     * Localizar serie pelo nome
     *
     * @param type $nome
     * @return type Array
     */
    public function search($nome)
    {
        // preparar objeto SQL
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new \Zend\Db\Sql\Sql($adapter);

        // montagem do select com where, like e limit para tabela serie
        $select = (new Select('series'))->limit(8);
        $select
            ->columns(array('id_serie', 'nome_serie'))
            ->where
            ->like('nome_serie', "%{$nome}%")
        ;

        // executar select
        $statement = $sql->getSqlStringForSqlObject($select);
        $results   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}