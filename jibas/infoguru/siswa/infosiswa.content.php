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
require_once('../include/sessionchecker.php');
require_once('../include/config.php');
require_once('../include/common.php');
require_once('../include/db_functions.php');
require_once('infosiswa.class.php');

OpenDb();
$S = new CInfoSiswa();
?>
<table border='0' width='100%' cellpadding='2'>
<tr>
    <td align='left' valign='top'>
<?      $S->ShowIdentity(); ?>            
<?      $S->ShowReportComboBox(); ?>
        <br><br>
        <table border="0" cellpadding="2" width="680"><tr><td align="left" valign="top">
        <div id="infosiswa.content">
<?      $S->ShowReportContent(); ?>
        </div>
        </td></tr></table>
    </td>
</tr>
</table>
<?
CloseDb();
?>