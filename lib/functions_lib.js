var nav4 = window.Event ? true : false;
var varDirImg = '../../';

function acceptUser(e)
{ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	(e.keyCode) ? key=e.keyCode : key=e.which;
	return (key <= 13 || (key >= 48 && key <= 57) || (key >= 65 && key <= 79) || (key >= 97 && key <= 122) || key == 137 );
}

function acceptNum(e)
{ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	(e.keyCode) ? key=e.keyCode : key=e.which;
	return (key <= 13 || (key >= 48 && key <= 57) || key == 44 || key == 46 );
}

function acceptJustIntNum(e)
{ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	(e.keyCode) ? key=e.keyCode : key=e.which;
	return (key <= 13 || (key >= 48 && key <= 57));
}

function acceptMoney(e)
{ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	(e.keyCode) ? key=e.keyCode : key=e.which;

	(e.keyCode) ? key=e.keyCode : key=e.which;
	return (key <= 13 || (key >= 48 && key <= 57) || key == 46 )
}

function acceptNoECaracter(e)
{ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	//(e.keyCode) ? key=e.keyCode : key=e.which;
	//return (key <= 13 || (key >= 48 && key <= 57) || (key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key >= 160 && key <= 163) || key == 137 || key == 255 || key == 130);
		(e.keyCode) ? tecla=e.keyCode : tecla=e.which;
    if (tecla==8) return true; // 3
    patron =/[A-Za-z0-9.,ñÑáÁéÉíÍóÓúÚ\s]/
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
}

function acceptJustNumber(e)
{ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	(e.keyCode) ? key=e.keyCode : key=e.which;
	return (key <= 13 || (key >= 48 && key <= 57));
}

function acceptJustNum(e,campo)
{ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	(e.keyCode) ? key=e.keyCode : key=e.which;

	if (key <= 13 || (key >= 48 && key <= 57))
	{return(key)}
	else
	{$(campo).update(' * Solo Numeros').show().fade({ duration: 3.0 });return(false)}
}

function acceptJustMoney(e,campo)
{ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	(e.keyCode) ? key=e.keyCode : key=e.which;

	if (key <= 13 || (key >= 48 && key <= 57) || key == 44 || key == 46 )
	{return(key)}
	else
	{$(campo).update(' * Solo Numeros').show().fade({ duration: 3.0 });return(false)}
}

function JQacceptJustNum(e,campo)
{ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	(e.keyCode) ? key=e.keyCode : key=e.which;

	if (key <= 13 || (key >= 48 && key <= 57))
	{return(key)}
	else
	{$(campo).html(' * Solo Numeros').fadeIn().fadeOut(2000);	return(false);}
}

function JQacceptJustMoney(e,campo)
{ 
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 
	(e.keyCode) ? key=e.keyCode : key=e.which;

	if (key <= 13 || (key >= 48 && key <= 57) || key == 44 || key == 46 )
	{return(key)}
	else
	{$(campo).html(' * Solo Numeros').fadeIn().fadeOut(2000);	return(false);}
}


function agrega_item(forma, lista1, lista2, conlista )
{
//*************************************************
//permite agregar un item de una lista,combo a otro
//le paso la forma(forma), y el nombre
//de la lista(lista1), y el da la lista que recibe(lista2)
//*************************************************
	var sep=''
	var sep2=''	
	var list=''	
	var list2=''
	var list3=''	
	var i=0

	indice = forma [lista2].length ;
	texto = forma [lista1].value;
	for(i=0;forma [lista1].length - 1;i++)
	{
		if(!Empty(forma [lista1]))
		{
			texto1 = forma [lista1][forma [lista1].selectedIndex].text;	
			forma [lista2].options[indice]=new Option(texto1,texto);
	
			//Busco eliminar la opcion seleccionada
			for (i=0; i < forma [lista1].length; i++) {
				if (forma [lista1].selectedIndex != i){
					list += sep + forma [lista1][i].text
					list2 += sep + forma [lista1][i].value
					sep='|'
					}
			}
	
			for (i=0; i < forma [lista2].length; i++) {
					list3 += sep2 + forma [lista2][i].value
					sep2='|'
					}
			
			forma [conlista].value = list3
			listArray = list.split("|")
			listArray2 = list2.split("|")	
			forma [lista1].length = 0
		
			//Agrego a la lista resultante
			for (i=0; i < listArray.length; i++) {
				if(listArray2[i]!='')
					forma [lista1].options[i]=new Option(listArray[i],listArray2[i]);
			}
		}
	}
}

