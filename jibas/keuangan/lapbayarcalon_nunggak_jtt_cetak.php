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
require_once('include/errorhandler.php');
require_once('include/sessionchecker.php');
require_once('include/common.php');
require_once('include/rupiah.php');
require_once('include/config.php');
require_once('include/db_functions.php');
require_once('include/getheader.php'); 
require_once('library/jurnal.php');
require_once('library/repairdatajttcalon.php');

$urut=$_REQUEST['urut'];
$urutan = $_REQUEST['urutan'];
$varbaris = $_REQUEST['varbaris'];	
$page = $_REQUEST['page'];
$total = $_REQUEST['total'];

$idtahunbuku = 0;
if (isset($_REQUEST['idtahunbuku']))
	$idtahunbuku = (int)$_REQUEST['idtahunbuku'];

if (isset($_REQUEST['idpenerimaan']))
	$idpenerimaan = (int)$_REQUEST['idpenerimaan'];

if (isset($_REQUEST['kelompok']))
	$kelompok = (int)$_REQUEST['kelompok'];
	
if (isset($_REQUEST['telat']))
	$telat = (int)$_REQUEST['telat'];
	
$tanggal = "";
if (isset($_REQUEST['tanggal'])) 
	$tanggal = $_REQUEST['tanggal'];

$tgl = MySqlDateFormat($tanggal);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS KEU [Laporan Tunggakan Iuran Wajib Calon Siswa Per Kelompok]</title>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript" src="script/tools.js"></script>
</head>

<body>
<?
OpenDb();
if ($kelompok == -1) 
{
	$sql = "SELECT idbesarjttcalon, datediff('$tgl', max(tanggal)) as x 
	          FROM penerimaanjttcalon p , besarjttcalon b, jbsakad.calonsiswa c, jbsakad.prosespenerimaansiswa r 
			   WHERE p.idbesarjttcalon = b.replid AND b.lunas = 0 AND b.idpenerimaan = '$idpenerimaan' AND b.info2='$idtahunbuku'
				  AND c.replid = b.idcalon AND c.idproses = r.replid AND r.aktif = 1 
		   GROUP BY idbesarjttcalon 
		     HAVING x >= $telat";
} 
else 
{
	$sql = "SELECT idbesarjttcalon, datediff('$tgl', max(tanggal)) as x 
	          FROM penerimaanjttcalon p , besarjttcalon b, jbsakad.calonsiswa c 
				WHERE p.idbesarjttcalon = b.replid AND b.lunas = 0 AND b.info2='$idtahunbuku' AND c.replid = b.idcalon 
				  AND c.idkelompok = '$kelompok' AND b.idpenerimaan = '$idpenerimaan' 
		   GROUP BY idbesarjttcalon 
			  HAVING x >= $telat";
} 	

//echo  "$sql<br>";
$result = QueryDb($sql);
$idstr = "";
while($row = mysql_fetch_row($result)) {
	if (strlen($idstr) > 0)
		$idstr = $idstr . ",";
	$idstr = $idstr . $row[0];
}
//echo  "$idstr<br>";
if (strlen($idstr) == 0) {
	echo  "Tidak ditemukan data!";
	CloseDb();
	exit();
}

$sql = "SELECT MAX(jumlah) FROM (SELECT idbesarjttcalon, count(replid) AS jumlah FROM penerimaanjttcalon WHERE idbesarjttcalon IN ($idstr) GROUP BY idbesarjttcalon) AS X";
//echo  "$sql<br>";
$result = QueryDb($sql);
$row = mysql_fetch_row($result);
$max_n_cicilan = $row[0];
$table_width = 810 + $max_n_cicilan * 90;

//Dapatkan namapenerimaan
$sql = "SELECT nama, departemen FROM datapenerimaan WHERE replid = '$idpenerimaan'";
$result = QueryDb($sql);
$row = mysql_fetch_row($result);
$namapenerimaan = $row[0];
$departemen = $row[1];

$namakelompok = "Semua Kelompok";
if ($kelompok <> -1) {
	$sql = "SELECT proses, kelompok FROM jbsakad.kelompokcalonsiswa k, jbsakad.prosespenerimaansiswa p WHERE k.replid = '$kelompok' AND k.idproses = p.replid";
	$result = QueryDb($sql);
	$row = mysql_fetch_row($result);
	$namaproses = $row[0];
	$namakelompok = $row[1];	
} else  {
	$sql = "SELECT proses FROM jbsakad.prosespenerimaansiswa p WHERE p.aktif = 1";
	$result = QueryDb($sql);
	$row = mysql_fetch_row($result);
	$namaproses = $row[0];
}
?>

<table border="0" cellpadding="10" cellpadding="5" width="<?=$table_width + 50 ?>" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>

<center><font size="4"><strong>LAPORAN TUNGGAKAN <?=strtoupper($namapenerimaan) ?><br />
</strong></font><br /> </center><br />
<table border="0">
<tr>
	<td><strong>Departemen </strong></td>
    <td><strong>: <?=$departemen?></strong></td>
</tr>
<tr>
	<td><strong>Proses</strong></td>
    <td><strong>: <?=$namaproses?></strong></td>
</tr>
<tr>
	<td><strong>Kelompok</strong></td>
    <td><strong>: <?=$namakelompok?></strong></td>
</tr>
<tr>
	<td><strong>Telat Bayar </strong></td>
    <td><strong>: <?=$telat ?> hari dari tanggal <?=LongDateFormat($tanggal)?></strong></td>
</tr>
</table>
<br />

