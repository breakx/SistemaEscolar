<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:45
 */

// namespace de localizacao do nosso model
namespace Curso\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;

// import for fetchPaginator
use Zend\Db\Sql\Select,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

use Zend\Mvc\Controller\AbstractActionController;

class CursoTable extends AbstractActionController
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
     * Recuperar todos os elementos da tabela cursos
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id_curso da tabela cursos
     *
     * @param type $id
     * @return ModelCurso
     * @throws Exception
     */
    public function find($id_curso)
    {
        $id_curso  = (int) $id_curso;
        $rowset = $this->tableGateway->select(array('id_curso' => $id_curso));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Não foi encontrado contado de id_curso = {$id_curso}");
        }

        return $row;
    }

    /**
     * @param Curso $curso
     */
    function save(Curso $curso)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $timeNow = new \DateTime();

        $data = [
            'nome_curso'                  => $curso->nome_curso,
            'turno'                  => $curso->turno,
            'tipo'                  => $curso->tipo,
        ];

        $this->tableGateway->insert($data);
        $this->flashMessenger()
            ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> Curso adicionado com sucesso!');
    }

    /**
     * Atualizar um curso existente
     *
     * @param Curso\Model\Curso $curso
     * @throws Exception
     */
    public function update(Curso $curso)
    {
        $timeNow = new \DateTime();

        $data = [
            'nome_curso'                  => $curso->nome_curso,
            'turno'                  => $curso->turno,
            'tipo'                  => $curso->tipo,
        ];

        $id_curso = (int) $curso->id_curso;
        if ($this->find($id_curso)) {
            $this->tableGateway->update($data, array('id_curso' => $id_curso));
            $this->flashMessenger()
                ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> Curso atualizado com sucesso!');
        } else {
            throw new Exception("Curso #{$id_curso} inexistente");
        }
    }

    /**
     * Deletar um curso existente
     *
     * @param type $id_curso
     */
    public function delete($id_curso)
    {
        $this->tableGateway->delete(array('id_curso' => (int) $id_curso));
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
        // preparar um select para tabela curso com uma ordem
        $select = (new Select('cursos'))->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_curso', "%{$like}%")
                ->or
                ->like('nome_curso', "%{$like}%")
                ->or
                ->like('turno', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Curso());

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
     * Localizar cursos pelo nome
     *
     * @param type $nome
     * @return type Array
     */
    public function search($nome)
    {
        // preparar objeto SQL
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new \Zend\Db\Sql\Sql($adapter);

        // montagem do select com where, like e limit para tabela curso
        $select = (new Select('cursos'))->limit(8);
        $select
            ->columns(array('id_curso', 'nome_curso'))
            ->where
            ->like('nome_curso', "%{$nome}%")
        ;

        // executar select
        $statement = $sql->getSqlStringForSqlObject($select);
        $results   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}