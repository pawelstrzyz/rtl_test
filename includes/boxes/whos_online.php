<?php
/*
  $Id: \includes\boxes\whos_online.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

$boxHeading = BOX_HEADING_WHOS_ONLINE;
$corner_left = 'rounded';
$corner_right = 'rounded';
$box_base_name = 'whos_online'; // for easy unique box template setup (added BTSv1.2)
$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
$boxContent_attributes = ' align="center"';


$n_members=0;$n_guests=0;$member_list='';

$whos_online_query = tep_db_query("select customer_id from " . TABLE_WHOS_ONLINE);
while ($whos_online = tep_db_fetch_array($whos_online_query)) {
  if (!$whos_online['customer_id'] == 0) {
     $n_members++;
     $member = tep_db_fetch_array(tep_db_query("select customers_firstname from ".TABLE_CUSTOMERS." where customers_id = '".$whos_online['customer_id']."'"));
     $member_list .= (($n_members > 1)?', ':'') . $member['customers_firstname'];
     }
   if ($whos_online['customer_id'] == 0) $n_guests++;
   }

$user_total = sprintf(tep_db_num_rows($whos_online_query));
$there_is_are = (($user_total == 1)? BOX_WHOS_ONLINE_THEREIS:BOX_WHOS_ONLINE_THEREARE);
$word_guest = '&nbsp;'.(($n_guests == 1)? BOX_WHOS_ONLINE_GUEST:BOX_WHOS_ONLINE_GUESTS);
$word_member = '&nbsp;' .(($n_members == 1)? BOX_WHOS_ONLINE_MEMBER:BOX_WHOS_ONLINE_MEMBERS);
if (($n_guests >= 1) && ($n_members >= 1)) $word_and = '&nbsp;' . BOX_WHOS_ONLINE_AND . '<br>';

$boxContent = '<span  class="smallText">'.$there_is_are.'<br>';
if ($n_guests >= 1) $boxContent .= '&nbsp;'.$n_guests . $word_guest; 

$boxContent .= $word_and; 
if ($n_members >= 1) {
  $boxContent .= '&nbsp;'. $n_members . $word_member;
  if (WHOS_ONLINE_LIST=='true') $boxContent .= '<br>('.$member_list.')';
  }
$boxContent .= '<br>&nbsp;online.</span>';
 
// bof BTSv1.2
    if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.tpl.php')) {
    // if exists, load unique box template for this box from templates/boxes/
        require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.tpl.php');
    }
    else {
    // load default box template: templates/boxes/box.tpl.php
        require(DIR_WS_BOX_TEMPLATES . TEMPLATENAME_BOX);
    }
// eof BTSv1.2

  $boxContent_attributes = '';


?>
<!-- whos_online_eof //-->