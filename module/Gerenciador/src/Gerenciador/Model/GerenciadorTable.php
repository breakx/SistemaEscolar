<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:45
 */

// namespace de localizacao do nosso model
namespace Gerenciador\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;

// import for fetchPaginator
use Zend\Db\Sql\Select,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

use Zend\Mvc\Controller\AbstractActionController;

class GerenciadorTable extends AbstractActionController
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
     * Recuperar todos os elementos da tabela gerenciadores
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id_gerenciador da tabela gerenciadores
     *
     * @param $id_gerenciador
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function find($id_gerenciador)
    {
        $id_gerenciador  = (int) $id_gerenciador;
        $rowset = $this->tableGateway->select(array('id_gerenciador' => $id_gerenciador));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não foi encontrado contado de id_gerenciador = {$id_gerenciador}");
        }

        return $row;
    }

    /**
     * @param Gerenciador $gerenciador
     */
    function save(Gerenciador $gerenciador)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $timeNow = new \DateTime();

        $data = [
            'nome_gerenciador'                  => $gerenciador->nome_gerenciador,
        ];
        $this->tableGateway->insert($data);

        $this->flashMessenger()
            ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> Gerenciador adicionado com sucesso!');
    }

    /**
     * Atualizar um gerenciadores existente
     *
     * @param Gerenciador $gerenciador
     * @throws \Exception
     */
    public function update(Gerenciador $gerenciador)
    {
        $timeNow = new \DateTime();

        $data = [
            'nome_gerenciador'                  => $gerenciador->nome_gerenciador,
        ];

        $id_gerenciador = (int) $gerenciador->id_gerenciador;
        if ($this->find($id_gerenciador)) {
            $this->tableGateway->update($data, array('id_gerenciador' => $id_gerenciador));
        } else {
            throw new \Exception("Gerenciador #{$id_gerenciador} inexistente");
        }
    }

    /**
     * Deletar um gerenciadores existente
     *
     * @param type $id_gerenciador
     */
    public function delete($id_gerenciador)
    {
        $this->tableGateway->delete(array('id_gerenciador' => (int) $id_gerenciador));
    }

    /**
     * @param int $pagina
     * @param int $itensPagina
     * @param string $ordem
     * @param null $like
     * @param int $itensPaginacao
     * @return Paginator
     */
    public function fetchPaginator($pagina = 1, $itensPagina = 10, $ordem = 'nome ASC', $like = null, $itensPaginacao = 5)
    {
        // preparar um select para tabela gerenciadores com uma ordem
        $select = (new Select('gerenciadores'))->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_gerenciador', "%{$like}%")
                ->or
                ->like('nome_gerenciador', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Gerenciador());

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
     * Localizar gerenciadores pelo nome
     *
     * @param type $nome
     * @return type Array
     */
    public function search($nome)
    {
        // preparar objeto SQL
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new \Zend\Db\Sql\Sql($adapter);

        // montagem do select com where, like e limit para tabela gerenciadores
        $select = (new Select('dados_gerenciador'))->limit(8);
        $select
            ->columns(array('id_gerenciador', 'nome_gerenciador'))
            ->where
            ->like('nome_gerenciador', "%{$nome}%")
        ;

        // executar select
        $statement = $sql->getSqlStringForSqlObject($select);
        $results   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}