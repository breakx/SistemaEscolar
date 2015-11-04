<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 27/09/2015
 * Time: 08:45
 */

// namespace de localizacao do nosso model
namespace Usuario\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;

// import for fetchPaginator
use Zend\Db\Sql\Select,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

use Zend\Mvc\Controller\AbstractActionController;

class UsuarioTable extends AbstractActionController
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
     * Recuperar todos os elementos da tabela usuarios
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id_usuario da tabela usuario
     *
     * @param $id_usuario
     * @return array|\ArrayObject|null
     * @throws \Exception
     */
    public function find($id_usuario)
    {
        $id_usuario  = (int) $id_usuario;
        $rowset = $this->tableGateway->select(array('id_usuario' => $id_usuario));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não foi encontrado contado de id_usuario = {$id_usuario}");
        }

        return $row;
    }

    /**
     * @param Usuario $usuario
     */
    function save(Usuario $usuario)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $timeNow = new \DateTime();

        $data = [
            'matricula'                  => $usuario->matricula,
            'senha'                  => $usuario->senha,
        ];

        $this->tableGateway->insert($data);

        $this->flashMessenger()
            ->addSuccessMessage('<i class="glyphicon glyphicon-ok"></i> Usuario adicionado com sucesso!');
    }

    /**
     * Atualizar um usuarios existente
     *
     * @param Usuario $usuario
     * @throws \Exception
     */
    public function update(Usuario $usuario)
    {
        $timeNow = new \DateTime();

        $data = [
            'matricula'                  => $usuario->matricula,
            'senha'                  => $usuario->senha,
        ];

        $id_usuario = (int) $usuario->id_usuario;
        if ($this->find($id_usuario)) {
            $this->tableGateway->update($data, array('id_usuario' => $id_usuario));
        } else {
            throw new \Exception("Usuario #{$id_usuario} inexistente");
        }
    }

    /**
     * Deletar um usuario existente
     *
     * @param type $id_usuario
     */
    public function delete($id_usuario)
    {
        $this->tableGateway->delete(array('id_usuario' => (int) $id_usuario));
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
        // preparar um select para tabela usuarios com uma ordem
        $select = (new Select('usuarios'))->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_usuario', "%{$like}%")
                ->or
                ->like('matricula', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Usuario());

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
     * Localizar usuarios pelo nome
     *
     * @param type $nome
     * @return type Array
     */
    public function search($nome)
    {
        // preparar objeto SQL
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new \Zend\Db\Sql\Sql($adapter);

        // montagem do select com where, like e limit para tabela usuarios
        $select = (new Select('usuarios'))->limit(8);
        $select
            ->columns(array('id_usuario', 'matricula'))
            ->where
            ->like('matricula', "%{$nome}%")
        ;

        // executar select
        $statement = $sql->getSqlStringForSqlObject($select);
        $results   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}