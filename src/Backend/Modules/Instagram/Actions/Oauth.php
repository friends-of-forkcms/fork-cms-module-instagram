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
use Backend\Modules\Instagram\Engine\Helper;

/**
 * This is the settings-action, it will display a form to set general instagram settings
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class Oauth extends BackendBaseAction
{
    public function execute()
    {
        parent::execute();

        // get the redirect code if there is one (if you are redirected here from the Instagram authentication)
        $oAuthCode = $this->getParameter('code', 'string', '');

        // get settings
        $client_id = $this->get('fork.settings')->get($this->URL->getModule(), 'client_id');
        $client_secret = $this->get('fork.settings')->get($this->URL->getModule(), 'client_secret');

        // if no settings configured, redirect
        if(!isset($client_id) || !isset($client_secret)) {
            $this->redirect(BackendModel::createURLForAction('Settings') . '&error=non-existing');
        }

        // first visit (otherwise instagram would have added a parameter)
        if($oAuthCode == '')
        {
            // get Instagram api token
            $instagram_login_url = Helper::getLoginUrl($client_id, SITE_URL . BackendModel::createURLForAction('Oauth'));
            $this->redirect($instagram_login_url);
        }

        // oauth code is set (meaning we got redirected from instagram)
        else {
            // exchanging the instagram login code for an access token
            $access_token = Helper::getOAuthToken($client_id, $client_secret, $oAuthCode, SITE_URL . BackendModel::createURLForAction('Oauth'), true);

            if(isset($access_token)) {
                // save access_token to settings
                $this->get('fork.settings')->set(
                    $this->URL->getModule(),
                    'access_token',
                    $access_token
                );

                // trigger event
                BackendModel::triggerEvent($this->getModule(), 'after_oauth');

                // successfully authenticated
                $this->redirect(BackendModel::createURLForAction('Settings') . '&report=authentication_success');
            } else {
                $this->redirect(BackendModel::createURLForAction('Settings') . '&error=authentication_failed');
            }
        }
    }
}