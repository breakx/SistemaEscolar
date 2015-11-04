<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:45
 */

// namespace de localizacao do nosso model
namespace Materia\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;

// import for fetchPaginator
use Zend\Db\Sql\Select,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

use Zend\Mvc\Controller\AbstractActionController;

class MateriaTable extends AbstractActionController
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
     * Recuperar todos os elementos da tabela materias
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id_materia da tabela materia
     *
     * @param type $id
     * @return ModelMateria
     * @throws Exception
     */
    public function find($id_materia)
    {
        $id_materia  = (int) $id_materia;
        $rowset = $this->tableGateway->select(array('id_materia' => $id_materia));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Não foi encontrado contado de id_materia = {$id_materia}");
        }

        return $row;
    }


    /**
     * @param Materia $materia
     */
    function save(Materia $materia)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $timeNow = new \DateTime();

        $data = [
            'nome_materia'                  => $materia->nome_materia,
            'ano'                  => $materia->ano,
            'tipo_materia'                  => $materia->tipo_materia,
            'nome_professor'                  => $materia->nome_professor,
        ];
        $this->tableGateway->insert($data);

        $this->flashMessenger()
            ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> Materia adicionada com sucesso!');
    }


    /**
     * @param Materia $materia
     * @throws Exception
     */
    public function update(Materia $materia)
    {
        $timeNow = new \DateTime();

        $data = [
            'nome_materia'                  => $materia->nome_materia,
            'ano'                  => $materia->ano,
            'tipo_materia'                  => $materia->tipo_materia,
            'nome_professor'                  => $materia->nome_professor,
        ];

        $id_materia = (int) $materia->id_materia;
        if ($this->find($id_materia)) {
            $this->tableGateway->update($data, array('id_materia' => $id_materia));
        } else {
            throw new Exception("Materia #{$id_materia} inexistente");
        }
    }

    /**
     * Deletar um materia existente
     *
     * @param type $id_materia
     */
    public function delete($id_materia)
    {
        $this->tableGateway->delete(array('id_materia' => (int) $id_materia));
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
        // preparar um select para tabela materias com uma ordem
        $select = (new Select('materias'))->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_materia', "%{$like}%")
                ->or
                ->like('nome_materia', "%{$like}%")
                ->or
                ->like('professor', "%{$like}%")
                ->or
                ->like('ano', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Materia());

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
     * Localizar materia pelo nome
     *
     * @param type $nome
     * @return type Array
     */
    public function search($nome)
    {
        // preparar objeto SQL
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new \Zend\Db\Sql\Sql($adapter);

        // montagem do select com where, like e limit para tabela materias
        $select = (new Select('materias'))->limit(8);
        $select
            ->columns(array('id_materia', 'nome_materia'))
            ->where
            ->like('nome_materia', "%{$nome}%")
        ;

        // executar select
        $statement = $sql->getSqlStringForSqlObject($select);
        $results   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}