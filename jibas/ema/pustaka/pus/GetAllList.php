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
require_once('../../inc/config.php');
require_once('../../inc/db_functions.php');
require_once('../../inc/common.php');
OpenDb();
$waktu = $_REQUEST[waktu];
$waktu = split('-', $waktu);
$sql = "SELECT p.idanggota, p.tglpinjam FROM $db_name_perpus.pinjam p, $db_name_perpus.daftarpustaka d, $db_name_perpus.pustaka pu WHERE MONTH(p.tglpinjam)='$waktu[0]' AND YEAR(p.tglpinjam)='$waktu[1]' AND p.kodepustaka=d.kodepustaka AND d.pustaka=pu.replid";
$result = QueryDb($sql);
$cnt=1;
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab">
  <tr>
    <td height="25" align="center" class="header">No</td>
    <td height="25" align="center" class="header">Peminjam</td>
    <td height="25" align="center" class="header">Tgl Pinjam</td>
    <td height="25" align="center" class="header">&nbsp;</td>
  </tr>
  <? while ($row = @mysql_fetch_row($result)) { ?>
  <tr>
    <td height="20" align="center"><?=$cnt?></td>
    <td height="20">&nbsp;<?=$row[0]." - ".GetMemberName($row[0])?></td>
    <td height="20" align="center"><?=LongDateFormat($row[1])?></td>
    <td height="20" align="center">
        <!--<a href="javascript:ViewList('<?//=$this->idanggota?>')"><img src="../img/ico/lihat.png" width="16" height="16" border="0" /></a>-->
    </td>
  </tr>
  <? $cnt++; ?>
  <? } ?>
</table>
<?
function GetMemberName($idanggota){
	global $db_name_akad;
	global $db_name_sdm;
	global $db_name_perpus;
	$sql1 = "SELECT nama FROM $db_name_akad.siswa WHERE nis='$idanggota'";
	$result1 = QueryDb($sql1);
	if (@mysql_num_rows($result1)>0){
		$row1 = @mysql_fetch_array($result1);
		return $row1[nama];
	} else {
		$sql2 = "SELECT nama FROM $db_name_sdm.pegawai WHERE nip='$idanggota'";
		$result2 = QueryDb($sql2);
		if (@mysql_num_rows($result2)>0){
			$row2 = @mysql_fetch_array($result2);
			return $row2[nama];
		} else {
			$sql3 = "SELECT nama FROM $db_name_perpus.anggota WHERE noregistrasi='$idanggota'";
			$result3 = QueryDb($sql3);
			if (@mysql_num_rows($result3)>0){
				$row3 = @mysql_fetch_array($result3);
				return $row3[nama];
			} else {
				return "Tanpa Nama";
			}
		}
	}
}
?>