<?php
/**
 * Kunena Component
 * @package Kunena.Administrator
 * @subpackage Controllers
 *
 * @copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

/**
 * Kunena Backend Config Controller
 *
 * @since 2.0
 */
class KunenaAdminControllerConfig extends KunenaController {
	protected $baseurl = null;

	public function __construct($config = array()) {
		parent::__construct($config);
		$this->baseurl = 'index.php?option=com_kunena&view=config';
		$this->kunenabaseurl = 'index.php?option=com_kunena';
	}

	function apply() {
		$url = $this->baseurl;
		$this->save($url);
	}

	function save($url=null) {
		$app = JFactory::getApplication ();
		$config = KunenaFactory::getConfig ();
		$db = JFactory::getDBO ();

		if (! JRequest::checkToken ()) {
			$app->enqueueMessage ( JText::_ ( 'COM_KUNENA_ERROR_TOKEN' ), 'error' );
			$app->redirect ( KunenaRoute::_($this->baseurl, false) );
		}

		$properties = $config->getProperties();
		foreach ( JRequest::get('post', JREQUEST_ALLOWHTML) as $postsetting => $postvalue ) {
			if (JString::strpos ( $postsetting, 'cfg_' ) === 0) {
				//remove cfg_ and force lower case
				if ( is_array($postvalue) ) {
					$postvalue = implode(',',$postvalue);
				}
				$postname = JString::strtolower ( JString::substr ( $postsetting, 4 ) );

				// No matter what got posted, we only store config parameters defined
				// in the config class. Anything else posted gets ignored.
				if (array_key_exists ( $postname, $properties )) {
					$config->set($postname, $postvalue);
				}
			}
		}

		$config->save ();

		$app->enqueueMessage ( JText::_('COM_KUNENA_CONFIGSAVED'));
		if (empty($url)) $app->redirect ( KunenaRoute::_($this->baseurl, false) );
		else $app->redirect ( $url );
	}

	function setdefault() {
		$db = JFactory::getDBO ();
		$app = JFactory::getApplication ();
		$config = KunenaFactory::getConfig ();

		if (! JRequest::checkToken ()) {
			$app->enqueueMessage ( JText::_ ( 'COM_KUNENA_ERROR_TOKEN' ), 'error' );
			$app->redirect ( KunenaRoute::_($this->baseurl, false) );
		}

		$config->reset();
		$config->save();

		$app->enqueueMessage ( JText::_('COM_KUNENA_CONFIG_DEFAULT'));
		$app->redirect ( KunenaRoute::_($this->baseurl, false) );
	}
}
