<?php

namespace Backend\Modules\Instagram\Actions;

use Backend\Core\Engine\Base\Action as BackendBaseAction;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Instagram\Engine\Model as BackendInstagramModel;

/**
 * This is the logout-action, it will remove the settings
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class Logout extends BackendBaseAction
{
    /**
     * Execute the action
     */
    public function execute()
    {
        $settingsService = $this->get('fork.settings');

        // Save access_token to settings
        $instagramUserId = $settingsService->get($this->URL->getModule(), 'default_instagram_user_id', false);

        if ($instagramUserId) {
            BackendInstagramModel::delete($instagramUserId);
        }

        $settingsService->set('Instagram', 'client_id', null);
        $settingsService->set('Instagram', 'client_secret', null);
        $settingsService->set('Instagram', 'username', null);
        $settingsService->set('Instagram', 'access_token', null);
        $settingsService->set('Instagram', 'default_instagram_user_id', null);

        $this->redirect(BackendModel::createURLForAction('Settings'));
    }
}
