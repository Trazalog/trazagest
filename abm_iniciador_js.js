//Libreria script para modulo abm_expediente

/*------------------------Mascara de Entrada----------------------*/

var patron  = new Array(2,2,4);
var patron2 = new Array(2,8,1);
var patron3 = new Array(5,8,3);
var patron4 = new Array(2,3,3);
var patron5 = new Array(4,9);

function mascara(d,sep,pat,nums){
if(d.valant != d.value){
	val = d.value
	largo = val.length
	val = val.split(sep)
	val2 = ''
	for(r=0;r<val.length;r++){
		val2 += val[r]
	}
	if(nums){
		for(z=0;z<val2.length;z++){
			if(isNaN(val2.charAt(z))){
				letra = new RegExp(val2.charAt(z),"g")
				val2 = val2.replace(letra,"")
			}
		}
	}
	val = ''
	val3 = new Array()
	for(s=0; s<pat.length; s++){
		val3[s] = val2.substring(0,pat[s])
		val2 = val2.substr(pat[s])
	}
	for(q=0;q<val3.length; q++){
		if(q ==0){
			val = val3[q]
		}
		else{
			if(val3[q] != ""){
				val += sep + val3[q]
				}
		}
	}
	d.value = val
	d.valant = val
	}
}
//--------------------------------------Fin de Mascara---------------------------------------//



//-------------------------------------funciones de Pantalla---------------------------------//
function limpiartext()
{
    document.formexp.tnroexp.value="";
	document.formexp.tnroini.value="";
	document.formexp.nrofolio.value="";
	document.formexp.tfecha.value="";
	document.formexp.tfechain.value="";
	document.formexp.cart_exp.value="";
	document.formexp.testract.value="";
	document.formexp.dtll_exp.value="";
	document.formexp.lt_exp.value="";
	document.formexp.obs_exp.value="";
	document.formexp.dt_exp.value="";
	document.formexp.tnroexp.focus();
}
//--------------------------------------Fin de Funciones de Pantalla---------------------------//



//--------------------------------------Validaciones de Entrada de Datos-----------------------//
function validacionnro(f)  {
    if (isNaN(f.value)) {
        alert("Error:\nEste campo debe tener sólo números.");
        f.focus();
        return (false);
    }
}

function esFechaValida(fecha)
{
	if (fecha != undefined && fecha.value != "" )
	{
        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(fecha.value))
        {
            alert("formato de fecha no válido (dd/mm/aaaa)");
    		fecha.focus();
            return false;
        }
        var dia  =  parseInt(fecha.value.substring(0,2),10);
        var mes  =  parseInt(fecha.value.substring(3,5),10);
        var anio =  parseInt(fecha.value.substring(6),10);

        switch(mes){
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                numDias=31;
                break;
            case 4: case 6: case 9: case 11:
                numDias=30;
                break;
            case 2:
                if (comprobarSiBisisesto(anio))
                {
                    numDias=29
                }
                else
                {
                    numDias=28
                };
                break;
            default:{
                alert("Fecha introducida errónea");
                fecha.focus();
                return false;
            }
        }

        if (dia>numDias || dia==0)
        {
            alert("Fecha introducida errónea");
            fecha.focus();
            return false;
        }
    }

    var annio=new Date();
    if(anio>annio.getYear())
    {
        alert("Años Incorrecto");
        fecha.focus();
        return false;
	}

    return true;
}

function comprobarSiBisisesto(anio)
{
	if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0)))
	{
        return true;
    }
    else
	{
        return false;
    }
}

function vdni()
{
	if(document.finici.tdni.value=="")
    {
   	   alert("El campo DNI esta vacio");
	   document.finici.tdni.focus();
	   return false;
    }
	else
	{
	   return true;
	}
}

function vnombre()
{
	if(document.finici.tnom.value=="")
	{
	    alert("El campo nombre esta vacio");
		document.finici.tnom.focus();
		return false;
	}
	else
	{
	   return true;
	}
}

function vapellido()
{
	if(document.finici.tape.value=="")
	{
	    alert("El campo apellido  esta vacio");
		document.finici.tape.focus();
		return false;
	}
	else
	{
	   return true;
	}

}

function vdomicilio()
{
	if(document.finici.tdom.value=="")
	{
	    document.finici.tdom.value = "_";
		return true;
	}
	else
	{
	   return true;
	}

}

function vtelefono()
{
	if(document.finici.ttelef.value=="")
	{
	    alert("El campo Teléfono esta vacio");
		document.finici.ttelef.focus();
		return false;
	}
	else
	{
	   return true;
	}

}
//-------------------------------Fin de Validaciones de Entracda de Datos----------------------//



//-------------------------------Operaciones de Entrada de Datos-------------------------------//
function agregaIniciador()
{

    if((vnombre()==true)&&(vapellido()==true)&&(vdomicilio()==true))
    {
        document.finici.ope.value="Ie";//Operacion Insertar
        document.finici.action="abm_iniciador_libreria.php";
        document.finici.submit();
    }
    else
    {
        alert("Verifique que todos lo campos esten completos");
        return false;
    }
}

function altaexpe()
{
    alert("Pase al JS");
    document.finici.action="altaexpediente.php";
    document.finici.submit();
}
//_________________________________________________________//
//Solo numeros en el campo
/*function numerico(campo)
	{
	var charpos = campo.value.search("[^0-9]");
    if (campo.value.length > 0 &&  charpos >= 0)
		{
		campo.value = "";
		campo.focus();
	    return false;
		}
			else
				{
				return true;
				}
	}*/