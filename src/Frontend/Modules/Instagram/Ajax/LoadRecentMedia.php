<?php

namespace Frontend\Modules\Instagram\Ajax;

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
     * @var array The fetched images
     */
    private $images;

    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        // Get POST parameters
        $userId = \SpoonFilter::getPostValue('userId', null, '');

        // Get count settings
        $this->recentCount = FrontendModel::get('fork.settings')->get('Instagram', 'num_recent_items', 10);

        // Get the images from the Instagram API
        $this->images = FrontendInstagramModel::getRecentMedia($userId, $this->recentCount);

        // Output the result
        $this->output(self::OK, $this->images);
    }
}
