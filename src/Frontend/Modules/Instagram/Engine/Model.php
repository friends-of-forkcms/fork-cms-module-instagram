<?php

namespace Frontend\Modules\Instagram\Engine;

use Frontend\Core\Engine\Model as FrontendModel;

/**
 * The frontend Instagram Model
 */
class Model
{
    /**
     * Fetches a certain item
     *
     * @param string $id
     * @return array
     */
    public static function get($id): array
    {
        $item = (array) FrontendModel::get('database')->getRecord(
            'SELECT i.*
             FROM instagram_users AS i
             WHERE i.id = ? AND i.hidden = ?',
            array((int) $id, 'N')
        );

        // no results?
        if (empty($item)) {
            return array();
        }

        return $item;
    }

    public static function getRecentMedia($userId, $count = 10)
    {
        $recentData = Helper::getUserMedia($userId, $count);

        return (isset($recentData) && isset($recentData->data)) ? $recentData->data : null;
    }
}
