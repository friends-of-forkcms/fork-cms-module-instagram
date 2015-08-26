<?php

namespace Frontend\Modules\Instagram\Widgets;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;
use Frontend\Modules\Instagram\Engine\Model as FrontendInstagramModel;

/**
 * This is the instagram widget
 *
 * @author Jesse Dobbelaere <jesse@dobbelae.re>
 */
class Widget extends FrontendBaseWidget
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

		// load the data
		$this->getData();

		// parse
		$this->parse();
	}

	/**
 	* Load the data, don't forget to validate the incoming data
 	*
 	* @return	void
 	*/
	private function getData()
	{

	}

	/**
 	* Parse the data into the template
 	*
 	* @return	void
 	*/
	private function parse()
	{
	}
}