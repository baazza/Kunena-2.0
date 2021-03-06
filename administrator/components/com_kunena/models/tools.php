<?php
/**
 * Kunena Component
 * @package Kunena.Administrator
 * @subpackage Models
 *
 * @copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.application.component.model' );
require_once dirname ( __FILE__ ) . '/cpanel.php';

/**
 * Tools Model for Kunena
 *
 * @since 2.0
*/
class KunenaAdminModelTools extends KunenaAdminModelCpanel {
	function getPruneCategories() {
		$cat_params = array ();
		$cat_params['ordering'] = 'ordering';
		$cat_params['toplevel'] = 0;
		$cat_params['sections'] = 0;
		$cat_params['direction'] = 1;
		$cat_params['unpublished'] = 1;
		$cat_params['action'] = 'admin';

		$forum = JHTML::_('kunenaforum.categorylist', 'prune_forum[]', 0, null, $cat_params, 'class="inputbox" multiple="multiple"', 'value', 'text');
		return $forum;
	}

	function getPruneListtrashdelete() {
		$trashdelete = array();
		$trashdelete [] = JHTML::_ ( 'select.option', '0', JText::_('COM_KUNENA_TRASH_USERMESSAGES') );
		$trashdelete [] = JHTML::_ ( 'select.option', '1', JText::_('COM_KUNENA_DELETE_PERMANENTLY') );

		return JHTML::_('select.genericlist', $trashdelete, 'trashdelete', 'class="inputbox" size="1"', 'value', 'text', 0);
	}

	function getPruneControlOptions() {
		$contoloptions = array();
		$contoloptions [] = JHTML::_ ( 'select.option', 'all', JText::_('COM_KUNENA_A_PRUNE_ALL') );
		$contoloptions [] = JHTML::_ ( 'select.option', 'normal', JText::_('COM_KUNENA_A_PRUNE_NORMAL') );
		$contoloptions [] = JHTML::_ ( 'select.option', 'locked', JText::_('COM_KUNENA_A_PRUNE_LOCKED') );
		$contoloptions [] = JHTML::_ ( 'select.option', 'unanswered', JText::_('COM_KUNENA_A_PRUNE_UNANSWERED') );
		$contoloptions [] = JHTML::_ ( 'select.option', 'answered', JText::_('COM_KUNENA_A_PRUNE_ANSWERED') );
		$contoloptions [] = JHTML::_ ( 'select.option', 'unapproved', JText::_('COM_KUNENA_A_PRUNE_UNAPPROVED') );
		$contoloptions [] = JHTML::_ ( 'select.option', 'deleted', JText::_('COM_KUNENA_A_PRUNE_DELETED') );
		$contoloptions [] = JHTML::_ ( 'select.option', 'shadow', JText::_('COM_KUNENA_A_PRUNE_SHADOW') );

		return JHTML::_('select.genericlist', $contoloptions, 'controloptions', 'class="inputbox" size="1"', 'value', 'text', 'normal');
	}

	function getPruneKeepSticky() {
		$optionsticky = array();
		$optionsticky [] = JHTML::_ ( 'select.option', '0', JText::_('COM_KUNENA_A_NO') );
		$optionsticky [] = JHTML::_ ( 'select.option', '1', JText::_('COM_KUNENA_A_YES') );

		return JHTML::_('select.genericlist', $optionsticky, 'keepsticky', 'class="inputbox" size="1"', 'value', 'text', 1);
	}
}
