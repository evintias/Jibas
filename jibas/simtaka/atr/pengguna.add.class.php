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
class CPenggunaAdd{
	function OnStart(){
		$this->nip="";
		if (isset($_REQUEST[nip]))
			$this->nip=$_REQUEST[nip];
		$this->tingkat=1;
		if (isset($_REQUEST[tingkat]))
			$this->tingkat=$_REQUEST[tingkat];	
		$this->nama="";
		if (isset($_REQUEST[nama]))
			$this->nama=$_REQUEST[nama];
		$this->perpustakaan=$_REQUEST[perpustakaan];
		$this->keterangan=CQ($_REQUEST[keterangan]);
		
		
		//echo "Tingkat=".$this->tingkat;		
		if (isset($_REQUEST[simpan])){
			
			$nip = $_REQUEST[nip];
			$sql = "SELECT * FROM ".get_db_name('user').".login WHERE login='$nip' ";
			$result = QueryDb($sql);
			$num = @mysql_num_rows($result);
			if ($num>0){
				$sql = "SELECT * FROM ".get_db_name('user').".hakakses WHERE login='$nip' AND modul='SIMTAKA' ";
				$result = QueryDb($sql);
				$num = @mysql_num_rows($result);
				if ($num==0){
					if ($this->tingkat=='1')
						$sql = "INSERT INTO ".get_db_name('user').".hakakses SET login='$nip', modul='SIMTAKA', tingkat='$this->tingkat', keterangan='$this->keterangan'";
					else
						$sql = "INSERT INTO ".get_db_name('user').".hakakses SET login='$nip', modul='SIMTAKA', tingkat='$this->tingkat', departemen='$this->perpustakaan', keterangan='$this->keterangan'"; 
					$result = QueryDb($sql);
					//echo $sql;
					if ($result)
						$this->success();
				} else {
					$this->success();
				}	
			} else {
				$password = trim(addslashes($_REQUEST[password1]));
				$sql = "INSERT INTO ".get_db_name('user').".login SET login='$nip', password='".md5($password)."'";
				$result = QueryDb($sql);
				$sql = "SELECT * FROM ".get_db_name('user').".hakakses WHERE login='$nip' AND modul='SIMTAKA' ";
				$result = QueryDb($sql);
				$num = @mysql_num_rows($result);
				if ($num==0){
					$sql = "INSERT INTO ".get_db_name('user').".hakakses SET login='$nip', modul='SIMTAKA', tingkat='$this->tingkat', departemen='$this->perpustakaan', keterangan='$this->keterangan'";
					$result = QueryDb($sql);
					if ($result)
						$this->success();
				} else {
					$this->success();
				}		
			}
		}
		
	}
	function exist(){
		?>
        <script language="javascript">
			alert('Kode sudah digunakan!');
			document.location.href="format.add.php";
		</script>
        <?
	}
	function success(){
		?>
        <script language="javascript">
			parent.opener.getfresh();
			window.close();
        </script>
        <?
	}
	function add(){
		
		?>
        <link href="../sty/style.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
<!--
.style1 {color: #FF9900}
-->
        </style>
        
        <form enctype="multipart/form-data" name="addpengguna" action="pengguna.add.php" onSubmit="return validate()" method="post">
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td colspan="2" align="left">
            	<font style="color:#FF9900; font-size:30px;"><strong>.:</strong></font>
        		<font style="font-size:18px; color:#999999">Tambah Pengguna</font></td>
  		  </tr>
          <tr>
            <td width="7%">&nbsp;<strong>Pegawai</strong></td>
            <td width="93%"><input name="nip" type="text" class="cmbfrm2" id="nip" size="10" readonly="readonly" onclick="cari()" value="<?=$this->nip?>">&nbsp;<input name="nama" type="text" class="cmbfrm2" id="nama" size="35" readonly="readonly" onclick="cari()" value="<?=$this->nama?>">&nbsp;<a href="javascript:cari()"><img src="../img/ico/cari.png" border="0" /></a></td>
          </tr>
          <?
          if ($this->nip!=""){
			  $sql = "SELECT * FROM ".get_db_name('user').".login WHERE login='$this->nip'";
			  $result = QueryDb($sql);
			  $num = @mysql_num_rows($result);
			  if ($num==0){
			  ?>
			  <tr>
				<td>&nbsp;Password</td>
				<td><input name="password1" type="password" class="inputtxt" id="password1" /></td>
			  </tr>
			  <tr>
				<td>&nbsp;Password(konfirmasi)</td>
				<td><input name="password2" type="password" class="inputtxt" id="password2" /></td>
			  </tr>
			  <?
			  } else {
			  ?>
			  <tr>
				<td colspan="2" align="center" class="err style1">Pengguna sudah memiliki password
                <input name="password1" type="hidden" class="inputtxt" id="password1" value="xxx" />
                <input name="password2" type="hidden" class="inputtxt" id="password2" value="xxx" />
                </td>
			  </tr>
			  <?
			  }
		  } else {
		  ?>
		  <input name="password1" type="hidden" class="inputtxt" id="password1" value="xxx" />
		  <input name="password2" type="hidden" class="inputtxt" id="password2" value="xxx" />
		  <?
		  }
	  
		  ?>
          <tr>
            <td>&nbsp;Tingkat</td>
            <td>
            	<select name="tingkat" id="tingkat" onchange="ChgTkt(2)">
                	<option value="1" <?=StringIsSelected('1',$this->tingkat)?> >Manajer Perpustakaan</option>
                    <option value="2" <?=StringIsSelected('2',$this->tingkat)?>>Staff Perpustakaan</option>
                </select>
            </td>
          </tr>
          <tr>
            <td>&nbsp;Perpustakaan</td>
            <td>
            	<select name="perpustakaan" id="perpustakaan">
                	<? if ($this->tingkat=='1') { ?>
                	<option value="-1" >Semua Perpustakaan</option>
                	<? } else { ?>
                    <?	$sql = "SELECT * FROM perpustakaan ORDER BY replid"; ?>
                    <?	$result = QueryDb($sql); ?>
					<?  while ($row = @mysql_fetch_array($result)){ ?>
                    	<option value="<?=$row[nama]?>" <?=StringIsSelected($row[nama],$this->perpustakaan)?>><?=$row[nama]?></option>
					<?	} ?>	
					<? } ?>
                </select>
            </td>
          </tr>
          <tr>
            <td>&nbsp;Keterangan</td>
            <td><textarea name="keterangan" cols="45" rows="5" class="areatxt" id="keterangan"></textarea></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" class="cmbfrm2" name="simpan" value="Simpan" >&nbsp;<input type="button" class="cmbfrm2" name="batal" value="Batal" onClick="window.close()" ></td>
          </tr>
        </table>
		</form>
		<?
	}
	function get_noreg(){
		return "ANG".date(YmdHis);
	}
}
?>