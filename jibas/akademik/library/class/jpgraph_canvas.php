<?
/**[N]**
 * JIBAS Road To Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 2.5.0 (Juni 20, 2011)
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
/*=======================================================================
// File: 	JPGRAPH_CANVAS.PHP
// Description:	Canvas drawing extension for JpGraph
// Created: 	2001-01-08
// Author:	Johan Persson (johanp@aditus.nu)
// Ver:		$Id: jpgraph_canvas.php 548 2006-02-18 07:29:57Z ljp $
//
// Copyright (c) Aditus Consulting. All rights reserved.
//========================================================================
*/

//===================================================
// CLASS CanvasGraph
// Description: Creates a simple canvas graph which
// might be used together with the basic Image drawing
// primitives. Useful to auickoly produce some arbitrary
// graphic which benefits from all the functionality in the
// graph liek caching for example. 
//===================================================
class CanvasGraph extends Graph {
//---------------
// CONSTRUCTOR
    function CanvasGraph($aWidth=300,$aHeight=200,$aCachedName="",$timeout=0,$inline=1) {
	$this->Graph($aWidth,$aHeight,$aCachedName,$timeout,$inline);
    }

//---------------
// PUBLIC METHODS	

    function InitFrame() {
	$this->StrokePlotArea();
    }

    // Method description
    function Stroke($aStrokeFileName="") {
	if( $this->texts != null ) {
	    for($i=0; $i < count($this->texts); ++$i) {
		$this->texts[$i]->Stroke($this->img);
	    }
	}		
	if( $this->iTables !== null ) {
	    for($i=0; $i < count($this->iTables); ++$i) {
		$this->iTables[$i]->Stroke($this->img);
	    }   
	}
	$this->StrokeTitles();

	// Should we do any final image transformation
	if( $this->iImgTrans ) {
	    if( !class_exists('ImgTrans',false) ) {
		require_once('jpgraph_imgtrans.php');
	    }
	    
	    $tform = new ImgTrans($this->img->img);
	    $this->img->img = $tform->Skew3D($this->iImgTransHorizon,$this->iImgTransSkewDist,
					     $this->iImgTransDirection,$this->iImgTransHighQ,
					     $this->iImgTransMinSize,$this->iImgTransFillColor,
					     $this->iImgTransBorder);
	}
	

	// If the filename is given as the special _IMG_HANDLER
	// then the image handler is returned and the image is NOT
	// streamed back
	if( $aStrokeFileName == _IMG_HANDLER ) {
	    return $this->img->img;
	}
	else {
	    // Finally stream the generated picture					
	    $this->cache->PutAndStream($this->img,$this->cache_name,$this->inline,$aStrokeFileName);
	    return true;		
	}
    }
} // Class
/* EOF */
?>