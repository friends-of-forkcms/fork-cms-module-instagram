<?php

namespace Backend\Modules\Instagram;

use Backend\Core\Engine\Base\Config as BackendBaseConfig;

/**
 * This is the configuration-object for the instagram module
 */
class Config extends BackendBaseConfig
{
    /**
     * The default action
     *
     * @var	string
     */
    protected $defaultAction = 'Settings';

    /**
     * The disabled actions
     *
     * @var	array
     */
    protected $disabledActions = array();

    /**
     * The disabled AJAX-actions
     *
     * @var	array
     */
    protected $disabledAJAXActions = array();
}