function elimina_item(forma,lista1,lista2,conlista)
{
//*************************************************
//permite eliminar un item de una lista y pasarlo
//a la otra, le paso la forma(forma), y el nombre
//de la lista que elimina(lista2), y el da la lista 
//que recibe(lista1)
//*************************************************
	var sep=''
	var sep2=''
	var list=''	
	var list2=''
	var list3=''
	var list4=''
	var list5=''	

	indice = forma [lista1].length - 1;
	
	for (i=0; i < forma [lista2].length; i++) {
		if (forma [lista2].selectedIndex != i){
			list += sep + forma [lista2][i].text
			list2 += sep + forma [lista2][i].value			
			sep='|'
			}
		else
			{
			list3 += sep2 + forma [lista2][i].text
			list4 += sep2 + forma [lista2][i].value
			sep2='|'
			}
	}
	
	listArray = list.split("|")
	listArray2 = list2.split("|")	
	forma [lista2].length = 0
	
	listArray3 = list3.split("|")
	listArray4 = list4.split("|")
	
	//Agrego a la lista resultante
	for (i=0; i < listArray.length; i++) {
		if(listArray[i]!='')
			forma [lista2].options[i]=new Option(listArray[i],listArray2[i]);
	}
	//Agrego a la lista principal
	for (i=0; i < listArray3.length; i++) {
		if(listArray3[i]!='')
			forma [lista1].options[indice+1]=new Option(listArray3[i],listArray4[i]);
	}
	
	sep2=''
	for (i=0; i < forma [lista2].length; i++) {
			list5 += sep2 + forma [lista2][i].value
			sep2='|'
			}
	forma [conlista].value = list5
	
}


function add_todos(forma, lista1, lista2, conlista )
{
//*************************************************
//permite agregar todos los items de una lista,combo a otro
//le paso la forma(forma), y el nombre
//de la lista(lista1), y el da la lista que recibe(lista2)
//*************************************************
	var sep=''
	var sep2=''	
	var list=''	
	var list2=''
	var list3=''
	var existe=0			

	indice = forma [lista2].length ;

	if(!Empty(forma [lista1]))
	{	
		if(forma [lista2].length==0){
			for (i=0; i < forma [lista1].length; i++) 
				{
				texto = forma [lista1][i].value;
				texto1 = forma [lista1][i].text;	
				forma [lista2].options[indice]=new Option(texto1,texto);
				indice++;
				}
			}
		else
			{
			for (i=0; i < forma [lista2].length; i++) {
				for (j=0; j < forma [lista1].length; j++) 
					{
					texto = forma [lista1][j].value;
					texto1 = forma [lista1][j].text;
					if (forma [lista2][i].value == texto){
						alert('El material que intenta asignar ya ha sido asignado')
						existe=1
						}
					if(existe==0)
						{	
						forma [lista2].options[indice]=new Option(texto1,texto);
						}
					indice++;
					}
			}

		}


		//Busco eliminar todas las opciones 
		for (i=0; i < forma [lista1].length; i++) {
			if (forma [lista1].selectedIndex != i){
				list += sep + forma [lista1][i].text
				list2 += sep + forma [lista1][i].value
				sep='|'
				}
		}

		for (i=0; i < forma [lista2].length; i++) {
				list3 += sep2 + forma [lista2][i].value
				sep2='|'
				}
		
		forma [conlista].value = list3
		listArray = list.split("|")
		listArray2 = list2.split("|")	
		forma [lista1].length = 0
	
		//Agrego a la lista resultante
		for (i=0; i < listArray.length; i++) {
			if(listArray2[i]!='')
				forma [lista1].options[i]=new Option(listArray[i],listArray2[i]);
		}

	}
}


