<?php

namespace Backend\Modules\Instagram\Actions;

use Backend\Core\Engine\Base\ActionDelete;
use Backend\Core\Engine\Model;
use Backend\Modules\Instagram\Engine\Model as BackendInstagramModel;

/**
 * This is the delete-action, it deletes an item
 */
class Delete extends ActionDelete
{
    /**
     * Execute the action
     */
    public function execute(): void
    {
        $this->id = $this->getRequest()->query->getInt('id');

        // Does the item exist?
        if ($this->id !== null && BackendInstagramModel::exists($this->id)) {
            parent::execute();
            $this->record = (array) BackendInstagramModel::get($this->id);

            if ($this->record['locked'] == 'Y') {
                $this->redirect(Model::createUrlForAction('Index') . '&error=is-locked');
            }

            // Delete the file
            BackendInstagramModel::delete($this->id);

            $this->redirect(
                Model::createUrlForAction('Index') . '&report=deleted&var=' .
                urlencode($this->record['title'])
            );
        } else {
            $this->redirect(Model::createUrlForAction('Index') . '&error=non-existing');
        }
    }
}
