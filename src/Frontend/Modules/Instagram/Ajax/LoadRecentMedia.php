<?php

namespace Frontend\Modules\Instagram\Ajax;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Frontend\Core\Engine\Base\AjaxAction as FrontendBaseAJAXAction;
use Frontend\Core\Engine\Model as FrontendModel;
use Frontend\Modules\Instagram\Engine\Model as FrontendInstagramModel;


/**
 * Fetches the recent user media and passes it back to javascript
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class LoadRecentMedia extends FrontendBaseAJAXAction
{
    /**
     * @var int The recent images count limit
     */
    private $recentCount = 10;

    /**
     * @var Array The fetched images
     */
    private $images;

    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        // get POST parameters
        $userId = \SpoonFilter::getPostValue('userId', null, '');

        // get count settings
        $this->recentCount = FrontendModel::get('fork.settings')->get('Instagram', 'num_recent_items', 10);

        // get the images from the Instagram API
        $this->images = FrontendInstagramModel::getRecentMedia($userId, $this->recentCount);

        // output the result
        $this->output(self::OK, $this->images);
    }
}
