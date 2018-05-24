<?php

namespace Frontend\Modules\Instagram\Ajax;

use Frontend\Core\Engine\Base\AjaxAction as FrontendBaseAJAXAction;
use Frontend\Core\Engine\Model as FrontendModel;
use Frontend\Modules\Instagram\Engine\Model as FrontendInstagramModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * Fetches the recent user media and passes it back to javascript
 */
class LoadRecentMedia extends FrontendBaseAJAXAction
{
    public function execute(): void
    {
        parent::execute();

        $this->output(Response::HTTP_OK, $this->getRecentMedia());
    }

    private function getRecentMedia(): array
    {
        return FrontendInstagramModel::getRecentMedia(
            $this->getRequest()->request->get('userId'),
            FrontendModel::get('fork.settings')->get('Instagram', 'num_recent_items', 10)
        );
    }
}
