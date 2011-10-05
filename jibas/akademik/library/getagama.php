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
require_once('../include/errorhandler.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$agama_kiriman=$_REQUEST['agama'];

?>

<select name="agama" id="agama" class="ukuran" onKeyPress="return focusNext('suku', event)">
	<option value="">[Pilih Agama]</option>
    <? // Olah untuk combo agama
	 
	OpenDb();
	$sql_agama="SELECT replid,agama,urutan FROM jbsumum.agama ORDER BY urutan";
	$result_agama=QueryDB($sql_agama);
	while ($row_agama = mysql_fetch_array($result_agama)) {
	//if($agama_kiriman=="")
	//	$agama_kiriman=$row_agama['agama'];
	?>
	<option value="<?=$row_agama['agama']?>"<?=StringIsSelected($row_agama['agama'],$agama_kiriman)?>><?=$row_agama['agama']?></option>
	<!--
   
    -->
	<?
    } 
	CloseDb();
	// Akhir Olah Data agama
	?>
    </select>	
	
    <img src="../images/ico/tambah.png" onclick="tambah_agama();" onMouseOver="showhint('Tambah Agama!', this, event, '50px')"/>