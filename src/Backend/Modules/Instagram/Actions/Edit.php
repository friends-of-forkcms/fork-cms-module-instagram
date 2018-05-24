<?php

namespace Backend\Modules\Instagram\Actions;

use Backend\Core\Engine\Base\ActionEdit;
use Backend\Core\Engine\Form;
use Backend\Core\Engine\Model;
use Backend\Core\Language\Language;
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
    public function execute(): void
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
    protected function loadData(): void
    {
        $this->id = $this->getRequest()->query->getInt('id');
        if ($this->id == null || !BackendInstagramModel::exists($this->id)) {
            $this->redirect(Model::createUrlForAction('Index') . '&error=non-existing');
        }

        $this->record = BackendInstagramModel::get($this->id);

        if ($this->record['locked'] == 'Y') {
            $this->redirect(Model::createUrlForAction('Index') . '&error=is-locked');
        }
    }

    /**
     * Load the form
     */
    protected function loadForm(): void
    {
        // Create form
        $this->form = new Form('edit');
        $this->form->addText('username', $this->record['username'], null, 'inputText title', 'inputTextError title');
    }

    /**
     * Parse the page
     */
    protected function parse(): void
    {
        parent::parse();

        // Get url
        $url = Model::getURLForBlock($this->url->getModule(), 'Detail');
        $url404 = Model::getURL(404);

        // Parse additional variables
        if ($url404 != $url) {
            $this->template->assign('detailURL', SITE_URL . $url);
        }

        $this->template->assign('item', $this->record);
    }

    /**
     * Validate the form
     */
    protected function validateForm(): void
    {
        if ($this->form->isSubmitted()) {
            $this->form->cleanupFields();

            // validation
            $fields = $this->form->getFields();

            $fields['username']->isFilled(Language::err('FieldIsRequired'));

            if ($this->form->isCorrect()) {
                $item['id'] = $this->id;

                $item['username'] = $fields['username']->getValue();

                // lookup user id
                $userObj = Helper::searchUser($item['username']);
                if (isset($userObj->data)) {
                    $userId = $userObj->data[0]->id;
                    $item['user_id'] = $userId;
                } else {
                    $this->redirect(Model::createUrlForAction('Index') . '&error=api_error');
                }

                BackendInstagramModel::update($item);
                $item['id'] = $this->id;

                $this->redirect(Model::createUrlForAction('Index') . '&report=edited&highlight=row-' . $item['id']);
            }
        }
    }
}
