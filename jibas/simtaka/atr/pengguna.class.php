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
class CPengguna{
	function OnStart(){
		$op=$_REQUEST[op];
		if ($op=="del"){
			$sql = "DELETE FROM ".get_db_name('user').".hakakses WHERE login='$_REQUEST[login]' AND modul='SIMTAKA'";
			QueryDb($sql);
			$sql = "SELECT * FROM ".get_db_name('user').".hakakses WHERE login='$_REQUEST[login]' AND modul<>'SIMTAKA'";
			$result = QueryDb($sql);
			$num = @mysql_num_rows($result);
			if ($num==0){
				$sql = "DELETE FROM ".get_db_name('user').".login WHERE login='$_REQUEST[login]'";
				QueryDb($sql);
			}
		}
		if ($op=="nyd6j287sy388s3h8s8"){
			$sql = "UPDATE ".get_db_name('user').".hakakses SET aktif=$_REQUEST[newaktif] WHERE login='$_REQUEST[login]' AND modul='SIMTAKA'";
			QueryDb($sql);
		}
	}
	function OnFinish(){
		?>
		<script language='JavaScript'>
			Tables('table', 1, 0);
		</script>
		<?
    }
    function Content(){
		$sql = "SELECT h.login, h.aktif, h.lastlogin, h.departemen, h.tingkat, h.keterangan FROM ".get_db_name('user').".hakakses h, ".get_db_name('user').".login l WHERE h.modul='SIMTAKA' AND l.login=h.login";
		$result = QueryDb($sql);
		$num = @mysql_num_rows($result);
		?>
		<link href="../sty/style.css" rel="stylesheet" type="text/css">
        <div class="funct">
        	<a href="javascript:getfresh()"><img src="../img/ico/refresh.png" border="0">&nbsp;Refresh</a>&nbsp;&nbsp;
			<a href="javascript:cetak()"><img src="../img/ico/print1.png" border="0">&nbsp;Cetak</a>&nbsp;&nbsp;
			<? if (IsAdmin()) { ?>
				<a href="javascript:tambah()"><img src="../img/ico/tambah.png" border="0">&nbsp;Tambah&nbsp;Pengguna</a>&nbsp;        
			<? } ?>
		</div>
        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab" id="table">
          <tr>
            <td height="30" align="center" class="header">NIP</td>
            <td height="30" align="center" class="header">Nama</td>
            <td align="center" class="header">Tingkat</td>
            <td align="center" class="header">Perpustakaan</td>
			<td align="center" class="header">Keterangan</td>
            <? if (IsAdmin()) { ?>
			<td align="center" class="header">&nbsp;</td>
            <td height="30" align="center" class="header">&nbsp;</td>
			<? } ?>
		  </tr>
          <?
		  if ($num>0){
			  while ($row=@mysql_fetch_row($result)){
			  $sql = "SELECT nama FROM ".get_db_name('sdm').".pegawai WHERE nip='$row[0]'";
			  $res = QueryDb($sql);
			  $r = @mysql_fetch_row($res);
			  $namapeg = $r[0];
			  if ($row[4]==2){
				  $sql = "SELECT nama FROM perpustakaan WHERE nama='$row[3]'";
				  $res = QueryDb($sql);
				  $r = @mysql_fetch_row($res);
				  $namaperpus = $r[0];
				  $namatingkat = "Staf Perpustakaan";
			  } else {
			  	  $namaperpus = "<i>Semua</i>";
				  $namatingkat = "Manajer Perpustakaan";
			  }
			  ?>
			  <tr>
				<td height="25" align="center"><?=$row[0]?></td>
				<td height="25" align="center"><div class="tab_content"><?=$namapeg?></div></td>
				<td align="center"><?=$namatingkat?></td>
				<td align="center"><?=$namaperpus?></td>
				<td align="left"><?=$row[5]?></td>
				<? if (IsAdmin()) { ?>
				<td align="center">
                	<? if ($row[1]==1) { ?>
                    	<a href="javascript:setaktif('<?=$row[0]?>','0')"><img src="../img/ico/aktif.png" width="16" height="16" border="0" /></a>
                    <? } else { ?>    
                        <a href="javascript:setaktif('<?=$row[0]?>','1')"><img src="../img/ico/nonaktif.png" width="16" height="16" border="0" /></a>
                	<? } ?>                </td>
				<td height="25" align="center" bgcolor="#FFFFFF">
                	<table border="0" cellspacing="1" cellpadding="1">
                      <tr>
                        <td><a href="javascript:ubah('<?=$row[0]?>')"><img src="../img/ico/ubah.png" border="0"></a></td>
                        <td><a href="javascript:hapus('<?=$row[0]?>')"><img src="../img/ico/hapus.png" border="0"></a></td>
                      </tr>
                    </table>                </td>
				<? } ?>
			  </tr>
			  <?
			  }
		  } else {
		  ?>
          <tr>
            <td height="25" colspan="9" align="center" class="nodata">Tidak ada data</td>
          </tr>
		  <?
		  }
		  ?>	
        </table>

        <?
	}
}
?>