<table class="tab" id="table" border="1" cellpadding="5" style="border-collapse:collapse" cellspacing="0" width="<?=$table_width ?>" align="left" bordercolor="#000000">
<tr height="30">
	<td class="header" width="30" align="center">No</td>
    <td class="header" width="80" align="center">No. Reg</td>
    <td class="header" width="140" align="center">Nama</td>
    <td class="header" width="50" align="center">Kel</td>
    <? 	for($i = 0; $i < $max_n_cicilan; $i++) { 
			$n = $i + 1; ?>
    		<td class="header" width="120" align="center"><?="Bayaran-$n" ?></td>	
    <?  } ?>
    <td class="header" width="80" align="center">Telat<br /><em>(hari)</em></td>
    <td class="header" width="120" align="center"><?=$namapenerimaan ?></td>
    <td class="header" width="120" align="center">Total Pembayaran</td>
    <td class="header" width="120" align="center">Total Tunggakan</td>
    <td class="header" width="200" align="center">Keterangan</td>
</tr>
<?
OpenDb();
$sql_tot = "SELECT c.nopendaftaran, c.nama, k.kelompok, b.replid AS id, b.besar, b.keterangan, b.lunas 
              FROM jbsakad.calonsiswa c, jbsakad.kelompokcalonsiswa k, besarjttcalon b 
				 WHERE c.replid = b.idcalon AND c.idkelompok = k.replid AND b.replid IN ($idstr) ORDER BY c.nama";

$sql = "SELECT c.nopendaftaran, c.nama, k.kelompok, b.replid AS id, b.besar, b.keterangan, b.lunas 
          FROM jbsakad.calonsiswa c, jbsakad.kelompokcalonsiswa k, besarjttcalon b 
			WHERE c.replid = b.idcalon AND c.idkelompok = k.replid AND b.replid IN ($idstr) 
		ORDER BY $urut $urutan";
$result = QueryDb($sql);
$cnt = 0;
$totalbiayaall = 0;
$totalbayarall = 0;

while ($row = mysql_fetch_array($result)) {
	$idbesarjtt = $row['id'];
	$besarjtt = $row['besar'];
	$ketjtt = $row['keterangan'];
	$lunasjtt = $row['lunas'];
	$infojtt = "<font color=red><strong>Belum Lunas</strong></font>";
	if ($lunasjtt == 1)
		$infojtt = "<font color=blue><strong>Lunas</strong></font>";
	$totalbiayaall += $besarjtt;
		
?>
<tr height="40">
	<td align="center"><?=++$cnt ?></td>
    <td align="center"><?=$row['nopendaftaran'] ?></td>
    <td><?=$row['nama'] ?></td>
    <td align="center"><?=$row['kelompok'] ?></td>
    <?
	$sql = "SELECT count(*) FROM penerimaanjttcalon WHERE idbesarjttcalon = '$idbesarjtt'";
	$result2 = QueryDb($sql);
	$row2 = mysql_fetch_row($result2);
	$nbayar = $row2[0];
	$nblank = $max_n_cicilan - $nbayar;
	$totalbayar = 0;
	
	if ($nbayar > 0) {
		$sql = "SELECT date_format(tanggal, '%d-%b-%y'), jumlah FROM penerimaanjttcalon WHERE idbesarjttcalon = '$idbesarjtt' ORDER BY tanggal";
		$result2 = QueryDb($sql);
		while ($row2 = mysql_fetch_row($result2)) {
			$totalbayar = $totalbayar + $row2[1]; ?>
            <td>
                <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse" bordercolor="#000000">
                <tr height="20"><td align="center"><?=FormatRupiah($row2[1]) ?></td></tr>
                <tr height="20"><td align="center"><?=$row2[0] ?></td></tr>
                </table>
            </td>
 <?		}
 		$totalbayarall += $totalbayar;
	}	
	for ($i = 0; $i < $nblank; $i++) { ?>
	    <td>
            <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse" bordercolor="#000000">
            <tr height="20"><td align="center">&nbsp;</td></tr>
            <tr height="20"><td align="center">&nbsp;</td></tr>
            </table>
        </td>
    <? }?>
    <td align="center">
<?	$sql = "SELECT max(datediff('$tgl', tanggal)) FROM penerimaanjttcalon WHERE idbesarjttcalon = '$idbesarjtt'";
	$result2 = QueryDb($sql);
	$row2 = mysql_fetch_row($result2);
	echo  $row2[0]; ?>
    </td>
    <td align="right"><?=FormatRupiah($besarjtt) ?></td>
    <td align="right"><?=FormatRupiah($totalbayar) ?></td>
    <td align="right"><?=FormatRupiah($besarjtt - $totalbayar) ?></td>
    <td><?=$ketjtt ?></td>
</tr>
<?
}
?>
<tr height="40">
	<td align="center" colspan="<?=5 + $max_n_cicilan ?>" bgcolor="#999900"><font color="#FFFFFF"><strong>T O T A L</strong></font></td>
	<td align="right" bgcolor="#999900"><font color="#FFFFFF"><strong><?=FormatRupiah($totalbiayaall) ?></strong></font></td>
    <td align="right" bgcolor="#999900"><font color="#FFFFFF"><strong><?=FormatRupiah($totalbayarall) ?></strong></font></td>
    <td align="right" bgcolor="#999900"><font color="#FFFFFF"><strong><?=FormatRupiah($totalbiayaall - $totalbayarall) ?></strong></font></td>
    <td bgcolor="#999900">&nbsp;</td>
</tr>
</table>
<? CloseDb() ?>
<!-- END TABLE CONTENT -->
    
	</td>
</tr>
    </table>
</td></tr></table>
</body>
</html>
<script language="javascript">window.print();</script>