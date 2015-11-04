<?php
/**
 * Created by PhpStorm.
 * User: LK
 * Date: 05/10/2015
 * Time: 19:31
 */

namespace Relatorio\Controller;

use Relatorio\Form\RelatorioForm;
use Relatorio\Model\Relatorio;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RelatorioController extends AbstractActionController
{

    protected $relatorioTable;

    // GET /relatorio
    public function indexAction()
    {
        return ['formRelatorio' => new RelatorioForm()];
    }

    /**
     * Metodo privado para obter instacia do Model RelatorioTable
     *
     * @return RelatorioTable
     */
    private function getRelatorioTable()
    {
        // adicionar service ModelRelatorio a variavel de classe
        if (!$this->relatorioTable) {
            $this->relatorioTable = $this->getServiceLocator()->get('ModelRelatorio');
        }

        // return vairavel de classe com service RelatorioTable
        return $this->relatorioTable;
    }

    /**
     * Metodo privado para obter instacia do Model RelatorioTable
     *
     * @return Select
     */

    public function getSelect($id)
    {
        echo("<script>console.log('PHP: ".json_encode($id)."');</script>");
        $this->relatorioTable = (array) $this->getRelatorioTable()->getSelect($id);
        //echo json_encode($this->relatorioTable);
        // return vairavel de classe com service RelatorioTable
        //return $this->relatorioTable;
        return Response::json($this->relatorioTable);
    }
}