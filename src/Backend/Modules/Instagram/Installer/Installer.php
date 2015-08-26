<?php

namespace Backend\Modules\Instagram\Installer;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Backend\Core\Installer\ModuleInstaller;

/**
 * Installer for the instagram module
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class Installer extends ModuleInstaller
{

    /**
     * Install the module
     */
    public function install()
    {
        //$this->importSQL(dirname(__FILE__) . '/Data/install.sql');

        $this->addModule('Instagram');

        $this->importLocale(dirname(__FILE__) . '/Data/locale.xml');

        $this->setModuleRights(1, 'Instagram');

        $this->setActionRights(1, 'Instagram', 'Settings');
        $this->setActionRights(1, 'Instagram', 'Oauth');
        $this->setActionRights(1, 'Instagram', 'Logout');

        // Register widgets
        $this->insertExtra('Instagram', 'widget', 'Instagram-feed', 'Instagram-feed');

        // Configure settings
        $this->setSetting('Instagram', 'num_recent_items', 10);
        $this->setSetting('Instagram', 'client_id', NULL);
        $this->setSetting('Instagram', 'client_secret', NULL);
        $this->setSetting('Instagram', 'username', NULL);
        $this->setSetting('Instagram', 'user_id', NULL);
        $this->setSetting('Instagram', 'access_token', NULL);

        // set navigation
        $navigationSettingsId = $this->setNavigation(null, 'Settings');
        $navigationModulesId = $this->setNavigation($navigationSettingsId, 'Modules');
        $this->setNavigation($navigationModulesId, 'Instagram', 'instagram/settings');
    }
}
