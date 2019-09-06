var nav4=window.Event?true:false;var varDirImg='/';function moveMenu(objeto,ds_url,img_central,tipo)
{if(tipo==1)
{$(objeto).animate({top:"-=18px"},250);$("#myAImage").attr("href",ds_url);$("#myImage").ImageSwitch({NewImage:"/images/menu/"+img_central});}
else
{$(objeto).animate({top:"+=18px"},250);}}
function limpiarFocus(campo,mensaje)
{if($(campo).val()==mensaje)
{$(campo).val('')}}
function acceptUser(e)
{(e.keyCode)?key=e.keyCode:key=e.which;return(key<=13||(key>=48&&key<=57)||(key>=65&&key<=79)||(key>=97&&key<=122)||key==137);}
function acceptNum(e)
{(e.keyCode)?key=e.keyCode:key=e.which;return(key<=13||(key>=48&&key<=57)||key==44||key==46);}
function acceptJustIntNum(e)
{(e.keyCode)?key=e.keyCode:key=e.which;return(key<=13||(key>=48&&key<=57));}
function acceptMoney(e)
{(e.keyCode)?key=e.keyCode:key=e.which;(e.keyCode)?key=e.keyCode:key=e.which;return(key<=13||(key>=48&&key<=57)||key==46)}
function acceptNoECaracter(e)
{(e.keyCode)?tecla=e.keyCode:tecla=e.which;if(tecla==8)return true;patron=/[A-Za-z0-9.,ñÑáÁéÉíÍóÓúÚ\s]/
te=String.fromCharCode(tecla);return patron.test(te);}
function acceptJustNumber(e)
{(e.keyCode)?key=e.keyCode:key=e.which;return(key<=13||(key>=48&&key<=57));}
function acceptJustNum(e,campo)
{(e.keyCode)?key=e.keyCode:key=e.which;if(key<=13||(key>=48&&key<=57))
{return(key)}
else
{$(campo).update(' * Solo Numeros').show().fade({duration:3.0});return(false)}}
function acceptJustMoney(e,campo)
{(e.keyCode)?key=e.keyCode:key=e.which;if(key<=13||(key>=48&&key<=57)||key==44||key==46)
{return(key)}
else
{$(campo).update(' * Solo Numeros').show().fade({duration:3.0});return(false)}}
function JQacceptJustNum(e,campo)
{(e.keyCode)?key=e.keyCode:key=e.which;if(key<=13||(key>=48&&key<=57))
{return(key)}
else
{$(campo).html(' * Solo Numeros').fadeIn().fadeOut(2000);return(false);}}
function JQacceptJustMoney(e,campo)
{(e.keyCode)?key=e.keyCode:key=e.which;if(key<=13||(key>=48&&key<=57)||key==44||key==46)
{return(key)}
else
{$(campo).html(' * Solo Numeros').fadeIn().fadeOut(2000);return(false);}}
function show_calendar()
{p_item=arguments[0];if(arguments[1]==null)
p_month=new String(gNow.getMonth());else
p_month=arguments[1];if(arguments[2]==""||arguments[2]==null)
p_year=new String(gNow.getFullYear().toString());else
p_year=arguments[2];if(arguments[3]==null)
p_format="DD/MM/YYYY";else
p_format=arguments[3];vWinCal=window.open("","Calendar","width=250,height=250,status=no,resizable=no,top=200,left=200");vWinCal.opener=self;ggWinCal=vWinCal;Build(p_item,p_month,p_year,p_format);}
function comparafecha(forma,dia,mes,ano,dia2,mes2,ano2)
{var valorfec1,valorfec2,auxano,i,auxmes,auxdia,auxano,auxmeses,auxano,j,auxmes2,auxdia2,auxano2;auxmes=document[forma][mes].value;auxdia=document[forma][dia].value;auxano=document[forma][ano].value;auxmes2=document[forma][mes2].value;auxdia2=document[forma][dia2].value;auxano2=document[forma][ano2].value;i=document[forma][mes].selectedIndex;j=document[forma][mes2].selectedIndex;auxmeses=new Array(12);auxmeses[1]=31;auxmeses[2]=28;auxmeses[3]=31;auxmeses[4]=30;auxmeses[5]=31;auxmeses[6]=30;auxmeses[7]=31;auxmeses[8]=31;auxmeses[9]=30;auxmeses[10]=31;auxmeses[11]=30;auxmeses[12]=31;mensaje="Por favor introduzca una fecha válida";if(auxano>=2000)
{while(auxano>2000)
{auxano=auxano-4;}
if(auxano==2000)
{auxmeses[2]=29;if(auxdia>auxmeses[i])
{alert(mensaje);return(false);}}
else
{auxmeses[2]=28;if(auxdia>auxmeses[i])
{alert(mensaje);return(false);}}}
if(auxano2>=2000)
{while(auxano2>2000)
{auxano2=auxano2-4;}
if(auxano2==2000)
{auxmeses[2]=29;if(auxdia2>auxmeses[j])
{alert(mensaje);return(false);}}
else
{auxmeses[2]=28;if(auxdia2>auxmeses[j])
{alert(mensaje);return(false);}}}
if(auxano<2000)
{while(auxano<2000)
{auxano=auxano+4;}
if(auxano==2000)
{auxmeses[2]=29;if(auxdia>auxmeses[i])
{alert(mensaje);return(false);}}
else
{auxmeses[2]=28;if(auxdia>auxmeses[i])
{alert(mensaje);return(false);}}}
if(auxano2<2000)
{while(auxano2<2000)
{auxano2=auxano2+4;}
if(auxano2==2000)
{auxmeses[2]=29;if(auxdia2>auxmeses[j])
{alert(mensaje);return(false);}}
else
{auxmeses[2]=28;if(auxdia2>auxmeses[j])
{alert(mensaje);return(false);}}}
valorfec1=parseInt(auxano+auxmes+auxdia,10);valorfec2=parseInt(auxano2+auxmes2+auxdia2,10);if(valorfec1<valorfec2)
return(true);else
alert('Fecha Desde no puede ser mayor o igual a la fecha Hasta ');return(false);}
function agrega_item(forma,lista1,lista2,conlista)
{var sep=''
var sep2=''
var list=''
var list2=''
var list3=''
var i=0
indice=forma[lista2].length;texto=forma[lista1].value;for(i=0;forma[lista1].length-1;i++)
{if(!Empty(forma[lista1]))
{texto1=forma[lista1][forma[lista1].selectedIndex].text;forma[lista2].options[indice]=new Option(texto1,texto);for(i=0;i<forma[lista1].length;i++){if(forma[lista1].selectedIndex!=i){list+=sep+forma[lista1][i].text
list2+=sep+forma[lista1][i].value
sep='|'}}
for(i=0;i<forma[lista2].length;i++){list3+=sep2+forma[lista2][i].value
sep2='|'}
forma[conlista].value=list3
listArray=list.split("|")
listArray2=list2.split("|")
forma[lista1].length=0
for(i=0;i<listArray.length;i++){if(listArray2[i]!='')
forma[lista1].options[i]=new Option(listArray[i],listArray2[i]);}}}}
function elimina_item(forma,lista1,lista2,conlista)
{var sep=''
var sep2=''
var list=''
var list2=''
var list3=''
var list4=''
var list5=''
indice=forma[lista1].length-1;for(i=0;i<forma[lista2].length;i++){if(forma[lista2].selectedIndex!=i){list+=sep+forma[lista2][i].text
list2+=sep+forma[lista2][i].value
sep='|'}
else
{list3+=sep2+forma[lista2][i].text
list4+=sep2+forma[lista2][i].value
sep2='|'}}
listArray=list.split("|")
listArray2=list2.split("|")
forma[lista2].length=0
listArray3=list3.split("|")
listArray4=list4.split("|")
for(i=0;i<listArray.length;i++){if(listArray[i]!='')
forma[lista2].options[i]=new Option(listArray[i],listArray2[i]);}
for(i=0;i<listArray3.length;i++){if(listArray3[i]!='')
forma[lista1].options[indice+1]=new Option(listArray3[i],listArray4[i]);}
sep2=''
for(i=0;i<forma[lista2].length;i++){list5+=sep2+forma[lista2][i].value
sep2='|'}
forma[conlista].value=list5}
function add_item1(forma,lista1,lista2,conlista)
{var sep=''
var sep2=''
var list=''
var list2=''
var list3=''
var existe=0
indice=forma[lista2].length;texto=forma[lista1].value;if(!Empty(forma[lista1]))
{valor=texto.indexOf(',');cadena=texto.substring(valor+1,texto.length);while(valor>=0)
{if(forma[lista2].length==0){texto1=forma[lista1][forma[lista1].selectedIndex].text;forma[lista2].options[indice]=new Option(texto1,texto);}
else
{for(i=0;i<forma[lista2].length;i++){if(forma[lista2][i].value==texto){alert('El material que intenta asignar ya ha sido asignado')
existe=1}}
if(existe==0)
{texto1=forma[lista1][forma[lista1].selectedIndex].text;forma[lista2].options[indice]=new Option(texto1,texto);}}
for(i=0;i<forma[lista1].length;i++){if(forma[lista1].selectedIndex!=i){list+=sep+forma[lista1][i].text
list2+=sep+forma[lista1][i].value
sep='|'}}
for(i=0;i<forma[lista2].length;i++){list3+=sep2+forma[lista2][i].value
sep2='|'}
forma[conlista].value=list3
listArray=list.split("|")
listArray2=list2.split("|")
forma[lista1].length=0
for(i=0;i<listArray.length;i++){if(listArray2[i]!='')
forma[lista1].options[i]=new Option(listArray[i],listArray2[i]);}
valor=cadena.indexOf(',');cadena=texto.substring(valor+1,texto.length);}}}
function add_todos(forma,lista1,lista2,conlista)
{var sep=''
var sep2=''
var list=''
var list2=''
var list3=''
var existe=0
indice=forma[lista2].length;if(!Empty(forma[lista1]))
{if(forma[lista2].length==0){for(i=0;i<forma[lista1].length;i++)
{texto=forma[lista1][i].value;texto1=forma[lista1][i].text;forma[lista2].options[indice]=new Option(texto1,texto);indice++;}}
else
{for(i=0;i<forma[lista2].length;i++){for(j=0;j<forma[lista1].length;j++)
{texto=forma[lista1][j].value;texto1=forma[lista1][j].text;if(forma[lista2][i].value==texto){alert('El material que intenta asignar ya ha sido asignado')
existe=1}
if(existe==0)
{forma[lista2].options[indice]=new Option(texto1,texto);}
indice++;}}}
for(i=0;i<forma[lista1].length;i++){if(forma[lista1].selectedIndex!=i){list+=sep+forma[lista1][i].text
list2+=sep+forma[lista1][i].value
sep='|'}}
for(i=0;i<forma[lista2].length;i++){list3+=sep2+forma[lista2][i].value
sep2='|'}
forma[conlista].value=list3
listArray=list.split("|")
listArray2=list2.split("|")
forma[lista1].length=0
for(i=0;i<listArray.length;i++){if(listArray2[i]!='')
forma[lista1].options[i]=new Option(listArray[i],listArray2[i]);}}}
function add_item(forma,lista1,lista2,conlista)
{var sep=''
var sep2=''
var list=''
var list2=''
var list3=''
var existe=0
indice=forma[lista2].length;texto=forma[lista1].value;if(!Empty(forma[lista1]))
{if(forma[lista2].length==0){texto1=forma[lista1][forma[lista1].selectedIndex].text;forma[lista2].options[indice]=new Option(texto1,texto);}
else
{for(i=0;i<forma[lista2].length;i++){if(forma[lista2][i].value==texto){alert('El Item que intenta asignar ya ha sido asignado')
existe=1}}
if(existe==0)
{texto1=forma[lista1][forma[lista1].selectedIndex].text;forma[lista2].options[indice]=new Option(texto1,texto);}}
for(i=0;i<forma[lista1].length;i++){if(forma[lista1].selectedIndex!=i){list+=sep+forma[lista1][i].text
list2+=sep+forma[lista1][i].value
sep='|'}}
for(i=0;i<forma[lista2].length;i++){list3+=sep2+forma[lista2][i].value
sep2='|'}
forma[conlista].value=list3
listArray=list.split("|")
listArray2=list2.split("|")
forma[lista1].length=0
for(i=0;i<listArray.length;i++){if(listArray2[i]!='')
forma[lista1].options[i]=new Option(listArray[i],listArray2[i]);}}}
function add_autorizado(forma,campo1,campo2,lista2,conlista)
{var sep=''
var sep2=''
var list=''
var list2=''
var list3=''
var existe=0
indice=forma[lista2].length;if(campo2!='')
{texto=forma[campo1].value;texto=texto+' - '+forma[campo2].value;}
else
{texto=forma[campo1].value;campo2=campo1;}
if(!Empty(forma[campo1])&&!Empty(forma[campo2]))
{if(forma[lista2].length==0){forma[lista2].options[indice]=new Option(texto,forma[lista2].length+1);}
else
{for(i=0;i<forma[lista2].length;i++){if(forma[lista2][i].text==texto){alert('El Personal que intenta asignar ya ha sido asignado')
existe=1}}
if(existe==0)
{forma[lista2].options[indice]=new Option(texto,forma[lista2].length+1);}}}
for(i=0;i<forma[lista2].length;i++){list3+=sep2+forma[lista2][i].text
sep2='|'}
forma[conlista].value=list3
forma[campo1].value=''
forma[campo2].value=''}
function del_autorizado(forma,lista2,conlista)
{var sep=''
var sep2=''
var list=''
var list2=''
var list3=''
var list4=''
var list5=''
for(i=0;i<forma[lista2].length;i++){if(forma[lista2].selectedIndex!=i){list+=sep+forma[lista2][i].text
list2+=sep+forma[lista2][i].value
sep='|'}}
listArray=list.split("|")
listArray2=list2.split("|")
forma[lista2].length=0
for(i=0;i<listArray.length;i++){if(listArray[i]!='')
forma[lista2].options[i]=new Option(listArray[i],listArray2[i]);}
sep2=''
for(i=0;i<forma[lista2].length;i++){list5+=sep2+forma[lista2][i].text
sep2='|'}
forma[conlista].value=list5
alert(list5)}
function del_item1(forma,lista1,lista2,conlista)
{var sep=''
var sep2=''
var list=''
var list2=''
var list3=''
var list4=''
var list5=''
indice=forma[lista1].length-1;texto=forma[lista2].value;valor=texto.indexOf(',');cadena=texto.substring(0,valor-1);cadena2=texto.substring(valor+1,texto.length);while(valor>=0)
{for(i=0;i<forma[lista2].length;i++){if(forma[lista2].value!=cadena){list+=sep+forma[lista2][i].text
list2+=sep+forma[lista2][i].value
sep='|'}
else
{list3+=sep2+forma[lista2][i].text
list4+=sep2+forma[lista2][i].value
sep2='|'}}
listArray=list.split("|")
listArray2=list2.split("|")
forma[lista2].length=0
listArray3=list3.split("|")
listArray4=list4.split("|")
for(i=0;i<listArray.length;i++){if(listArray[i]!='')
forma[lista2].options[i]=new Option(listArray[i],listArray2[i]);}
sep2=''
for(i=0;i<forma[lista2].length;i++){list5+=sep2+forma[lista2][i].value
sep2='|'}
forma[conlista].value=list5
valor=cadena2.indexOf(',');cadena2=texto.substring(valor+1,texto.length);}}
function del_item(forma,lista1,lista2,conlista)
{var sep=''
var sep2=''
var list=''
var list2=''
var list3=''
var list4=''
var list5=''
var existente=0
var valores=''
indice=forma[lista1].length-1;for(i=0;i<forma[lista2].length;i++){if(forma[lista2].selectedIndex!=i){list+=sep+forma[lista2][i].text
list2+=sep+forma[lista2][i].value
sep='|'}
else
{list3+=sep2+forma[lista2][i].text
list4+=sep2+forma[lista2][i].value
sep2='|'}}
listArray=list.split("|")
listArray2=list2.split("|")
forma[lista2].length=0
listArray3=list3.split("|")
listArray4=list4.split("|")
for(i=0;i<listArray.length;i++){if(listArray[i]!='')
forma[lista2].options[i]=new Option(listArray[i],listArray2[i]);}
for(i=0;i<listArray3.length;i++){existente=0;for(j=0;j<forma[lista1].length;j++)
{valores=forma[lista1][j].text;if(valores==listArray3[i])
{existente=1;}}
if((listArray3[i]!='')&&(existente=='0'))
forma[lista1].options[forma[lista1].length]=new Option(listArray3[i],listArray4[i]);}
sep2=''
for(i=0;i<forma[lista2].length;i++){list5+=sep2+forma[lista2][i].value
sep2='|'}
forma[conlista].value=list5}
function justnumber(forma,cadena)
{var contents;contents=document[forma][cadena].value;if(contents!=0)
{if(((contents/contents)!=1))
{alert('Just numbers');document[forma][cadena].focus();document[forma][cadena].select();return(false);}
else
{return(true);}}
else
{return(true);}}
function prevalida(tipo)
{if(confirm('Dou you want to '+tipo+'?'))
{return(true)}
else
{return(false)}}
function preaprobar(tipo)
{if(confirm('Seguro que desea aprobar el proyecto Nº '+tipo+'?'))
{return(true)}
else
{return(false)}}
function creafecha(tipo,idioma)
{var meses,i,dia,ano,browser;if(idioma='ingles')
{dia='Day'
ano='Year';meses=new Array(13);meses[1]='Month';meses[2]='January';meses[3]='February';meses[4]='March';meses[5]='April';meses[6]='May';meses[7]='June';meses[8]='July';meses[9]='August';meses[10]='September';meses[11]='October';meses[12]='November';meses[13]='December';}
else
{dia='Dia';ano='A&ntilde;o';meses=new Array(13);meses[1]='Mes';meses[2]='Enero';meses[3]='Febrero';meses[4]='Marzo';meses[5]='Abril';meses[6]='Mayo';meses[7]='Junio';meses[8]='Julio';meses[9]='Agosto';meses[10]='Septiembre';meses[11]='Octubre';meses[12]='Noviembre';meses[13]='Diciembre';}
switch(tipo)
{case'mes':document.write('<option value='+meses[1]+' selected>'+meses[1])
for(i=2;i<=meses.length-1;i++)
{document.write('<option value='+meses[i]+'>'+meses[i]);}
break;case'dia':document.write('<option value='+dia+' selected>'+dia)
for(i=1;i<=31;i++)
{document.write('<option value='+i+'>'+i);}
break;case'ano':document.write('<option value='+ano+' selected>'+ano)
ano=new Date();ano=ano.getYear();browser=navigator.appName;if(browser.indexOf('Netscape')!=-1)
{ano=parseInt(ano,10)+1900;document.write('<option value='+ano+'>'+ano);}
else
{document.write('<option value='+ano+'>'+ano);}
break;}}
function validafecha(forma,mes,dia,ano,idioma)
{var auxano,i,auxmes,auxdia,auxano,auxmeses;auxmes=document[forma][mes].value;auxdia=document[forma][dia].value;i=document[forma][mes].selectedIndex;auxano=document[forma][ano].value;auxmeses=new Array(12);auxmeses[1]=31;auxmeses[2]=28;auxmeses[3]=31;auxmeses[4]=30;auxmeses[5]=31;auxmeses[6]=30;auxmeses[7]=31;auxmeses[8]=31;auxmeses[9]=30;auxmeses[10]=31;auxmeses[11]=30;auxmeses[12]=31;if(idioma='ingles')
mensaje="Please input a valid date";else
mensaje="Por favor introduzca una fecha válida";if(auxano>=2000)
{while(auxano>2000)
{auxano=auxano-4;}
if(auxano==2000)
{auxmeses[2]=29;if(auxdia<=auxmeses[i])
return(true);else
alert(mensaje);return(false);}
else
{auxmeses[2]=28;if(auxdia<=auxmeses[i])
return(true);else
alert(mensaje);return(false);}}
if(auxano<2000)
{while(auxano<2000)
{auxano=auxano+4;}
if(auxano==2000)
{auxmeses[2]=29;if(auxdia<=auxmeses[i])
return(true);else
alert(mensaje);return(false);}
else
{auxmeses[2]=28;if(auxdia<=auxmeses[i])
return(true);else
alert(mensaje);return(false);}}}
function validalogpass(forma,cadena,tipo)
{var ecadena;ecadena=document[forma][cadena].value;if(ecadena.length>=6)
{return(true);}
else
{alert(tipo+" no puede tener menos de 6 caracteres");document[forma][cadena].focus();document[forma][cadena].select();return(false);}}
function validapass(forma,campopass,camporepass)
{var password,password2;password=document[forma][campopass].value;password2=document[forma][camporepass].value;if(password!=''&&password2!='')
{if(password.length<6||password2.length<6)
{alert("La contrase&ntilde;a no puede ser menor a 6 caracteres");document[forma][camporepass].focus();document[forma][camporepass].select();return(false);}
else
{if(password==password2)
{return(true);}
else
{alert("Las Contrase&ntilde;as no coinciden");document[forma][camporepass].value='';document[forma][campopass].value='';document[forma][campopass].focus();return(false);}}}}
function redir(locacion)
{setTimeout("top.location.href ="+locacion,5000);}
function cent(amount)
{amount-=0;return(amount==Math.floor(amount))?amount+'.00':((amount*10==Math.floor(amount*10))?amount+'0':amount);}
function convstring(entero)
{entero=entero+'';return(entero);}
function outputComma(number)
{number=''+number
if(number.length>3){var mod=number.length%3;var output=(mod>0?(number.substring(0,mod)):'');for(i=0;i<Math.floor(number.length/3);i++){if((mod==0)&&(i==0))
output+=number.substring(mod+3*i,mod+3*i+3);else
output+=','+number.substring(mod+3*i,mod+3*i+3);}
return(output);}
else return number;}
function Empty(field)
{var ecampo;ecadena=field.value;ecampo=0;if(ecadena.length==0)
return true;else
{for(j=0;j<ecadena.length-1;j++)
{ecampo=ecadena.charAt(j);if(ecampo!='')
{return false;}}}}
function EnviaForma(forma,estado)
{var valor;valor=forma.action.indexOf('?');if(valor>=0)
{forma.action=forma.action+'&acc='+estado;forma.submit();}
else
{forma.action=forma.action+'?acc='+estado;forma.submit();}}
function validar_return(forma)
{var cadena,nombre,longitud,num,genera,valor,campo;num=0;for(i=0;i<=forma.length-1;i++)
{cadena=forma.elements[i].name.substring(0,2);if(cadena=='r_')
{switch(forma.elements[i].type)
{case'text':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'file':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'password':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'textarea':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'select-one':if(forma.elements[i].selectedIndex==0)
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;}}}
if(num>0)
{alert('Por favor complete la informacion solicitada.');return(false)}
else
{return(true)}}
function validar(forma,estado,mensaje)
{var cadena,nombre,longitud,num,genera,valor,campo;if(estado=='ing')
{num=0;for(i=0;i<=forma.length-1;i++)
{if(forma.elements[i].name)
{cadena=forma.elements[i].name.substring(0,2);if(cadena=='r_')
{switch(forma.elements[i].type)
{case'text':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'file':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'password':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'textarea':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'select-one':if(forma.elements[i].selectedIndex==0)
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;}}}}
if(num>0)
{alert('Por favor complete la informacion solicitada.');}
else
{switch(mensaje)
{case 1:msj='¿Esta seguro que desea ingresar el registro?';break;case 2:msj='¿Esta seguro que desea modificar el registro?';break;}
if(mensaje>0)
{if(confirm(msj))
{EnviaForma(forma,estado);}
else
{return(false);}}
else
{EnviaForma(forma,estado);}}}
else
{EnviaForma(forma,estado);}}
function validar1(forma,estado)
{var cadena,nombre,longitud,num,genera,valor,campo;if(estado=='ing')
{num=0;for(i=0;i<=forma.length-1;i++)
{cadena=forma.elements[i].name.substring(0,2);if(cadena=='r_')
{switch(forma.elements[i].type)
{case'text':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'file':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'password':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'textarea':if(Empty(forma.elements[i]))
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;case'select-one':if(forma.elements[i].selectedIndex==0)
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/check.gif';num++;}
else
{longitud=forma.elements[i].name.length;nombre='img_'+forma.elements[i].name.substring(2,longitud);genera=new Image(10,10);forma[nombre].src=varDirImg+'images/empty.gif';}
break;}}}
if(num>0)
{alert('Por favor complete la informacion solicitada.');}
else
{valor=forma.action.indexOf('?');if(valor>=0)
{forma.action=forma.action+'&acc='+estado;forma.submit();}
else
{forma.action=forma.action+'?acc='+estado;forma.submit();}}}
else
{valor=forma.action.indexOf('?');if(valor>=0)
{forma.action=forma.action+'&acc='+estado;forma.submit();}
else
{forma.action=forma.action+'?acc='+estado;forma.submit();}}}
function validaemail(forma,cadena)
{var ecadena;ecadena=document[forma][cadena].value;if(ecadena.indexOf("@")!=-1)
{return(true);}
else
{alert("Introduzca un email válido");document[forma][cadena].focus();document[forma][cadena].select();return(false);}}
function validaemail2(forma,cadena)
{var ecadena;ecadena=document.getElementById(cadena).value;if(ecadena!='')
{if((ecadena.indexOf("@")==-1)||(ecadena.indexOf(".")==-1))
{alert("Introduzca un email válido");document.getElementById(cadena).value='';document.getElementById(cadena).focus();return(false);}
else if(ecadena.indexOf("\\")==-1){return(true);}
else if(ecadena.indexOf("/")==-1){return(true);}
else if(ecadena.indexOf("'")==-1){return(true);}
else if(ecadena.indexOf("!")==-1){return(true);}
else if(ecadena.indexOf("?")==-1){return(true);}
else if((ecadena.indexOf("à")==-1)||(ecadena.indexOf("&aacute;")==-1)||(ecadena.indexOf("ä")==-1)||(ecadena.indexOf("è")==-1)||(ecadena.indexOf("&eacute;")==-1)||(ecadena.indexOf("ë")==-1)||(ecadena.indexOf("ì")==-1)||(ecadena.indexOf("&iacute;")==-1)||(ecadena.indexOf("ï")==-1)||(ecadena.indexOf("&ntilde;")==-1)||(ecadena.indexOf("ò")==-1)||(ecadena.indexOf("&oacute;")==-1)||(ecadena.indexOf("ö")==-1)||(ecadena.indexOf("ù")==-1)||(ecadena.indexOf("&uacute;")==-1)||(ecadena.indexOf("ü")==-1)||(ecadena.indexOf("ý")==-1)||(ecadena.indexOf("ÿ")==-1)){return(true);}
else
{alert("Introduzca un email válido");document.getElementById(cadena).value='';document.getElementById(cadena).focus();return(false);}}
else
{return true;}}
function edades(dia,mes,ano,edad)
{fecha=mes+'/'+dia+'/'+ano
cumple=new Date(fecha)
hoy=new Date()
diferencia=cumple.getTime()-hoy.getTime()
anos=Math.floor(-(diferencia)/(1000*60*60*24*365))
edad.value=anos}
function campos_hidden(forma)
{var i,nombre,num,variable;num=0;variable=0;for(i=0;i<=forma.length-1;i++)
{if(forma.elements[i].type=='file')
{if(!Empty(forma.elements[i]))
{forma.elements[i+1].value=forma.elements[i].value}}}}
function campos_hidden2(forma2,forma)
{var i,nombre,num,variable;num=0;variable=0;if(forma.elements[0].type=='file')
{if(!Empty(forma.elements[0]))
{forma2.elements[0].value=forma.elements[0].value
alert("archivo: "+forma.elements[0].value+"hidden: "+forma2.elements[0].value)}}}
function posterior(dia,mes,ano)
{fecha=mes+'/'+dia+'/'+ano
post=new Date(fecha)
hoy=new Date()
diferencia=post.getTime()-hoy.getTime()
if(diferencia>0)
alert("Fecha Incorrecta, esta fecha debe ser inferior a la fecha actual")}
function oNumero(numero)
{this.valor=numero||0
this.dec=-1;this.formato=numFormat;this.ponValor=ponValor;function ponValor(cad)
{if(cad=='-'||cad=='+')return
if(cad.length==0)return
if(cad.indexOf('.')>=0)
this.valor=parseFloat(cad);else
this.valor=parseInt(cad);}
function numFormat(dec,miles)
{var num=this.valor,signo=3,expr;var cad=""+this.valor;var ceros="",pos,pdec,i;for(i=0;i<dec;i++)
ceros+='0';pos=cad.indexOf('.')
if(pos<0)
cad=cad+","+ceros;else
{pdec=cad.length-pos-1;if(pdec<=dec)
{for(i=0;i<(dec-pdec);i++)
cad+='0';}
else
{num=num*Math.pow(10,dec);num=Math.round(num);num=num/Math.pow(10,dec);cad=new String(num);}}
cad=cad.replace('.','|')
pos=cad.indexOf('|')
if(pos<0)pos=cad.lentgh
if(cad.substr(0,1)=='-'||cad.substr(0,1)=='+')
signo=4;if(miles&&pos>signo)
do{expr=/([+-]?\d)(\d{3}[\|\,]\d*)/
cad.match(expr)
cad=cad.replace(expr,RegExp.$1+'.'+RegExp.$2)}
while(cad.indexOf(',')>signo)
if(dec<0)cad=cad.replace(/\./,'')
return cad.replace('|',',');}}
function getDecimal(valor)
{var numero=new oNumero(valor);return(numero.formato(2,true));}