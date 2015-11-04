<?php
/**
 * Created by PhpStorm.
 * User: CristianoGD
 * Date: 26/09/2015
 * Time: 22:18
 */

/**
 * namespace de localizacao do nosso controller
 */
namespace Usuario\Controller;

// import ZendMvc
use Zend\Mvc\Controller\AbstractActionController;

// import ZendView
use Zend\View\Model\ViewModel;

// imort ModelUsuarioTable com alias
use Usuario\Model\UsuarioTable as ModelUsuario;

// import UsuarioForm
use Usuario\Form\UsuarioForm;

// import ModelUsuario
use Usuario\Model\Usuario;

class UsuariosController extends AbstractActionController
{
    protected $usuarioTable;

    // GET /usuarios
    public function indexAction()
    {
        return new ViewModel();
    }

    // GET /usuarios
    public function mainAction()
    {
        // colocar parametros da url em um array
        $paramsUrl = [
            'pagina_atual'  => $this->params()->fromQuery('pagina', 1),
            'itens_pagina'  => $this->params()->fromQuery('itens_pagina', 10),
            'coluna_nome'   => $this->params()->fromQuery('coluna_nome', 'matricula'),
            'coluna_sort'   => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search'        => $this->params()->fromQuery('search', null),
        ];

        // configuar método de paginação
        $paginacao = $this->getUsuarioTable()->fetchPaginator(
            /* $pagina */           $paramsUrl['pagina_atual'],
            /* $itensPagina */      $paramsUrl['itens_pagina'],
            /* $ordem */            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            /* $search */           $paramsUrl['search'],
            /* $itensPaginacao */   5
        );

        // retonar paginação mais os params de url para view
        return new ViewModel(['usuarios' => $paginacao] + $paramsUrl);
    }

    // GET /usuarios/novo
    public function novoAction()
    {
        return ['formUsuarios' => new UsuarioForm()];
    }

    // POST /usuarios/adicionar
    public function adicionarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new UsuarioForm();
            // instancia model usuario com regras de filtros e validações
            $modelUsuario = new Usuario();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity usuario
            $form->setInputFilter($modelUsuario->getInputFilter());
            // passa para o objeto formulário os usuario vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os usuario à tabela no banco
                // 1 - popular model com valores do formulário
                $modelUsuario->exchangeArray($form->getData());
                // 2 - persistir usuario do model para banco de usuario
                $this->getUsuarioTable()->save($modelUsuario);

                // redirecionar para action index no controller usuarios
                return $this->redirect()->toRoute('usuarios', ['action' => 'main']);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formUsuarios', $form)
                    ->setTemplate('usuario/usuarios/novo');
            }
        }
    }

    // GET /usuarios/detalhes/id
    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para usuario
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Usuario não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('usuarios', ['action' => 'main']);
        }

        try {
            // aqui vai a lógica para pegar os usuarios referente ao usuarios
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com usuarios desse usuarios encontrado
            // formulário com usuarios preenchidos

            // lógica cache objeto usuarios
            $nome_cache_usuario_id = "nome_cache_usuario_{$id}";
            if (!$this->cache()->hasItem($nome_cache_usuario_id)) {
                $usuario = $this->getUsuarioTable()->find($id);

                $this->cache()->setItem($nome_cache_usuario_id, $usuario);
            } else {
                $usuario = $this->cache()->getItem($nome_cache_usuario_id);
            }
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('usuarios', ['action' => 'main']);
        }

        // usuario eviados para detalhes.phtml
        return (new ViewModel())
            ->setTerminal($this->getRequest()->isXmlHttpRequest())
            ->setVariable('usuarios', $usuario)
            ;
    }

    // GET /usuarios/editar/id
    public function editarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para usuarios
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Usuario não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('usuarios', ['action' => 'main']);
        }

        try {
            // variável com objeto usuarios localizado
            $usuario = (array) $this->getUsuarioTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('usuarios', ['action' => 'main']);
        }

        // objeto form usuario vazio
        $form = new UsuarioForm();
        // popula objeto form usuario com objeto model usuario
        $form->setData($usuario);

        // usuario eviados para editar.phtml
        return ['formUsuarios' => $form];
    }

    // POST /usuarios/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new UsuarioForm();
            // instancia model usuario com regras de filtros e validações
            $modelUsuario = new Usuario();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity usuario
            $form->setInputFilter($modelUsuario->getInputFilter());
            // passa para o objeto formulário os usuario vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para atualizar os usuarios à tabela no banco
                // 1 - popular model com valores do formulário
                $modelUsuario->exchangeArray($form->getData());
                // 2 - atualizar usuarios do model para banco de usuarios
                $this->getUsuarioTable()->update($modelUsuario);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                    ->addSuccessMessage("Usuario editado com sucesso");

                $nome_cache_usuario_id = "nome_cache_usuario_{$modelUsuario->id_usuario}";
                if ($this->cache()->hasItem($nome_cache_usuario_id)) {
                    $this->cache()->removeItem($nome_cache_usuario_id);
                }

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('usuarios', ["action" => "main", "id" => $modelUsuario->id_usuario]);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formUsuarios', $form)
                    ->setTemplate('usuario/usuarios/editar');
            }
        }
    }

    // DELETE /usuarios/deletar/id
    public function deletarAction()
    {
        // filtra id_usuario passsado pela url
        $id_usuario = (int) $this->params()->fromRoute('id', 0);

        // se id_usuario = 0 ou não informado redirecione para usuarios
        if (!$id_usuario) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Usuario não encotrado" .$id_usuario);
        } else {
            // aqui vai a lógica para deletar o usuarios no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta usuarios
            $this->getUsuarioTable()->delete($id_usuario);

            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Usuario de ID $id_usuario deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('usuarios', ['action' => 'main']);
    }

    /**
     * Metodo privado para obter instacia do Model UsuarioTable
     *
     * @return UsuarioTable
     */
    private function getUsuarioTable()
    {
        // adicionar service ModelUsuario a variavel de classe
        if (!$this->usuarioTable) {
            $this->usuarioTable = $this->getServiceLocator()->get('ModelUsuario');
        }

        // return vairavel de classe com service ModelUsuario
        return $this->usuarioTable;
    }

    // GET /usuarios/search?query=[nome]
    public function searchAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            $result = $this->getUsuarioTable()->search($nome);
        } else  {
            $result = [];
        }

        return new \Zend\View\Model\JsonModel($result);
    }

    /**
     * action sobre
     * @return \Zend\View\Model\ViewModel
     */
    public function sobreAction()
    {
        return new ViewModel();
    }
}