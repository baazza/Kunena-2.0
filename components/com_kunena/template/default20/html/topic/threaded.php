<?php
/**
 * Kunena Component
 * @package Kunena.Template.Default20
 * @subpackage Topic
 *
 * @copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

$this->displayPoll();
$this->getModulePosition( 'kunena_poll' );
include 'threaded_list.php';