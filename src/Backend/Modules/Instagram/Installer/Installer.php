<?php

namespace Backend\Modules\Instagram\Installer;

use Backend\Core\Installer\ModuleInstaller;

/**
 * Installer for the instagram module
 */
class Installer extends ModuleInstaller
{
    /**
     * Install the module
     */
    public function install()
    {
        $this->addModule('Instagram');
        $this->importSQL(dirname(__FILE__) . '/Data/install.sql');
        $this->importLocale(dirname(__FILE__) . '/Data/locale.xml');
        $this->insertBackendNavigationForSettings();
        $this->insertRights();
        $this->insertSettings();
    }

    protected function insertBackendNavigationForSettings()
    {
        // Define settings id
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

    protected function insertRights()
    {
        // Module rights
        $this->setModuleRights(1, 'Instagram');

        // Action rights
        $this->setActionRights(1, 'Instagram', 'Settings');
        $this->setActionRights(1, 'Instagram', 'Oauth');
        $this->setActionRights(1, 'Instagram', 'Logout');
        $this->setActionRights(1, 'Instagram', 'Index');
        $this->setActionRights(1, 'Instagram', 'Edit');
        $this->setActionRights(1, 'Instagram', 'Add');
        $this->setActionRights(1, 'Instagram', 'Delete');
    }

    protected function insertSettings()
    {
        // Configure settings
        $this->setSetting('Instagram', 'num_recent_items', 10);
        $this->setSetting('Instagram', 'client_id', null);
        $this->setSetting('Instagram', 'client_secret', null);
        $this->setSetting('Instagram', 'default_instagram_user_id', null);
        $this->setSetting('Instagram', 'access_token', null);
    }
}
