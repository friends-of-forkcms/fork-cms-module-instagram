<?php

namespace Frontend\Modules\Instagram\Widgets;

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;
use Frontend\Modules\Instagram\Engine\Model as FrontendInstagramModel;

/**
 * This is the instagram feed widget
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class InstagramFeed extends FrontendBaseWidget
{
    /**
    * Execute the extra
    *
    * @return	void
    */
    public function execute()
    {
        // call the parent
        parent::execute();

        // load template
        $this->loadTemplate();

        // parse
        $this->parse();
    }

    /**
    * Parse the data into the template
    *
    * @return	void
    */
    private function parse()
    {
        // add css
        $this->header->addCSS('/src/Frontend/Modules/' . $this->getModule() . '/Layout/Css/Instagram.css');

        // fetch instagram user
        $instagramUser = FrontendInstagramModel::get($this->data['id']);

        // pass user info to javascript
        $this->addJSData('user', $instagramUser);

        // parse user info in template
        $this->tpl->assign('user', $instagramUser);
    }
}
