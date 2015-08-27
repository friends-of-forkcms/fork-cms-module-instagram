<?php

namespace Backend\Modules\Instagram\Actions;

use Backend\Core\Engine\Base\ActionAdd;
use Backend\Core\Engine\Form;
use Backend\Core\Engine\Language;
use Backend\Core\Engine\Meta;
use Backend\Core\Engine\Model;
use Backend\Modules\Instagram\Engine\Helper;
use Backend\Modules\Instagram\Engine\Model as BackendInstagramModel;
use Backend\Modules\Search\Engine\Model as BackendSearchModel;
use Backend\Modules\Tags\Engine\Model as BackendTagsModel;
use Backend\Modules\Users\Engine\Model as BackendUsersModel;

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
        $this->frm->addText('function');

        // meta
        $this->meta = new Meta($this->frm, null, 'username', true);
    }

    /**
     * Parse the page
     */
    protected function parse()
    {
        parent::parse();

        // get url
        $url = Model::getURLForBlock($this->URL->getModule(), 'Detail');
        $url404 = Model::getURL(404);

        // parse additional variables
        if ($url404 != $url) {
            $this->tpl->assign('detailURL', SITE_URL . $url);
        }
        $this->record['url'] = $this->meta->getURL();
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

            // validate meta
            //$this->meta->validate();

            if ($this->frm->isCorrect()) {
                // build the item
                $item['username'] = $fields['username']->getValue();
//                $item['meta_id'] = $this->meta->save();

                // lookup user id
                $userObj = Helper::searchUser($item['username']);
                if (isset($userObj->data)) {
                    $userId = $userObj->data[0]->id;
                    $item['user_id'] = $userId;
                } else {
                    $this->redirect(
                        Model::createURLForAction('Index') . '&error=api_error'
                    );
                }

                // insert it
                $item['id'] = BackendInstagramModel::insert($item);

                Model::triggerEvent(
                    $this->getModule(), 'after_add', $item
                );
                $this->redirect(
                    Model::createURLForAction('Index') . '&report=added&highlight=row-' . $item['id']
                );
            }
        }
    }
}
