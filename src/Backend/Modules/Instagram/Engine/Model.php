<?php

namespace Backend\Modules\Instagram\Engine;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Common\Uri as CommonUri;

use Backend\Core\Engine\Language;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Tags\Engine\Model as BackendTagsModel;

/**
 * In this file we store all generic functions that we will be using in the instagram module
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class Model
{
    const QRY_DATAGRID_BROWSE =
        'SELECT i.id, i.username, UNIX_TIMESTAMP(i.created_on) AS created_on, i.hidden
         FROM instagram_users AS i';

    /**
     * Delete a certain user
     *
     * @param int $id
     */
    public static function delete($id)
    {
        $record = self::get($id);

        // delete extra
        BackendModel::deleteExtraById($record['extra_id'], true);

        // delete user id
        BackendModel::get('database')->delete('instagram_users', 'id = ?', (int) $id);
    }

    /**
     * Checks if a certain user exists
     *
     * @param int $id
     * @return bool
     */
    public static function exists($id)
    {
        return (bool) BackendModel::get('database')->getVar(
            'SELECT 1
             FROM instagram_users AS i
             WHERE i.id = ?
             LIMIT 1',
            array((int) $id)
        );
    }

    /**
     * Fetches a certain item
     *
     * @param int $id
     * @return array
     */
    public static function get($id)
    {
        return (array) BackendModel::get('database')->getRecord(
            'SELECT i.*
             FROM instagram_users AS i
             WHERE i.id = ?',
            array((int) $id)
        );
    }

    /**
     * Insert an item in the database
     *
     * @param array $item
     * @return int
     */
    public static function insert(array $item)
    {
        $item['created_on'] = BackendModel::getUTCDate();
        $item['edited_on'] = BackendModel::getUTCDate();
        $db = BackendModel::get('database');

        // insert extra
        $item['extra_id'] = BackendModel::insertExtra(
            'widget',
            'Instagram',
            'InstagramFeed'
        );

        $item['id'] = (int) $db->insert('instagram_users', $item);

        // update extra (item id is now known)
        BackendModel::updateExtra(
            $item['extra_id'],
            'data',
            array(
                'id' => $item['id'],
                'extra_label' => \SpoonFilter::ucfirst(Language::lbl('Instagram', 'InstagramFeed')) . ': ' . $item['username'],
                'edit_url' => BackendModel::createURLForAction(
                        'Edit',
                        'Instagram',
                        null
                    ) . '&id=' . $item['id']
            )
        );

        return $item['id'];
    }

    /**
     * Updates an item
     *
     * @param array $item
     */
    public static function update(array $item)
    {
        $item['edited_on'] = BackendModel::getUTCDate();

        BackendModel::get('database')->update(
            'instagram_users', $item, 'id = ?', (int) $item['id']
        );
    }
}
