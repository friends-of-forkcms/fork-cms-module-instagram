<?php

namespace Backend\Modules\Instagram\Actions;

use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;
use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Model as BackendModel;

/**
 * This is the settings-action, it will display a form to set general instagram settings
 */
class Settings extends BackendBaseActionEdit
{
    /**
     * Execute the action
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
     * Loads the settings form
     */
    private function loadForm(): void
    {
        // Init settings form
        $this->form = new BackendForm('settings');

        // We are not authenticated, so let the user fill in their credentials
        if ($this->get('fork.settings')->get($this->url->getModule(), 'access_token') == '') {
            $this->form->addText('client_id', $this->get('fork.settings')->get($this->url->getModule(), 'client_id'));
            $this->form->addText('client_secret', $this->get('fork.settings')->get($this->url->getModule(), 'client_secret'));
            $this->template->assign('authenticate', true);

            return;
        } else {
            // Total number of recent images fetched by the module
            $this->form->addDropdown(
                'num_recent_items',
                array_combine(range(1, 20), range(1, 20)),
                $this->get('fork.settings')->get($this->url->getModule(), 'num_recent_items', 10)
            );
        }
    }

    /**
     * Validates the settings form
     */
    private function validateForm(): void
    {
        if (!$this->form->isSubmitted()) {
            return;
        }

        if ($this->form->existsField('num_recent_items')) {
            $this->get('fork.settings')->set(
                $this->url->getModule(),
                'num_recent_items',
                (int) $this->form->getField('num_recent_items')->getValue()
            );

            // Redirect to the settings page
            $this->redirect(BackendModel::createUrlForAction('Settings') . '&report=saved');
        }

        if ($this->form->existsField('client_id') && $this->form->existsField('client_secret')) {
            $this->validateAuthConfigForm();
        }
    }

    private function validateAuthConfigForm(): void
    {
        $this->get('fork.settings')->set(
            $this->url->getModule(),
            'client_id',
            $this->form->getField('client_id')->getValue()
        );

        $this->get('fork.settings')->set(
            $this->url->getModule(),
            'client_secret',
            $this->form->getField('client_secret')->getValue()
        );

        // We need to authenticate, redirect to oauth
        $this->redirect(BackendModel::createUrlForAction('oauth'));
    }
}