function add_item(forma, lista1, lista2, conlista )
{
//*************************************************
//permite agregar un item de una lista,combo a otro
//le paso la forma(forma), y el nombre
//de la lista(lista1), y el da la lista que recibe(lista2)
//*************************************************
	var sep=''
	var sep2=''	
	var list=''	
	var list2=''
	var list3=''
	var existe=0			

	indice = forma [lista2].length ;
	texto = forma [lista1].value;
	if(!Empty(forma [lista1]))
	{	
		if(forma [lista2].length==0){
			texto1 = forma [lista1][forma [lista1].selectedIndex].text;	
			forma [lista2].options[indice]=new Option(texto1,texto);
			}
		else
			{
			for (i=0; i < forma [lista2].length; i++) {
				if (forma [lista2][i].value == texto){
					alert('El Item que intenta asignar ya ha sido asignado')
					existe=1
				}
			}

			if(existe==0)
			{
				texto1 = forma [lista1][forma [lista1].selectedIndex].text;	
				forma [lista2].options[indice]=new Option(texto1,texto);
			}
		}


		//Busco eliminar la opcion seleccionada
		for (i=0; i < forma [lista1].length; i++) {
			if (forma [lista1].selectedIndex != i){
				list += sep + forma [lista1][i].text
				list2 += sep + forma [lista1][i].value
				sep='|'
				}
		}

		for (i=0; i < forma [lista2].length; i++) {
				list3 += sep2 + forma [lista2][i].value
				sep2='|'
				}
		
		forma [conlista].value = list3
		listArray = list.split("|")
		listArray2 = list2.split("|")	
		forma [lista1].length = 0
	
		//Agrego a la lista resultante
		for (i=0; i < listArray.length; i++) {
			if(listArray2[i]!='')
				forma [lista1].options[i]=new Option(listArray[i],listArray2[i]);
		}
	}
}

function del_item(forma,lista1,lista2,conlista)
{
//*************************************************
//permite eliminar un item de una lista y pasarlo
//a la otra, le paso la forma(forma), y el nombre
//de la lista que elimina(lista2), y el da la lista 
//que recibe(lista1)
//*************************************************
	var sep=''
	var sep2=''
	var list=''	
	var list2=''
	var list3=''
	var list4=''
	var list5=''
	var existente=0
	var valores=''	

	indice = forma [lista1].length - 1;
	
	for (i=0; i < forma [lista2].length; i++) {
		if (forma [lista2].selectedIndex != i){
			list += sep + forma [lista2][i].text
			list2 += sep + forma [lista2][i].value			
			sep='|'
			}
		else
			{
			list3 += sep2 + forma [lista2][i].text
			list4 += sep2 + forma [lista2][i].value
			sep2='|'
			}
	}
	
	listArray = list.split("|")
	listArray2 = list2.split("|")	
	forma [lista2].length = 0
	
	listArray3 = list3.split("|")
	listArray4 = list4.split("|")
	//forma [lista1].length = 0
	
	
	//Agrego a la lista resultante
	for (i=0; i < listArray.length; i++) {
		if(listArray[i]!='')
			forma [lista2].options[i]=new Option(listArray[i],listArray2[i]);
	}

	for (i=0; i < listArray3.length; i++) {
		existente=0;
		for (j=0; j < forma [lista1].length; j++) 
		{
			valores = forma [lista1][j].text;
			if(valores == listArray3[i])
				{existente = 1; }
		}

		if((listArray3[i]!='') && (existente=='0'))
			forma [lista1].options[forma [lista1].length]=new Option(listArray3[i],listArray4[i]);
	}
	
	sep2=''
	for (i=0; i < forma [lista2].length; i++) {
			list5 += sep2 + forma [lista2][i].value
			sep2='|'
			}
	forma [conlista].value = list5
	
}


