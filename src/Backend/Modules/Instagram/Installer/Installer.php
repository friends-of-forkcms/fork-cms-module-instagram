<?php

namespace Backend\Modules\Instagram\Installer;

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
        $this->importSQL(dirname(__FILE__) . '/Data/install.sql');

        $this->addModule('Instagram');

        $this->importLocale(dirname(__FILE__) . '/Data/locale.xml');

        $this->setModuleRights(1, 'Instagram');

        $this->setActionRights(1, 'Instagram', 'Settings');
        $this->setActionRights(1, 'Instagram', 'Oauth');
        $this->setActionRights(1, 'Instagram', 'Logout');
        $this->setActionRights(1, 'Instagram', 'Index');
        $this->setActionRights(1, 'Instagram', 'Edit');
        $this->setActionRights(1, 'Instagram', 'Add');
        $this->setActionRights(1, 'Instagram', 'Delete');

        // Configure settings
        $this->setSetting('Instagram', 'num_recent_items', 10);
        $this->setSetting('Instagram', 'client_id', null);
        $this->setSetting('Instagram', 'client_secret', null);
        $this->setSetting('Instagram', 'username', null);
        $this->setSetting('Instagram', 'user_id', null);
        $this->setSetting('Instagram', 'access_token', null);

        // Set navigation
        $navigationSettingsId = $this->setNavigation(null, 'Settings');
        $navigationModulesId = $this->setNavigation($navigationSettingsId, 'Modules');
        $this->setNavigation($navigationModulesId, 'Instagram', 'instagram/settings');

        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $this->setNavigation(
            $navigationModulesId,
            'Instagram',
            'instagram/index',
            array('instagram/add', 'instagram/edit')
        );
    }
}
