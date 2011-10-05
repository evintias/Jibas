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
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/theme.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../cek.php');

$replid = $_REQUEST['replid'];
$departemen = $_REQUEST['departemen'];
$cek = 0;
$ERROR_MSG = "";
if (isset($_REQUEST['Simpan'])) 
{
	OpenDb();
	
	$sql = "SELECT * FROM tingkat WHERE tingkat = '$_REQUEST[tingkat]' AND replid <> '$replid' AND departemen = '$departemen'";
	$result = QueryDb($sql);
	
	$sql1 = "SELECT * FROM tingkat WHERE urutan = '$_REQUEST[urutan]' AND replid <> '$replid' AND departemen = '$departemen'";
	$result1 = QueryDb($sql1);
	
	if (@mysql_num_rows($result) > 0) 
	{
		$row = @mysql_fetch_array($result);
		CloseDb();
		$ERROR_MSG = "Tingkat $_REQUEST[tingkat] sudah digunakan pada Departemen $row[departemen]!";
	} 
	else if (mysql_num_rows($result1) > 0) 
	{
		CloseDb();
		$ERROR_MSG = "Urutan $_REQUEST[urutan] sudah digunakan!";
		$cek = 1;
	} 
	else 
	{
		$sql = "UPDATE tingkat SET tingkat='".CQ($_REQUEST['tingkat'])."',keterangan='".CQ($_REQUEST['keterangan'])."',urutan='$_REQUEST[urutan]' WHERE replid='$replid'";
		$result = QueryDb($sql);
		CloseDb();
	
		if ($result) 
		{ ?>
			<script language="javascript">
				opener.refresh();
				window.close();
			</script> 
<?		}
		exit();
	}
};


switch ($cek) {
	case 0 : $input_awal = "onload=\"document.getElementById('tingkat').focus()\"";
		break;
	case 1 : $input_awal = "onload=\"document.getElementById('urutan').focus()\"";
		break;
}

OpenDb();

$sql = "SELECT tingkat,departemen,urutan,keterangan,aktif FROM tingkat WHERE replid='$replid' ORDER BY tingkat";
$result = QueryDb($sql);
$row = mysql_fetch_row($result);
$tingkat = $row[0];
$departemen = $row[1];
$urutan = $row[2];
$keterangan = $row[3];
CloseDb();

if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];
if (isset($_REQUEST['keterangan']))
	$keterangan = $_REQUEST['keterangan'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Ubah Tingkat]</title>
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">

function validate() {
	return validateEmptyText('tingkat', 'Nama Tingkat') && 
		   validateEmptyText('urutan', 'Urutan Tingkat') &&
		   validateNumber('urutan', 'Urutan Tingkat') &&
		   validateMaxText('keterangan', 255, 'Keterangan');
}

function focusNext(elemName, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
		document.getElementById(elemName).focus();
		return false;
    } 
    return true;
}

function panggil(elem){
	var lain = new Array('tingkat','urutan','keterangan');
	for (i=0;i<lain.length;i++) {
		if (lain[i] == elem) {
			document.getElementById(elem).style.background='#4cff15';
		} else {
			document.getElementById(lain[i]).style.background='#FFFFFF';
		}
	}
}
</script>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" <?=$input_awal?>>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Ubah Tingkat :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
<form name="main" onSubmit="return validate()" action="tingkat_edit.php">
<input type="hidden" name="replid" id="replid" value="<?=$replid ?>" />
<table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
<!-- TABLE CONTENT -->
<tr>
	<td width="120"><strong>Departemen</strong></td>
	<td><input type="text" size="10" value="<?=$departemen ?>" class="disabled" readonly/>
    <input type="hidden" name="departemen" id="departemen" value="<?=$departemen ?>" />
    </td>
</tr>
<tr>
    <td><strong>Tingkat</strong></td>
    <td>
    	<input type="text" name="tingkat" id="tingkat"size="30" maxlength="50" value="<?=$tingkat ?>" onFocus="showhint('Nama tingkat tidak boleh lebih dari 50 karakter!', this, event, '120px');panggil('tingkat')"  onKeyPress="return focusNext('urutan', event)" />
    

    </td>
</tr>
<tr>
	<td><strong>Urutan</strong></td>
	<td>
    	<input type="text" name="urutan" id="urutan" size="3" maxlength="5" value="<?=$urutan ?>" onFocus="showhint('Urutan penampilan tingkat', this, event, '120px');panggil('urutan')"  onKeyPress="return focusNext('keterangan', event)" />
    </td>
</tr>
<tr>
	<td valign="top">Keterangan</td>
	<td>
    	<textarea name="keterangan" id="keterangan" rows="3" cols="45"  onKeyPress="return focusNext('Simpan', event)" onFocus="panggil('keterangan')"><?=$keterangan ?></textarea>
    </td>
</tr>
<tr>
	<td colspan="2" align="center">
    <input type="submit" name="Simpan" id="Simpan" value="Simpan" class="but" onFocus="panggil('Simpan')"/>&nbsp;
    <input type="button" name="Tutup" id="Tutup" value="Tutup" class="but" onClick="window.close()" />
    </td>
</tr>
<!-- END OF TABLE CONTENT -->
</table>
</form>

    <!-- END OF CONTENT //--->
    </td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_06a.jpg">&nbsp;</td>
</tr>
<tr height="28">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_07.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_08a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_09.jpg">&nbsp;</td>
</tr>
</table>
<!-- Tamplikan error jika ada -->
<? if (strlen($ERROR_MSG) > 0) { ?>
<script language="javascript">
	alert('<?=$ERROR_MSG?>');
</script>
<? } ?>
</body>
</html>