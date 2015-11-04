<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:45
 */

// namespace de localizacao do nosso model
namespace Aluno\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;

// import for fetchPaginator
use Zend\Db\Sql\Select,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

use Zend\Mvc\Controller\AbstractActionController;

class AlunoTable extends AbstractActionController
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
     * Recuperar todos os elementos da tabela alunos
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id_aluno da tabela aluno
     *
     * @param $id_aluno
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function find($id_aluno)
    {
        $id_aluno  = (int) $id_aluno;
        $rowset = $this->tableGateway->select(array('id_aluno' => $id_aluno));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não foi encontrado contado de id_aluno = {$id_aluno}");
        }

        return $row;
    }

    /**
     * @param Aluno $aluno
     */
    function save(Aluno $aluno)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $timeNow = new \DateTime();

        $data = [
            'nome_aluno'                  => $aluno->nome_aluno,
            'matricula_aluno'                  => $aluno->matricula_aluno,
            'curso_aluno'                  => $aluno->curso_aluno,
            'serie_aluno'                  => $aluno->serie_aluno,
            'materia_aluno'                  => $aluno->materia_aluno,
            'professor_aluno'                  => $aluno->professor_aluno,
            'prova1'                  => 0.0,
            'prova2'                  => 0.0,
            'prova3'                  => 0.0,
            'prova4'                  => 0.0,
            'trabalho1'                  => 0.0,
            'trabalho2'                  => 0.0,
            'trabalho3'                  => 0.0,
            'trabalho4'                  => 0.0,
            'faltas'                  => 0,
            'situacao_aluno'                  => $aluno->situacao_aluno,
        ];

        $this->tableGateway->insert($data);

        $this->flashMessenger()
            ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> Aluno adicionado com sucesso!');
    }

    /**
     * Atualizar um alunos existente
     *
     * @param Aluno $aluno
     * @throws Exception
     * @throws \Exception
     */
    public function update(Aluno $aluno)
    {
        $timeNow = new \DateTime();

        $data = [
            'nome_aluno'                  => $aluno->nome_aluno,
            'matricula_aluno'                  => $aluno->matricula_aluno,
            'curso_aluno'                  => $aluno->curso_aluno,
            'serie_aluno'                  => $aluno->serie_aluno,
            'materia_aluno'                  => $aluno->materia_aluno,
            'professor_aluno'                  => $aluno->professor_aluno,
            'prova1'                  => $aluno->prova1,
            'prova2'                  => $aluno->prova2,
            'prova3'                  => $aluno->prova3,
            'prova4'                  => $aluno->prova4,
            'trabalho1'                  => $aluno->trabalho1,
            'trabalho2'                  => $aluno->trabalho2,
            'trabalho3'                  => $aluno->trabalho3,
            'trabalho4'                  => $aluno->trabalho4,
            'faltas'                  => $aluno->faltas,
            'situacao_aluno'                  => $aluno->situacao_aluno,
        ];

        $id_aluno = (int) $aluno->id_aluno;
        if ($this->find($id_aluno)) {
            $this->tableGateway->update($data, array('id_aluno' => $id_aluno));
        } else {
            throw new \Exception("Aluno #{$id_aluno} inexistente");
        }
    }

    /**
     * Deletar um aluno existente
     *
     * @param type $id_aluno
     */
    public function delete($id_aluno)
    {
        $this->tableGateway->delete(array('id_aluno' => (int) $id_aluno));
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
        // preparar um select para tabela aluno com uma ordem
        $select = (new Select('alunos'))->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_aluno', "%{$like}%")
                ->or
                ->like('nome_aluno', "%{$like}%")
                ->or
                ->like('matricula_aluno', "%{$like}%")
                ->or
                ->like('curso_aluno', "%{$like}%")
                ->or
                ->like('serie_aluno', "%{$like}%")
                ->or
                ->like('materia_aluno', "%{$like}%")
                ->or
                ->like('professor_aluno', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Aluno());

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
     * Localizar alunos pelo nome
     *
     * @param type $nome
     * @return type Array
     */
    public function search($nome)
    {
        // preparar objeto SQL
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new \Zend\Db\Sql\Sql($adapter);

        // montagem do select com where, like e limit para tabela alunos
        $select = (new Select('alunos'))->limit(8);
        $select
            ->columns(array('id_aluno', 'nome_aluno'))
            ->where
            ->like('nome_aluno', "%{$nome}%")
        ;

        // executar select
        $statement = $sql->getSqlStringForSqlObject($select);
        $results   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}