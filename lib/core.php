<?php
		
		//ini_set('display_errors','On');

		//error_reporting(E_ALL | E_STRICT);
		error_reporting(0);

	
		//------------------------------------------------------------------------//
		if(!headers_sent()) session_start();
		//------------------------------------------------------------------------//

		require_once("config.php");
		require_once('../../xt-model/ConnectModel.php');

		$cn = new ConnectModel();
		$db = $cn->Connect();

		//require_once("md5.php");		

		function GUID() {
			return md5(time()*rand(0, 1000));
		}

		$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		
		function prepara_url($cadena)
		{ return(strtolower(str_replace(" ","_",elimina_especiales(elimina_acentos($cadena)))));
			
		}

		function elimina_acentos($cadena){
		$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
		$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
		return(strtr($cadena,$tofind,$replac));
		}

		function elimina_especiales($cadena){
		//$tofind = "¿?!°|#$%&+();:~`'-";
		//$replac = "                  ";
		//return(strtr($cadena,$tofind,$replac));
		$vowels = array("¿", "?", "!", "°", "|", "#", "$", "%", "&", "+", "(", ")", ";", ":", "~", "`", "'", "-");
		$cadena = str_replace($vowels, "", $cadena);
		return($cadena);
		}

		function mascara($valor){
			while(strlen($valor)<5)
				{	$valor = '0'.$valor;	}
			return $valor;
		}

        function dateDiffMinutes($start, $end) {
	        $start_ts = strtotime($start);
	        $end_ts = strtotime($end);
	        $diff = $end_ts - $start_ts;
	        return $diff /60;
        }

        function get_today(){	
			$data = "<div id='day'>".get_current_wday()."&nbsp;<b>".date('d')."</b>,</div>\n<div id='month'>".get_current_month()."</div>\n<div id='year'>".date('Y')."</div>";
			return $data;
		}

	
		function antiinjection($str)
		{
		$banwords = array ("insert", "update", "delete", "create", " or ", " OR ", " and ", " AND ","<script>","</script>");
		$str = str_ireplace ( $banwords, '', ( $str ) );
		$str = trim($str);
		//$str = strip_tags($str);
		//$str = htmlspecialchars($str);
		return $str;
		} 

		function getA($campo)
		{
			return(htmlspecialchars(antiinjection($_REQUEST[$campo]), ENT_QUOTES));
		}

		function getB($campo)
		{
			return(antiinjection($_REQUEST[$campo]));
		}
		
		function urls_amigables($url) {
			// Tranformamos todo a minusculas
			$url = mb_strtolower ($url, 'UTF-8');

			//Rememplazamos caracteres especiales latinos

			$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');

			$repl = array('a', 'e', 'i', 'o', 'u', 'n');

			$url = str_replace ($find, $repl, $url);

			// Añaadimos los guiones

			$find = array(' ', '&', '\r\n', '\n', '+'); 
			$url = str_replace ($find, '-', $url);

			// Eliminamos y Reemplazamos demás caracteres especiales

			$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

			$repl = array('', '-', '');

			$url = preg_replace ($find, $repl, $url);

			return $url;
		}

		function preparaLink($ds_url)
		{
			return(strtolower(elimina_acentos(str_replace(" ","-",elimina_especiales($ds_url)))));
		}
		
		function reparaLinkNB($ds_url)
		{
			return(strtolower(ereg_replace("[^A-Za-z0-9]", "",str_replace("-"," ",$ds_url))));
		}
		
		function reparaLink($ds_url)
		{
			return(strtolower(str_replace("-"," ",$ds_url)));
		}
		
		function reparaLinkMySQL($ds_url)
		{
			return(strtolower(ereg_replace("[^A-Za-z0-9]", "", elimina_especiales(elimina_acentos($ds_url)))));
		}
				

		function getBSF($monto)
		{
			return(number_format($monto, 2, ',', '.'));
		}


		function check($valor)
		{
		if($valor=="on")
			{	return(1); }
		else
			{	return(0); }
		}
		
		function cheq($tipo)
		{	if($tipo)
			{ return ("checked=checked");}
		}

		function nulo($valor)
		{
			if($valor=='')
			{return('Null');}
			return($valor);
		}

		function fe_nulo($valor)
		{
			if($valor=='-- :')
			{return('Null');}
			return($valor);
		}


		function todateguion($date){
			//day is yyyymmdd
			$y =substr($date,6,4);
			$m = substr($date,3,2);
			$d = substr($date,0,2);

			return("$d-$m-$y");

		}

		function todate($date){
			//day is yyyymmdd
			$y =substr($date,6,4);
			$d = substr($date,3,2);
			$m = substr($date,0,2);

			return($y.$m.$d);

		}

