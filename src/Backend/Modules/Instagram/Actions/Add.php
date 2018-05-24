<?php

namespace Backend\Modules\Instagram\Actions;

use Backend\Core\Engine\Base\ActionAdd;
use Backend\Core\Engine\Form;
use Backend\Core\Engine\Meta;
use Backend\Core\Engine\Model;
use Backend\Core\Language\Language;
use Backend\Modules\Instagram\Engine\Helper;
use Backend\Modules\Instagram\Engine\Model as BackendInstagramModel;

/**
 * This is the add-action, it will display a form to create a new item
 */
class Add extends ActionAdd
{
    /**
     * Execute the actions
     */
    public function execute(): void
    {
        parent::execute();

        $this->loadForm();
        $this->validateForm();

        $this->parse();
        $this->display();
    }

    /**
     * Load the form
     */
    protected function loadForm(): void
    {
        $this->form = new Form('add');
        $this->form->addText('username', null, null, 'inputText title', 'inputTextError title');

        $this->meta = new Meta($this->form, null, 'username', true);
    }

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
    }

    protected function validateForm(): void
    {
        if ($this->form->isSubmitted()) {
            $this->form->cleanupFields();

            // Validation
            $fields = $this->form->getFields();

            $fields['username']->isFilled(Language::err('FieldIsRequired'));

            if ($this->form->isCorrect()) {
                // Build the item
                $item['username'] = $fields['username']->getValue();

                // Lookup user id
                $userObj = Helper::searchUser($item['username']);
                if (isset($userObj->data)) {
                    $userId = $userObj->data[0]->id;
                    $item['user_id'] = $userId;
                } else {
                    $this->redirect(Model::createUrlForAction('Index') . '&error=api_error');
                }

                // Insert it
                $item['id'] = BackendInstagramModel::insert($item);

                $this->redirect(Model::createUrlForAction('Index') . '&report=added&highlight=row-' . $item['id']);
            }
        }
    }
}
