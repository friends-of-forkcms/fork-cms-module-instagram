<?php

namespace Backend\Modules\Instagram\Actions;

use Backend\Core\Engine\Base\ActionEdit;
use Backend\Core\Engine\Form;
use Backend\Core\Engine\Language;
use Backend\Core\Engine\Model;
use Backend\Modules\Instagram\Engine\Helper;
use Backend\Modules\Instagram\Engine\Model as BackendInstagramModel;

/**
 * This is the edit-action, it will display a form with the item data to edit
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class Edit extends ActionEdit
{
    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        $this->loadData();
        $this->loadForm();
        $this->validateForm();

        $this->parse();
        $this->display();
    }

    /**
     * Load the item data
     */
    protected function loadData()
    {
        $this->id = $this->getParameter('id', 'int', null);
        if ($this->id == null || !BackendInstagramModel::exists($this->id)) {
            $this->redirect(Model::createURLForAction('Index') . '&error=non-existing');
        }

        $this->record = BackendInstagramModel::get($this->id);

        if ($this->record['locked'] == 'Y') {
            $this->redirect(Model::createURLForAction('Index') . '&error=is-locked');
        }
    }

    /**
     * Load the form
     */
    protected function loadForm()
    {
        // Create form
        $this->frm = new Form('edit');
        $this->frm->addText('username', $this->record['username'], null, 'inputText title', 'inputTextError title');
    }

    /**
     * Parse the page
     */
    protected function parse()
    {
        parent::parse();

        // Get url
        $url = Model::getURLForBlock($this->URL->getModule(), 'Detail');
        $url404 = Model::getURL(404);

        // Parse additional variables
        if ($url404 != $url) {
            $this->tpl->assign('detailURL', SITE_URL . $url);
        }

        $this->tpl->assign('item', $this->record);
    }

    /**
     * Validate the form
     */
    protected function validateForm()
    {
        if ($this->frm->isSubmitted()) {
            $this->frm->cleanupFields();

            // validation
            $fields = $this->frm->getFields();

            $fields['username']->isFilled(Language::err('FieldIsRequired'));

            if ($this->frm->isCorrect()) {
                $item['id'] = $this->id;

                $item['username'] = $fields['username']->getValue();

                // lookup user id
                $userObj = Helper::searchUser($item['username']);
                if (isset($userObj->data)) {
                    $userId = $userObj->data[0]->id;
                    $item['user_id'] = $userId;
                } else {
                    $this->redirect(Model::createURLForAction('Index') . '&error=api_error');
                }

                BackendInstagramModel::update($item);
                $item['id'] = $this->id;

                Model::triggerEvent($this->getModule(), 'after_edit', $item);
                $this->redirect(Model::createURLForAction('Index') . '&report=edited&highlight=row-' . $item['id']);
            }
        }
    }
}
