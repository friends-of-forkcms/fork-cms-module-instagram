<?php

namespace Frontend\Modules\Instagram\Widgets;

use Frontend\Core\Engine\Base\Widget;
use Frontend\Modules\Instagram\Engine\Model as FrontendInstagramModel;

/**
 * This is the instagram feed widget
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class InstagramFeed extends Widget
{
    public function execute(): void
    {
        $this->header->addCSS('/src/Frontend/Modules/' . $this->getModule() . '/Layout/Css/Instagram.css');

        parent::execute();

        // Parse instagram user
        $instagramUser = FrontendInstagramModel::get($this->data['id']);
        $this->addJSData('user', $instagramUser);
        $this->template->assign('user', $instagramUser);

        $this->loadTemplate();
    }
}
