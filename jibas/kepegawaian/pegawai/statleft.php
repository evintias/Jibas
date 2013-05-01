<?
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 3.0 (January 09, 2013)
 * @notes: JIBAS Education Community will be managed by Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 *  
 * Copyright (C) 2009 Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 **[N]**/ ?>
<?
require_once("../include/sessionchecker.php");
$stat = $_REQUEST['stat'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS Kepegawaian</title>
<script language="javascript">
function ChangePage(type) 
{
	if (type == 1)
	{
		document['stat'].src = "../images/stata.jpg";
		document['rekap'].src = "../images/rekapb.jpg";
		parent.statright.location.href = "statview.php?stat=<?=$stat?>";
	} 
	else
	{
		document['stat'].src = "../images/statb.jpg";
		document['rekap'].src = "../images/rekapa.jpg";
		parent.statright.location.href = "rekapview.php?stat=<?=$stat?>";
	}
}
</script>
</head>

<body style="background-color:#6d6d6d" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<a href="JavaScript:ChangePage(1)"><img name="stat" src="../images/stata.jpg" border="0" /></a><br />
<a href="JavaScript:ChangePage(2)"><img name="rekap" src="../images/rekapb.jpg" border="0" /></a>
</body>
</html>