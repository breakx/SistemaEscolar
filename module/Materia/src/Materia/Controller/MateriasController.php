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
namespace Materia\Controller;

// import ZendMvc
use Zend\Mvc\Controller\AbstractActionController;

// import ZendView
use Zend\View\Model\ViewModel;

// imort ModelMateriaTable com alias
use Materia\Model\MateriaTable as ModelMateria;

// import MateriaForm
use Materia\Form\MateriaForm;

// import ModelMateria
use Materia\Model\Materia;

class MateriasController extends AbstractActionController
{
    protected $materiaTable;

    // GET /materias
    public function indexAction()
    {
        return new ViewModel();
    }

    // GET /materias
    public function mainAction()
    {
        // colocar parametros da url em um array
        $paramsUrl = [
            'pagina_atual'  => $this->params()->fromQuery('pagina', 1),
            'itens_pagina'  => $this->params()->fromQuery('itens_pagina', 10),
            'coluna_nome'   => $this->params()->fromQuery('coluna_nome', 'nome_materia'),
            'coluna_sort'   => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search'        => $this->params()->fromQuery('search', null),
        ];

        // configuar método de paginação
        $paginacao = $this->getMateriaTable()->fetchPaginator(
            /* $pagina */           $paramsUrl['pagina_atual'],
            /* $itensPagina */      $paramsUrl['itens_pagina'],
            /* $ordem */            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            /* $search */           $paramsUrl['search'],
            /* $itensPaginacao */   5
        );

        // retonar paginação mais os params de url para view
        return new ViewModel(['materias' => $paginacao] + $paramsUrl);
    }

    // GET /materias/novo
    public function novoAction()
    {
        return ['formMaterias' => new MateriaForm()];
    }

    // POST /materias/adicionar
    public function adicionarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MateriaForm();
            // instancia model materia com regras de filtros e validações
            $modelMateria = new Materia();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity materias
            $form->setInputFilter($modelMateria->getInputFilter());
            // passa para o objeto formulário os materia vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os materia à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMateria->exchangeArray($form->getData());
                // 2 - persistir materias do model para banco de materias
                $this->getMateriaTable()->save($modelMateria);

                // redirecionar para action index no controller materias
                return $this->redirect()->toRoute('materias', ['action' => 'main']);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formMaterias', $form)
                    ->setTemplate('materia/materias/novo');
            }
        }
    }

    // GET /materias/detalhes/id
    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para materias
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Materia não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('materias', ['action' => 'main']);
        }

        try {
            // aqui vai a lógica para pegar os materias referente ao materias
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com materias desse materias encontrado
            // formulário com materias preenchidos

            // lógica cache objeto materias
            $nome_cache_materia_id = "nome_cache_materias_{$id}";
            if (!$this->cache()->hasItem($nome_cache_materia_id)) {
                $materia = $this->getMateriaTable()->find($id);

                $this->cache()->setItem($nome_cache_materia_id, $materia);
            } else {
                $materia = $this->cache()->getItem($nome_cache_materia_id);
            }
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('materias', ['action' => 'main']);
        }

        // materias eviados para detalhes.phtml
        return (new ViewModel())
            ->setTerminal($this->getRequest()->isXmlHttpRequest())
            ->setVariable('materias', $materia)
            ;
    }

    // GET /materias/editar/id
    public function editarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para materias
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Materia não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('materias', ['action' => 'main']);
        }

        try {
            // variável com objeto materia localizado
            $materia = (array) $this->getMateriaTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('materias', ['action' => 'main']);
        }

        // objeto form materias vazio
        $form = new MateriaForm();
        // popula objeto form materias com objeto model materias
        $form->setData($materia);

        // materias eviados para editar.phtml
        return ['formMaterias' => $form];
    }

    // POST /materias/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new MateriaForm();
            // instancia model materia com regras de filtros e validações
            $modelMateria = new Materia();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity materia
            $form->setInputFilter($modelMateria->getInputFilter());
            // passa para o objeto formulário os materia vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para atualizar os materia à tabela no banco
                // 1 - popular model com valores do formulário
                $modelMateria->exchangeArray($form->getData());
                // 2 - atualizar materia do model para banco de materia
                $this->getMateriaTable()->update($modelMateria);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                    ->addSuccessMessage("Materia editado com sucesso");

                $nome_cache_materia_id = "nome_cache_materia_{$modelMateria->id_materia}";
                if ($this->cache()->hasItem($nome_cache_materia_id)) {
                    $this->cache()->removeItem($nome_cache_materia_id);
                }

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('materias', ["action" => "main", "id" => $modelMateria->id_materia]);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formMaterias', $form)
                    ->setTemplate('materia/materias/editar');
            }
        }
    }

    // DELETE /materias/deletar/id
    public function deletarAction()
    {
        // filtra id_materia passsado pela url
        $id_materia = (int) $this->params()->fromRoute('id', 0);

        // se id_materia = 0 ou não informado redirecione para materias
        if (!$id_materia) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Materia não encotrado" .$id_materia);
        } else {
            // aqui vai a lógica para deletar o materia no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta materia
            $this->getMateriaTable()->delete($id_materia);

            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Materia de ID $id_materia deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('materias', ['action' => 'main']);
    }

    /**
     * Metodo privado para obter instacia do Model MateriaTable
     *
     * @return MateriaTable
     */
    private function getMateriaTable()
    {
        // adicionar service ModelMateria a variavel de classe
        if (!$this->materiaTable) {
            $this->materiaTable = $this->getServiceLocator()->get('ModelMateria');
        }

        // return vairavel de classe com service ModelMateria
        return $this->materiaTable;
    }

    // GET /materias/search?query=[nome]
    public function searchAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            $result = $this->getMateriaTable()->search($nome);
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