<!-- Hide
/**********************************************************************************   
BorraLink
*   Copyright (C) 2005 UNIVERSIDAD DISTRITAL FRANCISCO JOS� DE CALDAS
*   Este script fue realizado en la Oficina Asesora de Sistemas
*	PLUMAC, Pedro Luis Manjarr�s Cuello
*********************************************************************************/
function link(){
	window.status="Oficina Asesora de Sistemas";
	setTimeout("link()",1000)
}
link();
function borra(){ return true }
if(document.all||document.getElementById){ document.onMouseOver = borra(); }
// -->