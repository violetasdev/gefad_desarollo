/**********************************************************************************   
SoloNumero 
*   C�digo Creado por 2006 Pedro Luis Manjarres
*   Funci�n creada para la Universidad Distrital
*	Uso: onKeypress="return SoloNumero(event)"
*********************************************************************************/
function SoloNumero(evento) {
    tecla = (document.all) ? evento.keyCode : evento.which;
    if(tecla==8) return true; 
	patron = /\d/;				// Solo acepta n�meros
	//patron = /\w/;			// Acepta n�meros y letras
	//patron = /\D/;			// No acepta n�meros
	//patron =/[A-Za-z��\s]/; 	// Acepta las letras � y �
    te = String.fromCharCode(tecla);
    return patron.test(te);
}