function todate_hr($date){
	//day is yyyymmdd
	$fecha = explode(" ",$date);
	$hora = explode(":",$fecha[1]);

	$y =substr($fecha[0],6,4);
	$d = substr($fecha[0],3,2);
	$m = substr($fecha[0],0,2);

	if($fecha[2]=='PM')
	{
		if($hora[0]<12)
			$hora[0] = $hora[0]+12;
	}


	return("$y-$m-$d " . $hora[0].':'.$hora[1]);

}


function tohour_hr($date){
	//day is yyyymmdd
	$fecha = explode(" ",$date);
	$hora = explode(":",$fecha[0]);

	if($fecha[1]=='PM')
	{
		if($hora[0]<12)
			$hora[0] = $hora[0]+12;
	}


	return($hora[0].':'.$hora[1]);

}


function dateesp($date){
			//recibe y-m-d
			$y =substr($date,6,4);
			$m = substr($date,3,2);
			$d = substr($date,0,2);

			return($d."/".$m."/".$y);
		
		} 

		// recibe un array y lo comprime a un campo separado por "|"
		function data_collapse($data, $trim=false){
			$value = ""; 
			if($data && is_array($data)) $value = implode("|", $data);
			if ($trim) {
				$value = trim(str_replace("||", "|", $value));
				$value = $value == "||" ? "" : $value;
			}
			return $value;
		}
		
		// recibe un campo de texto y lo separa en array "|"
		function data_expand($data){
			$new_data = explode("|", $data);
			return $new_data;
		}
		
		function date_to_javascript($date) {
			if ($date) {
				if ($date == "0000-00-00") return "";
				$date = split(" ", $date);
				$time = $date[1];
				$date = $date[0];
				$date = split("-", $date);
				$time = trim($time);
				$time = substr($time, 0, strlen($time)-3);
				$time = $time=="00:00" ? "" : $time;
				$date = $date[2] . "/" . $date[1] . "/" . $date[0] . " " . $time;
			}
			return $date;
		}
		//------------------------------------------------------------------------//
		function date_to_javascript_short($date, $sep="/") {
			if ($date) {
				if ($date == "0000-00-00") return "";
				$date = split(" ", $date);
				$time = $date[1];
				$date = $date[0];
				$date = split("-", $date);
				$date = $date[2] . $sep . $date[1] . $sep . $date[0];
			}
			return $date;
		}		
		
		//------------------------------------------------------------------------------------------//
		function prepare_string($str) {
			$str = str_replace("\\\"", "\"", $str);
			$str = str_replace("\\'", "'", $str);
			$str = str_replace("'", "'+CHAR(39)+'", $str);
			return $str;
		}
		//------------------------------------------------------------------------------------------//
		function L($label) {
			return 	get_label($label);
		}
		//------------------------------------------------------------------------------------------//
		function get_label($label) {
			$label = constant(strtoupper(trim($label)));
			return $label;
		}		
		//------------------------------------------------------------------------------------------//		
		function html_label($str) {
			$str = str_replace("\"", "&quot;", $str);
			return $str;
		}

	function id($db, $desc)
	{
		$cn = new ConnectModel();
		$id = $cn->getId($db, $desc);

		return($id);
	}

	function putBotonAccion($db, $co_acc, $caso, $comentario)
	{
		$cn = new ConnectModel();
		$permiso = $cn->getAcceso($db, $co_acc, 1);

		switch($caso) {
			case 1:
				if ($permiso)
					return('<button type="button" class="btn btn-primary" onClick="javascript:validar(this.form,\'ing\')">Submit</button>');
			break;
			case 2:
				if ($permiso)
					return('<button type="button" class="btn btn-primary" onClick="javascript:validar(this.form,\'ing\')">Update</button>');
			break;
			case 3:
				if ($permiso)
					return('<button type="button" class="btn btn-danger" onClick="javascript:prevalida(\'the record\')?validar(this.form,\'elim\'):\'\'">Delete</button>');
			break;
		}
	}
	
	function putBotonAccionFunction($db, $co_acc, $caso, $comentario, $funcion)
	{
		$cn = new ConnectModel();
		$permiso = $cn->getAcceso($db, $co_acc, 1);
	
		switch($caso) {
			case 1:
				if ($permiso)
					return('<button type="button" class="btn btn-default" onClick="javascript:' . $funcion . '">Aceptar</button>');
			break;
			case 2:
				if ($permiso)
					return('<button type="button" class="btn btn-default" onClick="javascript:' . $funcion . '">Actualizar</button>');
			break;
			case 3:
				if ($permiso)
					return('<button type="button" class="btn btn-default" onClick="javascript:prevalida(\''.$comentario.'\')?' . $funcion . '">Eliminar</button>');
			break;
		}
	}

	
	function registro_new($db, $titulo, $pag, $etiqueta)
	{
		$co_acc = getA("co_acc");

		$cn = new ConnectModel();
		$permiso = $cn->getAcceso($db, $co_acc, 1);

		if($permiso==1)
		{
			echo ("<a href='$pag' class='btn btn-primary pull-right'><i class='glyphicon glyphicon-plus-sign'></i> $etiqueta</a>");
		}
	}
	
	function registro_det($titulo)
	{ echo 	("<br><p align='center' class='tituloAdmin'>$titulo</p><br>");
	}


	function titulo_mod($titulo)
	{	echo ("<br><p align='center' class='tituloAdmin'>$titulo</p><br>");
	}
	
	function ConectarFTP(){
	$id_ftp=ftp_connect(SERVER,PORT); //Obtiene un manejador del Servidor FTP
	ftp_login($id_ftp,USER,PASSWORD); //Se loguea al Servidor FTP
	ftp_pasv($id_ftp,MODO); //Establece el modo de conexi�n
	return $id_ftp; //Devuelve el manejador a la funci�n
	}
	
	function SubirArchivo($archivo_local,$archivo_remoto){
	$id_ftp=ConectarFTP(); //Obtiene un manejador y se conecta al Servidor FTP
	ftp_put($id_ftp,$archivo_remoto,$archivo_local,FTP_BINARY);
	//Sube un archivo al Servidor FTP en modo Binario
	ftp_quit($id_ftp); //Cierra la conexion FTP
	}
	
	function ObtenerRuta(){
	$id_ftp=ConectarFTP(); //Obtiene un manejador y se conecta al Servidor FTP
	$Directorio=ftp_pwd($id_ftp); //Devuelve ruta actual p.e. "/home/willy"
	ftp_quit($id_ftp); //Cierra la conexion FTP
	return $Directorio; //Devuelve la ruta a la funci�n
	}
	
	function CreaArchivo($texto, $archivo)
	{ //echo $archivo;
		$fp = fopen($archivo, "w");
		$write = fputs($fp, $texto);
		fclose($fp);  	
	}
		
	function calcular_edad($fecha)
	{
		$dias = explode("/", $fecha, 3);
		$dias = mktime(0,0,0,$dias[1],$dias[0],$dias[2]);
		$edad = (int)((time()-$dias)/31556926 );
		return $edad;
	}

	function edad($fecha_nac){
		$dia=date("j");
		$mes=date("n");
		$anno=date("Y");

		$anno_nac =substr($fecha_nac,6,4); 
		$mes_nac = substr($fecha_nac,3,2);
		$dia_nac = substr($fecha_nac,0,2); 

		if($mes_nac>$mes){
		$calc_edad= $anno-$anno_nac-1;
		}else{
		if($mes==$mes_nac AND $dia_nac>$dia){
		$calc_edad= $anno-$anno_nac-1;
		}else{
		$calc_edad= $anno-$anno_nac;
		}
		}
		return $calc_edad;
	}

	function GPSDistance($lat1, $lon1, $lat2, $lon2, $unit) {
		/*
		echo Distance($lat1, $lon1, $lat2, $lon2, "K") . " kilometers<br>";
		echo Distance($lat1, $lon1, $lat2, $lon2, "M") . " miles<br>";
		echo Distance($lat1, $lon1, $lat2, $lon2, "N") . " nautical miles<br>";
		 * */
		$radius = 6378.137; // earth mean radius defined by WGS84
		$dlon = $lon1 - $lon2;
		$distance = acos( sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($dlon))) * $radius;

		if ($unit == "K") {
			return ($distance);
		} else if ($unit == "M") {
			return ($distance * 0.621371192);
		} else if ($unit == "N") {
			return ($distance * 0.539956803);
		} else {
			return 0;
		}
	}

	function redimensionar_jpeg($img_original, $img_nueva, $img_nueva_anchura, $img_nueva_altura, $img_nueva_calidad)
	{
	    // crear una imagen desde el original 
		if (exif_imagetype($img_original) == IMAGETYPE_JPEG) {
		    $img = ImageCreateFromJPEG($img_original);
		}	 
		if (exif_imagetype($img_original) == IMAGETYPE_PNG) {
		    $img = ImageCreateFromPNG($img_original);
		}		   
	    
	    // crear una imagen nueva 
	    $thumb = imagecreatetruecolor($img_nueva_anchura,$img_nueva_altura);
	    // redimensiona la imagen original copiandola en la imagen 
	    ImageCopyResized($thumb,$img,0,0,0,0,$img_nueva_anchura,$img_nueva_altura,ImageSX($img),ImageSY($img));
	    // guardar la nueva imagen redimensionada donde indicia $img_nueva 
		if (exif_imagetype($img_original) == IMAGETYPE_JPEG) {
		    ImageJPEG($thumb,$img_nueva,$img_nueva_calidad);
		}	 
		if (exif_imagetype($img_original) == IMAGETYPE_PNG) {
		    ImagePNG($thumb,$img_nueva,$img_nueva_calidad);
		}		    

	    ImageDestroy($img);
	}
?>