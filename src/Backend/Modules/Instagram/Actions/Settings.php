<?php

namespace Backend\Modules\Instagram\Actions;

use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;
use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Model as BackendModel;

/**
 * This is the settings-action, it will display a form to set general instagram settings
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class Settings extends BackendBaseActionEdit
{
    /**
     * Execute the action
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
     * Loads the settings form
     */
    private function loadForm()
    {
        // Init settings form
        $this->frm = new BackendForm('settings');

        // We are not authenticated, so let the user fill in their credentials
        if ($this->get('fork.settings')->get($this->URL->getModule(), 'access_token') == '') {
            $this->frm->addText('client_id', $this->get('fork.settings')->get($this->URL->getModule(), 'client_id'));
            $this->frm->addText('client_secret', $this->get('fork.settings')->get($this->URL->getModule(), 'client_secret'));
            $this->tpl->assign('authenticate', true);

            return;
        } else {
            // Total number of recent images fetched by the module
            $this->frm->addDropdown(
                'num_recent_items',
                array_combine(range(1, 20), range(1, 20)),
                $this->get('fork.settings')->get($this->URL->getModule(), 'num_recent_items', 10)
            );
        }
    }

    /**
     * Validates the settings form
     */
    private function validateForm()
    {
        if (!$this->frm->isSubmitted()) {
            return false;
        }

        if ($this->frm->existsField('num_recent_items')) {
            $this->get('fork.settings')->set(
                $this->URL->getModule(),
                'num_recent_items',
                (int) $this->frm->getField('num_recent_items')->getValue()
            );

            // Trigger event
            BackendModel::triggerEvent($this->getModule(), 'after_saved_settings');

            // Redirect to the settings page
            $this->redirect(BackendModel::createURLForAction('Settings') . '&report=saved');
        }

        if ($this->frm->existsField('client_id') && $this->frm->existsField('client_secret')) {
            return $this->validateAuthConfigForm();
        }
    }

    private function validateAuthConfigForm()
    {
        $this->get('fork.settings')->set(
            $this->URL->getModule(),
            'client_id',
            $this->frm->getField('client_id')->getValue()
        );

        $this->get('fork.settings')->set(
            $this->URL->getModule(),
            'client_secret',
            $this->frm->getField('client_secret')->getValue()
        );

        // We need to authenticate, redirect to oauth
        $this->redirect(BackendModel::createURLForAction('oauth'));
    }
}
