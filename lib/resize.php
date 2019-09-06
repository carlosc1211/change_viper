<?php
/*
##############################################
# Shiege Iseng Resize Class
# 11 March 2003
# shiegege_at_yahoo.com
# View Demo :
#   http://shiege.com/scripts/thumbnail/
############################################
# Damaso Lugo
# 08 Febrero 2010
# Modificacion. Se agrega opcion para carga del archivo, eliminar y marca de agua
#############################################
Sample :
$thumb=new thumbnail("./shiegege.jpg","../ubicacion",$elimina);					// generate image_file, set filename to resize
$thumb->size_width(320);												// set width for thumbnail, or
$thumb->size_height(240);												// set height for thumbnail, or
$thumb->size_auto(200);													// set the biggest width or height for thumbnail
$thumb->jpeg_quality(75);												// [OPTIONAL] set quality for jpeg only (0 - 100) (worst - best), default = 75
$thumb->save("./huhu.jpg","marcadeagua.png");		// save your thumbnail to file
----------------------------------------------
Note :
- GD must Enabled
- Autodetect file extension (.jpg/jpeg, .png, .gif, .wbmp)
  but some server can't generate .gif / .wbmp file types
- If your GD not support 'ImageCreateTrueColor' function,
  change one line from 'ImageCreateTrueColor' to 'ImageCreate'
  (the position in 'show' and 'save' function)
############################################
*/


class thumbnail
{
	var $img;

	function thumbnail($campo,$ruta,$elimina)
	{
		//upload image
		$imgfile = elimina_acentos($_FILES[$campo]['name']);
		move_uploaded_file($_FILES[$campo]['tmp_name'], "$ruta/$imgfile");

		//detect image format
		$this->img["format"]=ereg_replace(".*\.(.*)$","\\1",$imgfile);
		$this->img["format"]=strtoupper($this->img["format"]);
		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
			//JPEG
			$this->img["format"]="JPEG";
			$this->img["src"] = ImageCreateFromJPEG ("$ruta/$imgfile");
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			$this->img["format"]="PNG";
			$this->img["src"] = ImageCreateFromPNG ("$ruta/$imgfile");
		} elseif ($this->img["format"]=="GIF") {
			//GIF
			$this->img["format"]="GIF";
			$this->img["src"] = ImageCreateFromGIF ("$ruta/$imgfile");
		} elseif ($this->img["format"]=="WBMP") {
			//WBMP
			$this->img["format"]="WBMP";
			$this->img["src"] = ImageCreateFromWBMP ("$ruta/$imgfile");
		} else {
			//DEFAULT
			//echo "Not Supported File";
			exit();
		}
		@$this->img["lebar"] = imagesx($this->img["src"]);
		@$this->img["tinggi"] = imagesy($this->img["src"]);
		//default quality jpeg
		$this->img["quality"]=100;
		
		//remove original image
		$elimina==1?unlink("$ruta/$imgfile"):'';
	}

	function size_height($size=100)
	{
		//height
    	$this->img["tinggi_thumb"]=$size;
    	@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
	}

	function size_width($size=100)
	{
		//width
		$this->img["lebar_thumb"]=$size;
    	@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
	}

	function size_auto($size=100)
	{
		//size
		if ($this->img["lebar"]>=$this->img["tinggi"]) {
    		$this->img["lebar_thumb"]=$size;
    		@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
		} else {
	    	$this->img["tinggi_thumb"]=$size;
    		@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
 		}
	}

	function jpeg_quality($quality=100)
	{
		//jpeg quality
		$this->img["quality"]=$quality;
	}

	function save($save="",$watermark)
	{	
		//save thumb
		if (empty($save)) $save=strtolower("./thumb.".$this->img["format"]);
		/* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function*/
		$this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
		@imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
			//JPEG
			imageJPEG($this->img["des"],"$save",$this->img["quality"]);
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			imagePNG($this->img["des"],"$save");
		} elseif ($this->img["format"]=="GIF") {
			//GIF
			imageGIF($this->img["des"],"$save");
		} elseif ($this->img["format"]=="WBMP") {
			//WBMP
			imageWBMP($this->img["des"],"$save");
		}
		
		if($watermark!='')
		{	//genero imagen con marca de agua
			$im = imagecreatefrompng($watermark);
			
			imagecopy($this->img["des"], $im, 30, (imagesy($this->img["des"])/2)-(imagesy($im)/2), 0, 0, imagesx($im), imagesy($im)); 

			if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
				//JPEG
				imageJPEG($this->img["des"],"$save",$this->img["quality"]);
			} elseif ($this->img["format"]=="PNG") {
				//PNG
				imagePNG($this->img["des"],"$save");
			} elseif ($this->img["format"]=="GIF") {
				//GIF
				imageGIF($this->img["des"],"$save");
			} elseif ($this->img["format"]=="WBMP") {
				//WBMP
				imageWBMP($this->img["des"],"$save");
			}
	
			imagedestroy($im); 
		}
	}
}
?>