function abrir_ventana(url,nombre)
{
	
	var ventana=window.open(url,nombre,"resizable,status,menubar,width=850,height=400,scrollbars");
	return ventana;
}

var campo;
var campo_2;
function abrir_emergente(url,nombre,field,field_2)
{
	campo=field;
	campo_2=field_2;
	var ventana=open(url,nombre,"resizable,status,menubar,width=850,height=400,scrollbars");
	


}

function comparar(formulario)
{
	var mi_matriz=new Array();
	var cadena='observacion_';
	var control=0;
	var indice=0;
	
	
	
	while( formulario.elements[control])
	{

		if((formulario.elements[control].name.substring(0,cadena.length)!='observacion_')&&(formulario.elements[control].name!='id_esquema'))
		{
			if(!isNaN(formulario.elements[control].value))
			{
				
				mi_matriz[indice]=parseInt(formulario.elements[control].value);
				//alert (formulario.elements[control].name+'->'+mi_matriz[indice]);
				indice++;
				
					
			}
		}	
		control++;	
	}
	
	mi_matriz.sort();
	
	var resultado;
	var a;
	
	for(a=0;a<(mi_matriz.length-1);a++)
	{
		resultado=compararEnteros(mi_matriz[a],mi_matriz[(a+1)]);
		if(resultado==1)
		{
			alert1("Se esperaba no tener valores duplicados:"+mi_matriz[a]+'-'+mi_matriz[(a+1)]);
			return false;
		}
			
		
	}
	return true;
}

function compararEnteros(vNum1, vNum2) 
{
	var iNum1 = parseInt(vNum1);
	var iNum2 = parseInt(vNum2);
	//alert(iNum1+' - '+iNum2);
	if (iNum1 < iNum2) 
	{
		return 0;
	} 
	else if (iNum1 > iNum2) 
	{
		return 2;
	} 
	else 
	{
		return 1;
	}
}




//Funciones para el calculo de valores en el formulario de matriz documental

function cumplimiento_evidencia(formulario,campo_1,campo_2,campo_3,campo_4,campo_5,campo_6,campo_7,campo_8)
{
	//alert1(cumplimiento);
	var cumplimiento = formulario.elements[campo_1];
	var evaluacion = formulario.elements[campo_2];	
	var ponderacion = formulario.elements[campo_3];	
	var total_criterio = formulario.elements[campo_4];
	var total_documento = formulario.elements[campo_5];
	var ideal_documento = formulario.elements[campo_6];	
	var porcentaje_criterio=formulario.elements[campo_7];	
	var ideal_criterio=formulario.elements[campo_8];	
	
	var sum_indicador= 0;
	
	var verificar=verificar_rango(formulario,campo_1, 0, 5);
	
	
	if(verificar==false)
	{
		cumplimiento.value=0;
		
	}
	if(isNaN(total_documento.value))
	{
		sum_indicador=0;
	
	}
	else
	{
		sum_indicador=total_documento.value*1*ideal_documento.value/100;	
	}
	
	
	
	total_criterio.value=total_criterio.value*1-evaluacion.value*1+cumplimiento.value*ponderacion.value;
	sum_indicador=sum_indicador*1-evaluacion.value*1+cumplimiento.value*ponderacion.value;
	
	//alert(sum_indicador);
	evaluacion.value=cumplimiento.value*ponderacion.value;
	total_documento.value=sum_indicador*100/ideal_documento.value;
	porcentaje_criterio.value=total_criterio.value*100/ideal_criterio.value;
	
	
	
}