function prevalida(tipo)
//*************************************
//pregunta al usuario si desea eliminar
//*************************************
{
	if (confirm('Do you want to continue?'))
		{
		return(true)
		}
	else
		{return(false)}
}


function redir(locacion)
{
//*************************************************
//
//	redire despues de 5 segundos
//
//*************************************************

setTimeout("top.location.href ="+locacion,5000);
}



function cent(amount) 
{
//*************************************************
//
//funcion que permite dar como salida los decimales
//en el caso de 50 centimos muestra 0.50
//
//*************************************************

    amount -= 0;
    return (amount == Math.floor(amount)) ? amount + '.00' : (  (amount*10 == Math.floor(amount*10)) ? amount + '0' : amount);
}



function convstring(entero)
{
//*************************************************
//
//convierte un entero en un string//
//*************************************************

	entero = entero + '';
	return(entero);
}



function outputComma(number) 
{
//*************************************************
//
//Permite dar el formato de comas a un numero
//1125 --- 1,125
//
//*************************************************

    number = '' + number
    if (number.length > 3) {
        var mod = number.length%3;
        var output = (mod > 0 ? (number.substring(0,mod)) : '');
        for (i=0 ; i < Math.floor(number.length/3) ; i++) {
            if ((mod ==0) && (i ==0))
                output+= number.substring(mod+3*i,mod+3*i+3);
            else
                output+= ',' + number.substring(mod+3*i,mod+3*i+3);
        }
        return (output);
    }
    else return number;
}




function Empty(field) 
{
//*************************************************
//
//Verifica si un campo est&aacute; vac&iacute;o
//
//*************************************************
	var ecampo;
		ecadena=field.value;
		ecampo= 0;
		if (ecadena.length == 0) 
			return true;
		else
		{
			for (j=0; j<ecadena.length-1; j++) 
			{
			ecampo = ecadena.charAt(j);
			if (ecampo != '')
				{ 
				return false;
				 }
			}
		}
}


function EnviaForma(forma, estado) 
{
//***********************************************
//
//Realiza el submit de la forma. 
//Como par&aacute;metro se le pasa la forma y la acci&oacute;n.
//
//***********************************************

	var valor;
	valor = forma.action.indexOf('?');
	if (valor >= 0)
		{
		$( ".load" ).trigger( "click" );
		forma.action=forma.action + '&acc=' + estado;
		forma.submit();
		}
	else
		{
		$( ".load" ).trigger( "click" );
		forma.action=forma.action + '?acc=' + estado;
		forma.submit();
		}
}

