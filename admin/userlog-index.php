<?php // $Revision: 1.1 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.2"));

// Load translations
require ("../language/".strtolower($phpAds_config['language'])."/userlog.lang.php");



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$res = phpAds_dbQuery("
	SELECT
		*
	FROM 
		".$phpAds_config['tbl_userlog']."
	ORDER BY
		timestamp DESC
");


echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
echo "<tr><td height='25'>&nbsp;&nbsp;<b>".$strDate."</b></td>";
echo "<td height='25'><b>".$strAction."</b></td></tr>";
echo "<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";


if (phpAds_dbNumRows($res) == 0)
{
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='4'>";
	echo "&nbsp;&nbsp;".$strNoActionsLogged."</td></tr>";
	echo "<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
}

$i=0;

while ($row = phpAds_dbFetchArray($res))
{
	if ($i > 0) echo "<td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	
	// Timestamp
	echo "<td height='25'>&nbsp;&nbsp;".strftime($date_format, $row['timestamp']).", ";
	echo strftime($minute_format, $row['timestamp'])."</td>";
	
	// User
	echo "<td height='25'>";
	switch ($row['usertype'])
	{
		case phpAds_userDeliveryEngine:	echo "<img src='images/icon-generatecode.gif' align='absmiddle'>&nbsp;".$strDeliveryEngine; break;
		case phpAds_userMaintenance:	echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;".$strMaintenance; break;
		case phpAds_userAdministrator:	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".$strAdministrator; break;
	}
	echo "</td>";
	
	// Details
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
	if ($row['details'] != '')
	{
		echo "<a href='userlog-details.php?userlogid=".$row['userlogid']."'>";
		echo "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;".$strDetails."</a>";
	}
	else
		echo "&nbsp;";
	echo "&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	// Space
	echo "<tr height='20' valign='top' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	echo "<td>&nbsp;</td>";
	
	// Action
	$action = $strUserlog[$row['action']];
	$action = str_replace ('{id}', $row['object'], $action);
	echo "<td height='20' colspan='2'><img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;".$action."</td>";
	echo "</tr>";
	
	$i++;
}

if (phpAds_dbNumRows($res) > 0)
{
	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='25' colspan='4'>";
	echo "<a href='userlog-delete.php'><img src='images/icon-recycle.gif' border='0' align='absmiddle'>&nbsp;".$strDeleteLog."</a>";
	echo "</td></tr>";
}

echo "</table>";
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>