<?php
/**
* @version $Id$
* Kunena Component
* @package Kunena
*
* @Copyright (C) 2008 - 2010 Kunena Team All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.kunena.com
*
* Based on FireBoard Component
* @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.bestofjoomla.com
*
* Based on Joomlaboard Component
* @copyright (C) 2000 - 2004 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF & Jan de Graaff
**/

// Dont allow direct linking
defined( '_JEXEC' ) or die();


$kunena_db = &JFactory::getDBO();
$kunena_config =& CKunenaConfig::getInstance();
$kunena_my = &JFactory::getUser();
$kunena_is_a_moderator = CKunenaTools::isAdmin($kunena_my->id);

if ($kunena_config->showwhoisonline)
{
?>
<!-- WHOIS ONLINE -->
<?php
    $fb_queryName = $kunena_config->username ? "username" : "name";
    $query
        = "SELECT w.userip, w.time, w.what, u.{$fb_queryName} AS username, u.id, k.moderator, k.showOnline "
        . " FROM #__fb_whoisonline AS w"
        . " LEFT JOIN #__users AS u ON u.id=w.userid "
        . " LEFT JOIN #__fb_users AS k ON k.userid=w.userid "
	# filter real public session logouts
        . " INNER JOIN #__session AS s ON s.guest='0' AND s.userid=w.userid "
        . " WHERE w.userid!='0' "
        . " GROUP BY u.id "
        . " ORDER BY username ASC";
    $kunena_db->setQuery($query);
    $users = $kunena_db->loadObjectList();
    check_dberror ( "Unable to load online users." );
    $totaluser = count($users);


    $query = "SELECT COUNT(*) FROM #__fb_whoisonline WHERE user='0'";
    $kunena_db->setQuery($query);
    $totalguests = $kunena_db->loadResult();
    check_dberror ( "Unable to load who is online." );
?>

<div class="k_bt_cvr1">
<div class="k_bt_cvr2">
<div class="k_bt_cvr3">
<div class="k_bt_cvr4">
<div class="k_bt_cvr5">
    <table class = "kblocktable" id ="kwhoisonline"  border = "0" cellspacing = "0" cellpadding = "0" width="100%">
        <thead>
            <tr>
                <th class="left">
                    <div class = "ktitle_cover km">
                        <?php $who_name = '<strong>'.$totaluser.' </strong>';
                        if($totaluser==1) { $who_name .= JText::_('COM_KUNENA_WHO_ONLINE_MEMBER').'&nbsp;'; } else { $who_name .= JText::_('COM_KUNENA_WHO_ONLINE_MEMBERS').'&nbsp;'; }
                        $who_name .= JText::_('COM_KUNENA_WHO_AND');
                        $who_name .= '<strong> '. $totalguests.' </strong>';
                        if($totalguests==1) { $who_name .= JText::_('COM_KUNENA_WHO_ONLINE_GUEST').'&nbsp;'; } else { $who_name .= JText::_('COM_KUNENA_WHO_ONLINE_GUESTS').'&nbsp;'; }
						$who_name .= JText::_('COM_KUNENA_WHO_ONLINE_NOW');
                        echo CKunenaLink::GetWhoIsOnlineLink($who_name, 'ktitle kl' );?>
                    </div>
                   <div class="fltrt">
						<span id="kwhoisonline_status"><a class="ktoggler close" rel="whoisonline_tbody"></a></span>
					</div>
                    <!-- <img id = "BoxSwitch_whoisonline__whoisonline_tbody" class = "hideshow" src = "<?php echo KUNENA_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/> -->
                </th>

            </tr>
        </thead>

        <tbody id = "whoisonline_tbody">
            <tr class = "ksectiontableentry1">
                <td class = "td-1 km" align="left">
                    <?php
                    foreach ($users as $user)
                    {
                        $time = date("H:i:s", $user->time);
                    ?>

                  		 <?php if ( $user->showOnline > 0 ){ ?>

                            <?php echo CKunenaLink::GetProfileLink ( $user->id, $user->username ); ;?> &nbsp;

                		  <?php  } ?>

                    <?php
                    }
                    ?>
                     <?php if ($kunena_is_a_moderator){

					 ?>

                    <br /><span class="ks"><?php echo JText::_('COM_KUNENA_HIDDEN_USERS'); ?>: </span>

                    <?php

					}
					?>
                         <?php
                    foreach ($users as $user)
                    {
                        $time = date("H:i:s", $user->time);
                    ?>

                  		 <?php if ( $kunena_is_a_moderator && $user->showOnline < 1 ){ ?>

                            <?php echo CKunenaLink::GetProfileLink ( $user->id, $user->username ); ;?> &nbsp;

                		  <?php   } ?>

                    <?php
                    }
                    ?>




                    <!--               groups     -->

                    <?php
                    $kunena_db->setQuery("SELECT id, title FROM #__fb_groups");
                    $gr_row = $kunena_db->loadObjectList();
                    check_dberror ( 'Unable to load group.' );

                    if (count($gr_row) > 1) {
					?>
                    <div class="kgrouplist ks">
                    <?php

                    foreach ($gr_row as $gr)
                    {
                    ?>

                        &nbsp; [ <span class = "<?php if ($gr->id > 1) {echo "kgroup_".$gr->id;}?>" title = "<?php echo $gr->title;?>"> <?php echo $gr->title; ?></span>]

                    <?php
                    } ?>

                    </div>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<!-- /WHOIS ONLINE -->

<?php
}
?>