function validar_return(forma)
{
//*************************************************
//permite validar que no esten vac&iacute;os los campos
//como par&aacute;metro se pasan la forma y el estado
//si es 'ing' entoces valida para ingresar o modificar
//si no valida para eliminar
//*************************************************
var cadena, nombre, longitud, num, genera, valor,campo;
num=0;
for (i=0;i<=forma.length-1;i++)
	{
	cadena = forma.elements[i].name.substring(0,2);			
	if (cadena=='r_')
	{
		switch(forma.elements[i].type)
		{
		case 'text':
				if(Empty(forma.elements[i]))
					{
					longitud = forma.elements[i].name.length;
					nombre = 'img_' + forma.elements[i].name.substring(2,longitud);
					genera = new Image(10,10);forma [nombre].src=varDirImg + img_ch;
					num++;
					}
				else
					{
					longitud = forma.elements[i].name.length;
					nombre = 'img_' + forma.elements[i].name.substring(2,longitud);
					genera = new Image(10,10);forma [nombre].src=varDirImg + img_e;
					}
		break;
		case 'file':
				if(Empty(forma.elements[i]))
					{
					longitud = forma.elements[i].name.length;
					nombre = 'img_' + forma.elements[i].name.substring(2,longitud);
					genera = new Image(10,10);forma [nombre].src=varDirImg + img_ch;
					num++;
					}
				else
					{
					longitud = forma.elements[i].name.length;
					nombre = 'img_' + forma.elements[i].name.substring(2,longitud);
					genera = new Image(10,10);forma [nombre].src=varDirImg + img_e;
					}
		break;
		case 'password':
				if(Empty(forma.elements[i]))
					{
					longitud = forma.elements[i].name.length;
					nombre = 'img_' + forma.elements[i].name.substring(2,longitud);
					genera = new Image(10,10);forma [nombre].src=varDirImg + img_ch;
					num++;
					}
				else
					{
					longitud = forma.elements[i].name.length;
					nombre = 'img_' + forma.elements[i].name.substring(2,longitud);
					genera = new Image(10,10);forma [nombre].src=varDirImg + img_e;
					}
		break;
		case 'textarea':
				if(Empty(forma.elements[i]))
					{
					longitud = forma.elements[i].name.length;
					nombre = 'img_' + forma.elements[i].name.substring(2,longitud);
					genera = new Image(10,10);forma [nombre].src=varDirImg + img_ch;
					num++;
					}
				else
					{
					longitud = forma.elements[i].name.length;
					nombre = 'img_' + forma.elements[i].name.substring(2,longitud);
					genera = new Image(10,10);forma [nombre].src=varDirImg + img_e;
					}
		break;
		case 'select-one':
				if(forma.elements[i].selectedIndex==0)
					{
					longitud = forma.elements[i].name.length;
					nombre = 'img_' + forma.elements[i].name.substring(2,longitud);
					genera = new Image(10,10);forma [nombre].src=varDirImg + img_ch;
					num++;
					}
				else
					{
					longitud = forma.elements[i].name.length;
					nombre = 'img_' + forma.elements[i].name.substring(2,longitud);
					genera = new Image(10,10);forma [nombre].src=varDirImg + img_e;
					}
		break;			
		}
	}
}
if (num > 0)
	{
	alert ('Los campos marcados no pueden estar vacíos.');
	return(false)
	}
else
	{
		return(true)
	}
} 


function validar(forma, estado, mensaje)
{
//*************************************************
//permite validar que no esten vac&iacute;os los campos
//*************************************************

var cadena, nombre, longitud, num, genera, valor,campo;

if (estado=='ing')
{
	num=0;
	for (i=0;i<=forma.length-1;i++)
		{
		if(forma.elements[i].name)
		{
			cadena = forma.elements[i].name.substring(0,2);			
			
			if (cadena=='r_')
			{
				switch(forma.elements[i].type)
				{
				case 'password':
				case 'textarea':
				case 'file':
				case 'text':
						if(Empty(forma.elements[i]))
							{
							$("#"+forma.elements[i].name).parent().addClass( " has-error" );
							num++;
							}
						else
							{
							$("#"+forma.elements[i].name).parent().removeClass( "has-error" );
							}
				break;
				case 'select-one':
						if(forma.elements[i].selectedIndex==0)
							{
							$("#"+forma.elements[i].name).parent().addClass( " has-error" );
							num++;
							}
						else
							{
							$("#"+forma.elements[i].name).parent().removeClass( "has-error" );
							}
				break;			
				}
			}
		}
	}
	if (num > 0)
	{
		var options = $.parseJSON('{"text":"<p>Please fill required fields</p>","layout":"bottom","type":"error","closeButton":"true"}');
		noty(options);
	}
	else
		{
		switch(mensaje)
			{
			case 1:
				msj = 'Do you want to continue?';
				break;
			case 2:
				msj = 'Do you want to continue?';
				break;
			}

		if (mensaje > 0)
			{
			if (confirm(msj))
				{
				EnviaForma(forma, estado);
				}
			else
				{
				return(false);
				}
			}
		else
			{
			EnviaForma(forma, estado);
			}
		}
}
else
	{
	EnviaForma(forma, estado);
	}
	
} 