function verificar_incidencia(formulario,campo_1,campo_2,campo_3,campo_4,campo_5)
{
	
	var incidencia = formulario.elements[campo_1];
	var anterior = formulario.elements[campo_2];
	var actividad = formulario.elements[campo_3];	
	var pasividad = formulario.elements[campo_4];	
	var total = formulario.elements[campo_5];
	
	if(!verificar_rango(formulario,campo_1, 0, 4))
	{
		actividad.value=(actividad.value*1)-(anterior.value*1);
		pasividad.value=(pasividad.value*1)-(anterior.value*1);	
		total.value=(total.value*1)-(anterior.value*1);
		anterior.value=0;		
		incidencia.value=0;
		return false;
		
		
	}
	
	if(isNaN(actividad.value))
	{
		actividad.value=0;
		
	
	}
	
	if(isNaN(pasividad.value))
	{
		pasividad.value=0;
	
	}
	actividad.value=(actividad.value*1)-(anterior.value*1);
	pasividad.value=(pasividad.value*1)-(anterior.value*1);	
	total.value=(total.value*1)-(anterior.value*1);
	
	actividad.value=(actividad.value*1)+(incidencia.value*1);
	pasividad.value=(pasividad.value*1)+(incidencia.value*1);	
	total.value=(total.value*1)+(incidencia.value*1);
	anterior.value=incidencia.value;
	return true;	
}





var marked_row = new Array;


function setPointer(theRow, theRowNum, theAction, theDefaultColor, thePointerColor, theMarkColor)
{
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;
    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        currentColor = theCells[0].style.backgroundColor;
        domDetect    = false;
    } // end 3

    // 3.3 ... Opera changes colors set via HTML to rgb(r,g,b) format so fix it
    if (currentColor.indexOf("rgb") >= 0) 
    {
        var rgbStr = currentColor.slice(currentColor.indexOf('(') + 1,
                                     currentColor.indexOf(')'));
        var rgbValues = rgbStr.split(",");
        currentColor = "#";
        var hexChars = "0123456789ABCDEF";
        for (var i = 0; i < 3; i++)
        {
            var v = rgbValues[i].valueOf();
            currentColor += hexChars.charAt(v/16) + hexChars.charAt(v%16);
        }
    }

    // 4. Defines the new color
    // 4.1 Current color is the default one
    if (currentColor == '' || currentColor.toLowerCase() == theDefaultColor.toLowerCase()) 
    {
        if (theAction == 'over' && thePointerColor != '') 
	{
            newColor= thePointerColor;
	}else if (theAction == 'click' && theMarkColor != '') 
	{
            newColor= theMarkColor;
            marked_row[theRowNum] = true;
            // Garvin: deactivated onclick marking of the checkbox because it's also executed
            // when an action (like edit/delete) on a single item is performed. Then the checkbox
            // would get deactived, even though we need it activated. Maybe there is a way
            // to detect if the row was clicked, and not an item therein...
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
        }
    }// 4.1.2 Current color is the pointer one
    else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()&& (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) 
    {
        if (theAction =='out') 
	{
            newColor=theDefaultColor;
        }else if (theAction == 'click' && theMarkColor != '') 
	{
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
        }
    } // 4.1.3 Current color is the marker one
    else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) 
    {
        if (theAction == 'click') 
	{
            newColor= (thePointerColor != '')? thePointerColor:theDefaultColor;
            marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])? true: null;
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = false;
        }
    } // end 4

    // 5. Sets the new color...
    if (newColor) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            } // end for
        }
        // 5.2 ... with other browsers
        else {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].style.backgroundColor = newColor;
            }
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function


function alert1(x) 
{ 
	alert(acentos(x)) 
}

function confirm1(x) 
{ 
	confirm(acentos(x)) 
}

