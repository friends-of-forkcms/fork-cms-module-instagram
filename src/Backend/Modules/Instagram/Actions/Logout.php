<?php

namespace Backend\Modules\Instagram\Actions;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Backend\Core\Engine\Base\Action as BackendBaseAction;
use Backend\Core\Engine\Model as BackendModel;

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
        $this->get('fork.settings')->set('Instagram', 'client_id', null);
        $this->get('fork.settings')->set('Instagram', 'client_secret', null);
        $this->get('fork.settings')->set('Instagram', 'username', null);
        $this->get('fork.settings')->set('Instagram', 'access_token', null);

        $this->redirect(BackendModel::createURLForAction('Settings'));
    }
}