function validaemail2(forma,cadena)
{
//*************************************************
//permite validar el email
//le paso el nombre de la forma(forma), y el nombre
//del textbox(cadena)
//*************************************************

	var ecadena;
		ecadena=document.getElementById(cadena).value;
		$("#"+cadena).parent().removeClass( "has-error" );
		if (ecadena!='')
		{
			if ((ecadena.indexOf("@")== -1) || (ecadena.indexOf(".") == -1))
			{	
				//alert("Introduzca un email válido");
				//document.getElementById(cadena).value='';

				$("#"+cadena).parent().addClass( "has-error" );
				document.getElementById(cadena).focus();
				return(false);
			}
			else if (ecadena.indexOf("\\") == -1){
				return (true); 
			}
			else if (ecadena.indexOf("/") == -1){
				return (true); 
			}
			else if (ecadena.indexOf("'") == -1){
				return (true); 
			}
			else if (ecadena.indexOf("!") == -1){
				return (true); 
			}
			else if (ecadena.indexOf("?") == -1){
				return (true); 
			}
			else if ((ecadena.indexOf("à") == -1) || (ecadena.indexOf("&aacute;") == -1) || (ecadena.indexOf("ä") == -1) || (ecadena.indexOf("è") == -1) || (ecadena.indexOf("&eacute;") == -1) || (ecadena.indexOf("ë") == -1) || (ecadena.indexOf("ì") == -1) || (ecadena.indexOf("&iacute;") == -1) || (ecadena.indexOf("ï") == -1) || (ecadena.indexOf("&ntilde;") == -1) || (ecadena.indexOf("ò") == -1) || (ecadena.indexOf("&oacute;") == -1) || (ecadena.indexOf("ö") == -1) || (ecadena.indexOf("ù") == -1) || (ecadena.indexOf("&uacute;") == -1) || (ecadena.indexOf("ü") == -1) || (ecadena.indexOf("ý") == -1) || (ecadena.indexOf("ÿ") == -1) ){
				return (true); 
			}
			else
			{	//alert("Introduzca un email v\u00E1lido");
				//document.getElementById(cadena).value='';
				$("#"+cadena).parent().addClass( "has-error" );
				document.getElementById(cadena).focus();
				return(false);
			}
		}
		else
		{
			$("#"+cadena).parent().removeClass( "has-error" );
			return true;

		}
}




//------------------------------------------------------------------

//Objeto oNumero
function oNumero(numero)
{
	//Propiedades
	this.valor = numero || 0
	this.dec = -1;
	//Métodos
	this.formato = numFormat;
	this.ponValor = ponValor;
	//Definición de los métodos
	function ponValor(cad)
	{
		if (cad =='-' || cad=='+') return
		if (cad.length ==0) return
		if (cad.indexOf('.') >=0)
				this.valor = parseFloat(cad);
		else
				this.valor = parseInt(cad);
	}
	
	function numFormat(dec, miles)
	{
		var num = this.valor, signo=3, expr;
		var cad = ""+this.valor;
		var ceros = "", pos, pdec, i;
		for (i=0; i < dec; i++)
		ceros += '0';
		
		pos = cad.indexOf('.')
	
		if (pos < 0)
				cad = cad+","+ceros;
		else
		{
			pdec = cad.length - pos -1;
			if (pdec <= dec)
			{
					for (i=0; i< (dec-pdec); i++)
							cad += '0';
			}
			else
			{
					num = num*Math.pow(10, dec);
					num = Math.round(num);
					num = num/Math.pow(10, dec);
					cad = new String(num);
			}
		}
		
		cad=cad.replace('.','|')	
		pos = cad.indexOf('|')
	
		if (pos < 0) pos = cad.lentgh
	
		if (cad.substr(0,1)=='-' || cad.substr(0,1) == '+')
					 signo = 4;
	
		if (miles && pos > signo)
				do{
						expr = /([+-]?\d)(\d{3}[\|\,]\d*)/
						cad.match(expr)
						cad=cad.replace(expr, RegExp.$1+'.'+RegExp.$2)
						}
	
		while (cad.indexOf(',') > signo)
				if (dec<0) cad = cad.replace(/\./,'')
		
		return cad.replace('|',',');
	}
}

function getDecimal(valor)
{
	var numero = new oNumero(valor);
	return(numero.formato(2, true));
}
