<?
/**[N]**
 * JIBAS Road To Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 2.5.2 (October 5, 2011)
 * @notes: JIBAS Education Community will be managed by Yayasan Indonesia Membaca (http://www.indonesiamembaca.net)
 * 
 * Copyright (C) 2009 PT.Galileo Mitra Solusitama (http://www.galileoms.com)
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
$departemen=$_REQUEST['departemen'];
$tingkat=$_REQUEST['tingkat'];
$tahunajaran=$_REQUEST['tahunajaran'];


?>
<frameset cols="37%,*" border="1" framespacing="yes" frameborder="yes">
<frameset rows="140,*" border="1" framespacing="yes" frameborder="no">
<frame src="alumni_menu.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>" name="alumni_menu" scrolling="No" noresize="noresize" id="alumni_menu" title="alumni_menu" style="border:1; border-bottom-color:#000000; border-bottom-style:solid"/>
<frame src="blank_alumni.php" name="alumni_pilih" id="alumni_pilih" title="alumni_pilih" />
</frameset> 
<frame src="alumni_content.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>" name="alumni_content" id="alumni_content" title="alumni_content" style="border:1; border-left-color:#000000; border-left-style:solid"/>
</frameset><noframes></noframes>