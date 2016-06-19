<?php

namespace Backend\Modules\Instagram\Actions;

use Backend\Core\Engine\Base\ActionIndex as BackendBaseActionIndex;
use Backend\Core\Engine\Authentication;
use Backend\Core\Engine\DataGridDB;
use Backend\Core\Engine\Language;
use Backend\Core\Engine\Model;
use Backend\Modules\Instagram\Engine\Model as BackendInstagramModel;

/**
 * This is the index-action (default), it will display the overview
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class Index extends BackendBaseActionIndex
{
    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();
        $this->loadDataGrid();

        $this->parse();
        $this->display();
    }

    /**
     * Load the dataGrid
     */
    protected function loadDataGrid()
    {
        $this->dataGrid = new DataGridDB(
            BackendInstagramModel::QRY_DATAGRID_BROWSE,
            Language::getWorkingLanguage()
        );

        // Reform date
        $this->dataGrid->setColumnFunction(
            array('Backend\Core\Engine\DataGridFunctions', 'getLongDate'),
            array('[created_on]'), 'created_on', true
        );

        // Check if this action is allowed
        if (Authentication::isAllowedAction('Edit')) {
            $this->dataGrid->addColumn(
                'edit', null, Language::lbl('Edit'),
                Model::createURLForAction('Edit') . '&amp;id=[id]',
                Language::lbl('Edit')
            );
            $this->dataGrid->setColumnURL(
                'username', Model::createURLForAction('Edit') . '&amp;id=[id]'
            );
        }
    }

    /**
     * Parse the page
     */
    protected function parse()
    {
        // parse the dataGrid if there are results
        $this->tpl->assign('dataGrid', (string) $this->dataGrid->getContent());
    }
}
