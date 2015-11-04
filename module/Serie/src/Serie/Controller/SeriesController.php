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
namespace Serie\Controller;

// import ZendMvc
use Zend\Mvc\Controller\AbstractActionController;

// import ZendView
use Zend\View\Model\ViewModel;

// imort ModelSerieTable com alias
use Serie\Model\SerieTable as ModelSerie;

// import SerieForm
use Serie\Form\SerieForm;

// import ModelSerie
use Serie\Model\Serie;

class SeriesController extends AbstractActionController
{
    protected $serieTable;

    // GET /series
    public function indexAction()
    {
        return new ViewModel();
    }

    // GET /series
    public function mainAction()
    {
        // colocar parametros da url em um array
        $paramsUrl = [
            'pagina_atual'  => $this->params()->fromQuery('pagina', 1),
            'itens_pagina'  => $this->params()->fromQuery('itens_pagina', 10),
            'coluna_nome'   => $this->params()->fromQuery('coluna_nome', 'nome_serie'),
            'coluna_sort'   => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search'        => $this->params()->fromQuery('search', null),
        ];

        // configuar método de paginação
        $paginacao = $this->getSerieTable()->fetchPaginator(
            /* $pagina */           $paramsUrl['pagina_atual'],
            /* $itensPagina */      $paramsUrl['itens_pagina'],
            /* $ordem */            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            /* $search */           $paramsUrl['search'],
            /* $itensPaginacao */   5
        );

        // retonar paginação mais os params de url para view
        return new ViewModel(['series' => $paginacao] + $paramsUrl);
    }

    // GET /series/novo
    public function novoAction()
    {
        return ['formSeries' => new SerieForm()];
    }

    // POST /serie/adicionar
    public function adicionarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new SerieForm();
            // instancia model series com regras de filtros e validações
            $modelSerie = new Serie();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity series
            $form->setInputFilter($modelSerie->getInputFilter());
            // passa para o objeto formulário os series vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para adicionar os series à tabela no banco
                // 1 - popular model com valores do formulário
                $modelSerie->exchangeArray($form->getData());
                // 2 - persistir serie do model para banco de serie
                $this->getSerieTable()->save($modelSerie);

                // redirecionar para action index no controller series
                return $this->redirect()->toRoute('series', ['action' => 'main']);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formSeries', $form)
                    ->setTemplate('serie/series/novo');
            }
        }
    }

    // GET /series/detalhes/id
    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para series
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Serie não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('series', ['action' => 'main']);
        }

        try {
            // aqui vai a lógica para pegar os series referente ao series
            // 1 - solicitar serviço para pegar o model responsável pelo find
            // 2 - solicitar form com series desse series encontrado
            // formulário com series preenchidos

            // lógica cache objeto series
            $nome_cache_serie_id = "nome_cache_serie_{$id}";
            if (!$this->cache()->hasItem($nome_cache_serie_id)) {
                $serie = $this->getSerieTable()->find($id);

                $this->cache()->setItem($nome_cache_serie_id, $serie);
            } else {
                $serie = $this->cache()->getItem($nome_cache_serie_id);
            }
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('series', ['action' => 'main']);
        }

        // series eviados para detalhes.phtml
        return (new ViewModel())
            ->setTerminal($this->getRequest()->isXmlHttpRequest())
            ->setVariable('series', $serie)
            ;
    }

    // GET /series/editar/id
    public function editarAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para series
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Serie não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('series', ['action' => 'main']);
        }

        try {
            // variável com objeto series localizado
            $serie = (array) $this->getSerieTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('series', ['action' => 'main']);
        }

        // objeto form serie vazio
        $form = new SerieForm();
        // popula objeto form serie com objeto model serie
        $form->setData($serie);

        // serie eviados para editar.phtml
        return ['formSeries' => $form];
    }

    // POST /series/editar/id
    public function atualizarAction()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // instancia formulário
            $form = new SerieForm();
            // instancia model series com regras de filtros e validações
            $modelSerie = new Serie();
            // passa para o objeto formulário as regras de viltros e validações
            // contidas na entity serie
            $form->setInputFilter($modelSerie->getInputFilter());
            // passa para o objeto formulário os serie vindos da submissão
            $form->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($form->isValid()) {
                // aqui vai a lógica para atualizar os serie à tabela no banco
                // 1 - popular model com valores do formulário
                $modelSerie->exchangeArray($form->getData());
                // 2 - atualizar serie do model para banco de serie
                $this->getSerieTable()->update($modelSerie);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                    ->addSuccessMessage("Serie editado com sucesso");

                $nome_cache_serie_id = "nome_cache_serie_{$modelSerie->id_serie}";
                if ($this->cache()->hasItem($nome_cache_serie_id)) {
                    $this->cache()->removeItem($nome_cache_serie_id);
                }

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('series', ["action" => "main", "id" => $modelSerie->id_serie]);
            } else { // em caso da validação não seguir o que foi definido
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                    ->setVariable('formSeries', $form)
                    ->setTemplate('serie/series/editar');
            }
        }
    }

    // DELETE /serie/deletar/id
    public function deletarAction()
    {
        // filtra id_serie passsado pela url
        $id_serie = (int) $this->params()->fromRoute('id', 0);

        // se id_serie = 0 ou não informado redirecione para serie
        if (!$id_serie) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Serie não encotrado" .$id_serie);
        } else {
            // aqui vai a lógica para deletar o serie no banco
            // 1 - solicitar serviço para pegar o model responsável pelo delete
            // 2 - deleta serie
            $this->getSerieTable()->delete($id_serie);

            // adicionar mensagem de sucesso
            $this->flashMessenger()->addSuccessMessage("Serie de ID $id_serie deletado com sucesso");
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('series', ['action' => 'main']);
    }

    /**
     * Metodo privado para obter instacia do Model SerieTable
     *
     * @return SerieTable
     */
    private function getSerieTable()
    {
        // adicionar service ModelSerie a variavel de classe
        if (!$this->serieTable) {
            $this->serieTable = $this->getServiceLocator()->get('ModelSerie');
        }

        // return vairavel de classe com service ModelSerie
        return $this->serieTable;
    }

    // GET /series/search?query=[nome]
    public function searchAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            $result = $this->getSerieTable()->search($nome);
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