<?php
/**
 * @version		$Id: view.html.php 3901 2010-11-15 14:14:02Z mahagr $
 * Kunena Component
 * @package Kunena
 *
 * @Copyright (C) 2008 - 2010 Kunena Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 */
defined ( '_JEXEC' ) or die ();

kimport ( 'kunena.view' );
jimport ( 'joomla.html.pagination' );

/**
 * Users View
 */
class KunenaViewUsers extends KunenaView {
	function displayDefault($tpl = null) {
		$this->app = JFactory::getApplication();
		$this->config = KunenaFactory::getConfig();
		$this->total = $this->get ( 'Total' );
		$this->count = $this->get ( 'Count' );
		$this->users = $this->get ( 'Items' );
		$this->pageNav = new JPagination ( $this->total, $this->state->get('list.start'), $this->state->get('list.limit') );
		parent::display($tpl);
	}
}