function acentos(x) 
{
	// version 040623
	// Spanish - Español
	// Portuguese - Portugués - Português
	// Italian - Italiano
	// French - Francés - Français
	// Also accepts and converts single and double quotation marks, square and angle brackets
	// and miscelaneous symbols.
	// Also accepts and converts html entities for all the above.
//	if (navigator.appVersion.toLowerCase().indexOf("windows") != -1) {return x}
	x = x.replace(/¡/g,"\xA1");	x = x.replace(/&iexcl;/g,"\xA1")
	x = x.replace(/¿/g,"\xBF");	x = x.replace(/&iquest;/g,"\xBF")
	x = x.replace(/À/g,"\xC0");	x = x.replace(/&Agrave;/g,"\xC0")
	x = x.replace(/à/g,"\xE0");	x = x.replace(/&agrave;/g,"\xE0")
	x = x.replace(/Á/g,"\xC1");	x = x.replace(/&Aacute;/g,"\xC1")
	x = x.replace(/á/g,"\xE1");	x = x.replace(/á/g,"\xE1")
	x = x.replace(/Â/g,"\xC2");	x = x.replace(/&Acirc;/g,"\xC2")
	x = x.replace(/â/g,"\xE2");	x = x.replace(/&acirc;/g,"\xE2")
	x = x.replace(/Ã/g,"\xC3");	x = x.replace(/&Atilde;/g,"\xC3")
	x = x.replace(/ã/g,"\xE3");	x = x.replace(/&atilde;/g,"\xE3")
	x = x.replace(/Ä/g,"\xC4");	x = x.replace(/&Auml;/g,"\xC4")
	x = x.replace(/ä/g,"\xE4");	x = x.replace(/&auml;/g,"\xE4")
	x = x.replace(/Å/g,"\xC5");	x = x.replace(/&Aring;/g,"\xC5")
	x = x.replace(/å/g,"\xE5");	x = x.replace(/&aring;/g,"\xE5")
	x = x.replace(/Æ/g,"\xC6");	x = x.replace(/&AElig;/g,"\xC6")
	x = x.replace(/æ/g,"\xE6");	x = x.replace(/&aelig;/g,"\xE6")
	x = x.replace(/Ç/g,"\xC7");	x = x.replace(/&Ccedil;/g,"\xC7")
	x = x.replace(/ç/g,"\xE7");	x = x.replace(/&ccedil;/g,"\xE7")
	x = x.replace(/È/g,"\xC8");	x = x.replace(/&Egrave;/g,"\xC8")
	x = x.replace(/è/g,"\xE8");	x = x.replace(/&egrave;/g,"\xE8")
	x = x.replace(/É/g,"\xC9");	x = x.replace(/&Eacute;/g,"\xC9")
	x = x.replace(/é/g,"\xE9");	x = x.replace(/&eacute;/g,"\xE9")
	x = x.replace(/Ê/g,"\xCA");	x = x.replace(/&Ecirc;/g,"\xCA")
	x = x.replace(/ê/g,"\xEA");	x = x.replace(/&ecirc;/g,"\xEA")
	x = x.replace(/Ë/g,"\xCB");	x = x.replace(/&Euml;/g,"\xCB")
	x = x.replace(/ë/g,"\xEB");	x = x.replace(/&euml;/g,"\xEB")
	x = x.replace(/Ì/g,"\xCC");	x = x.replace(/&Igrave;/g,"\xCC")
	x = x.replace(/ì/g,"\xEC");	x = x.replace(/&igrave;/g,"\xEC")
	x = x.replace(/Í/g,"\xCD");	x = x.replace(/&Iacute;/g,"\xCD")
	x = x.replace(/í/g,"\xED");	x = x.replace(/&iacute;/g,"\xED")
	x = x.replace(/Î/g,"\xCE");	x = x.replace(/&Icirc;/g,"\xCE")
	x = x.replace(/î/g,"\xEE");	x = x.replace(/&icirc;/g,"\xEE")
	x = x.replace(/Ï/g,"\xCF");	x = x.replace(/&Iuml;/g,"\xCF")
	x = x.replace(/ï/g,"\xEF");	x = x.replace(/&iuml;/g,"\xEF")
	x = x.replace(/Ñ/g,"\xD1");	x = x.replace(/&Ntilde;/g,"\xD1")
	x = x.replace(/ñ/g,"\xF1");	x = x.replace(/&ntilde;/g,"\xF1")
	x = x.replace(/Ò/g,"\xD2");	x = x.replace(/&Ograve;/g,"\xD2")
	x = x.replace(/ò/g,"\xF2");	x = x.replace(/&ograve;/g,"\xF2")
	x = x.replace(/Ó/g,"\xD3");	x = x.replace(/&Oacute;/g,"\xD3")
	x = x.replace(/ó/g,"\xF3");	x = x.replace(/&oacute;/g,"\xF3")
	x = x.replace(/Ô/g,"\xD4");	x = x.replace(/&Ocirc;/g,"\xD4")
	x = x.replace(/ô/g,"\xF4");	x = x.replace(/&ocirc;/g,"\xF4")
	x = x.replace(/Õ/g,"\xD5");	x = x.replace(/&Otilde;/g,"\xD5")
	x = x.replace(/õ/g,"\xF5");	x = x.replace(/&otilde;/g,"\xF5")
	x = x.replace(/Ö/g,"\xD6");	x = x.replace(/&Ouml;/g,"\xD6")
	x = x.replace(/ö/g,"\xF6");	x = x.replace(/&ouml;/g,"\xF6")
	x = x.replace(/Ø/g,"\xD8");	x = x.replace(/&Oslash;/g,"\xD8")
	x = x.replace(/ø/g,"\xF8");	x = x.replace(/&oslash;/g,"\xF8")
	x = x.replace(/Ù/g,"\xD9");	x = x.replace(/&Ugrave;/g,"\xD9")
	x = x.replace(/ù/g,"\xF9");	x = x.replace(/&ugrave;/g,"\xF9")
	x = x.replace(/Ú/g,"\xDA");	x = x.replace(/&Uacute;/g,"\xDA")
	x = x.replace(/ú/g,"\xFA");	x = x.replace(/&uacute;/g,"\xFA")
	x = x.replace(/Û/g,"\xDB");	x = x.replace(/&Ucirc;/g,"\xDB")
	x = x.replace(/û/g,"\xFB");	x = x.replace(/&ucirc;/g,"\xFB")
	x = x.replace(/Ü/g,"\xDC");	x = x.replace(/&Uuml;/g,"\xDC")
	x = x.replace(/ü/g,"\xFC");	x = x.replace(/&uuml;/g,"\xFC")
	
	x = x.replace(/\"/g,"\x22")
	x = x.replace(/\'/g,"\x27")
	x = x.replace(/\</g,"\x3C")
	x = x.replace(/\>/g,"\x3E")
	x = x.replace(/\[/g,"\x5B")
	x = x.replace(/\]/g,"\x5D")

	x = x.replace(/¢/g,"\xA2");	x = x.replace(/&cent;/g,"\xA2") 
	x = x.replace(/£/g,"\xA3");	x = x.replace(/&pound;/g,"\xA3")
	x = x.replace(/€/g,"\u20AC");	x = x.replace(/&euro;/g,"\u20AC") 
	x = x.replace(/©/g,"\xA9");	x = x.replace(/&copy;/g,"\xA9") 
	x = x.replace(/®/g,"\xAE");	x = x.replace(/&reg;/g,"\xAE") 
	x = x.replace(/ª/g,"\xAA");	x = x.replace(/&ordf;/g,"\xAA") 
	x = x.replace(/º/g,"\xBA");	x = x.replace(/&ordm;/g,"\xBA") 
	x = x.replace(/°/g,"\xB0");	x = x.replace(/&deg;/g,"\xB0") 
	x = x.replace(/±/g,"\xB1");	x = x.replace(/&plusmn;/g,"\xB1")
	x = x.replace(/×/g,"\xD7");	x = x.replace(/&times;/g,"\xD7") 
	
		
	return x
}

function control_vacio(formulario,control,nombre)
{
    var isEmpty  = 1;
    var campo = formulario.elements[control];
    // Esto es si la función replace (js1.2) no es soportada
    
    var isRegExp = (typeof(campo.value.replace) != 'undefined');

    if (!isRegExp) {
        isEmpty      = (campo.value == '') ? 1 : 0;
    } else {
        var space_re = new RegExp('\\s+');
        isEmpty      = (campo.value.replace(space_re, '') == '') ? 1 : 0;
    }
    if (isEmpty) 
    {
        //formulario.reset();
        campo.select();
        if(nombre=='')
        {
        	alert1('Todos los campos obligatorios deben ser diligenciados');
        }
        else
        {
        	alert1('El campo de '+ nombre +' debe ser diligenciado.');
        }
        campo.focus();
        return false;
    }

    return true;
} // Fin de la función control_vacio


/**
 * Asegura que los valores enviados en un formulario es numérico y está en un rango determinado
 *
 * @param   object   formulario
 * @param   string   control
 * @param   integer  min
 * @param   integer  max
 *
 * @return  boolean  
 */
function verificar_rango(formulario,control, min, max)
{
	

	var campo         = formulario.elements[control];
	var val           = parseInt(campo.value);
	var valor         = campo.value;
	
	if (typeof(min) == 'undefined') 
	{
		min = 0;
	}
	if (typeof(max) == 'undefined') 
	{
		max = Number.MAX_VALUE;
	}

	if(valor !='')
	{	
		// En el caso de que no sea un número
		if (isNaN(val)) 
		{
			campo.select();
			alert1('El valor introducido debe ser un número');
			campo.focus();
			return false;
		}
		else
		{
			if (val < min || val > max) 
			{
				campo.select();
				alert1(' Se espera un valor entre ' + min + ' y ' + max);
				campo.focus();
				return false;
			}
			else
			{
				campo.value = val;
			}
			
		}
	}
    return true;
} // Fin de la funcion verificar_rango


/**
 * Muestra un mensaje de error si el contenido de los controles no coincide
 *
 *
 * @param   object   formulario
 * @param   string   control - El nombre del control
 *
 * @return  boolean  TRUE si está diligenciado
 */
function comparar_contenido(formulario,control_1,control_2)
{
    
    var campo_1= formulario.elements[control_1];
    var campo_2= formulario.elements[control_2];
    


    if (campo_1.value !=campo_2.value) {
        campo_1.value="";
	campo_2.value="";
        alert1('La clave y confirmación no coinciden. Por favor reintente');
        campo_1.focus();
	return false;
    } 

    return true;
} // Fin de la función comparar_contenido



/**
 * Muestra un mensaje de error si el tamaño de la cadena es inferior a un número dado
 *
 *
 * @param   object   formulario
 * @param   string   control - El nombre del control
 *
 * @return  boolean  TRUE si está diligenciado
 */
function longitud_cadena(formulario,control,tamanno)
{
    
    var campo= formulario.elements[control];
    var longitud= campo.value.length;
    


    if (longitud<tamanno) {
        campo.select();
	alert1('Dato incorrecto. Por seguridad el campo debe contener un dato con más de '+tamanno+' caracteres');
        campo.focus();
	return false;
    } 

    return true;
} // Fin de la función longitud_cadena

/***
 * Muestra un mensaje de error si no se ha seleccionado una opción y se pretende salir
 *
 *
 * @param   object   formulario
 * @param   string   control - El nombre del control
 *
 * @return  boolean  TRUE si está diligenciado
 */
function seleccion_valida(formulario,control)
{
    /*var campo= formulario.elements[control];
    var valor= campo.value;
    alert1('Debe seleccionar una opción.');


    if (valor!=-1) 
	{
        campo.select();
	alert1('Debe seleccionar una opción.');
        campo.focus();
	return false;
	}*/
    return true;
  
} // Fin de la función seleccion_valida



function verificar_correo(formulario,control) {


    var campo= formulario.elements[control];
    var emailStr= campo.value;

/* The following variable tells the rest of the function whether or not
to verify that the address ends in a two-letter country or well-known
TLD.  1 means check it, 0 means don't. */

var checkTLD=1;

/* The following is the list of known TLDs that an e-mail address must end with. */

var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;

/* The following pattern is used to check if the entered e-mail address
fits the user@domain format.  It also is used to separate the username
from the domain. */

var emailPat=/^(.+)@(.+)$/;

/* The following string represents the pattern for matching all special
characters.  We don't want to allow special characters in the address. 
These characters include ( ) < > @ , ; : \ " . [ ] */

var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";

/* The following string represents the range of characters allowed in a 
username or domainname.  It really states which chars aren't allowed.*/

var validChars="\[^\\s" + specialChars + "\]";

/* The following pattern applies if the "user" is a quoted string (in
which case, there are no rules about which characters are allowed
and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
is a legal e-mail address. */

var quotedUser="(\"[^\"]*\")";

/* The following pattern applies for domains that are IP addresses,
rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
e-mail address. NOTE: The square brackets are required. */

var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;

/* The following string represents an atom (basically a series of non-special characters.) */

var atom=validChars + '+';

/* The following string represents one word in the typical username.
For example, in john.doe@somewhere.com, john and doe are words.
Basically, a word is either an atom or quoted string. */

var word="(" + atom + "|" + quotedUser + ")";

// The following pattern describes the structure of the user

var userPat=new RegExp("^" + word + "(\\." + word + ")*$");

/* The following pattern describes the structure of a normal symbolic
domain, as opposed to ipDomainPat, shown above. */

var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");

/* Finally, let's start trying to figure out if the supplied address is valid. */

/* Begin with the coarse pattern to simply break up user@domain into
different pieces that are easy to analyze. */

var matchArray=emailStr.match(emailPat);

if (matchArray==null) {

/* Too many/few @'s or something; basically, this address doesn't
even fit the general mould of a valid e-mail address. */
	campo.select();
	alert('Dirección de correo no válida.');
        campo.focus();
	return false;
}
var user=matchArray[1];
var domain=matchArray[2];

// Start by checking that only basic ASCII characters are in the strings (0-127).

for (i=0; i<user.length; i++) {
if (user.charCodeAt(i)>127) {
	campo.select();
	alert('Dirección de correo no válida.');
        campo.focus();
	return false;
   }
}
for (i=0; i<domain.length; i++) {
if (domain.charCodeAt(i)>127) {
	campo.select();
	alert('Dirección de correo no válida.');
        campo.focus();
	return false;
   }
}

// See if "user" is valid 

if (user.match(userPat)==null) {

campo.select();
	alert('Dirección de correo no válida.');
        campo.focus();
	return false;
}

/* if the e-mail address is at an IP address (as opposed to a symbolic
host name) make sure the IP address is valid. */

var IPArray=domain.match(ipDomainPat);
if (IPArray!=null) {

// this is an IP address

for (var i=1;i<=4;i++) {
if (IPArray[i]>255) {

campo.select();
	alert('Dirección de correo no válida.');
        campo.focus();
	return false;
   }
}
return true;
}

// Domain is symbolic name.  Check if it's valid.
 
var atomPat=new RegExp("^" + atom + "$");
var domArr=domain.split(".");
var len=domArr.length;
for (i=0;i<len;i++) {
if (domArr[i].search(atomPat)==-1) {
campo.select();
	alert('Dirección de correo no válida.');
        campo.focus();
	return false;
   }
}

/* domain name seems valid, but now make sure that it ends in a
known top-level domain (like com, edu, gov) or a two-letter word,
representing country (uk, nl), and that there's a hostname preceding 
the domain or country. */

if (checkTLD && domArr[domArr.length-1].length!=2 && 
domArr[domArr.length-1].search(knownDomsPat)==-1) {
campo.select();
	alert('Dirección de correo no válida.');
        campo.focus();
	return false;
}

// Make sure there's a host name preceding the domain.

if (len<2) {
campo.select();
	alert('Dirección de correo no válida.');
        campo.focus();
	return false;
}

// If we've gotten this far, everything's valid!
return true;
}




