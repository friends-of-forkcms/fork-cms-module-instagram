<?php

namespace Backend\Modules\Instagram\Actions;

use Backend\Core\Engine\Base\ActionAdd;
use Backend\Core\Engine\Form;
use Backend\Core\Engine\Language;
use Backend\Core\Engine\Meta;
use Backend\Core\Engine\Model;
use Backend\Modules\Instagram\Engine\Helper;
use Backend\Modules\Instagram\Engine\Model as BackendInstagramModel;

/**
 * This is the add-action, it will display a form to create a new item
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class Add extends ActionAdd
{
    /**
     * Execute the actions
     */
    public function execute()
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
    protected function loadForm()
    {
        $this->frm = new Form('add');

        $this->frm->addText('username', null, null, 'inputText title', 'inputTextError title');

        // Meta
        $this->meta = new Meta($this->frm, null, 'username', true);
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
    }

    /**
     * Validate the form
     */
    protected function validateForm()
    {
        if ($this->frm->isSubmitted()) {
            $this->frm->cleanupFields();

            // Validation
            $fields = $this->frm->getFields();

            $fields['username']->isFilled(Language::err('FieldIsRequired'));

            if ($this->frm->isCorrect()) {
                // Build the item
                $item['username'] = $fields['username']->getValue();

                // Lookup user id
                $userObj = Helper::searchUser($item['username']);
                if (isset($userObj->data)) {
                    $userId = $userObj->data[0]->id;
                    $item['user_id'] = $userId;
                } else {
                    $this->redirect(Model::createURLForAction('Index') . '&error=api_error');
                }

                // Insert it
                $item['id'] = BackendInstagramModel::insert($item);
                Model::triggerEvent($this->getModule(), 'after_add', $item);

                $this->redirect(Model::createURLForAction('Index') . '&report=added&highlight=row-' . $item['id']);
            }
        }
    }
}
