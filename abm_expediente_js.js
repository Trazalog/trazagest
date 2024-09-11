
//Libreria script para modulo abm_expediente

/*------------------------Mascara de Entrada----------------------*/

var patron = new Array(2,2,4)
var patron2 = new Array(2,8,1)
var patron3 = new Array(5,8,3)
var patron4= new Array(2,3,3)

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
	document.formexp.nrofolio.value="";
	document.formexp.tfecha.value="";
	document.formexp.tfechain.value="";
	document.formexp.cart_exp.value="";
	document.formexp.testract.value="";
	document.formexp.dtll_exp.value="";
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
      if (!/^\d{2}\-\d{2}\-\d{4}$/.test(fecha.value))
	  {
        alert("formato de fecha no válido (dd-mm-aaaa)");
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
                  return false;}
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
	    { alert("Años Incorrecto");
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








//-------------------------------Fin de Validaciones de Entracda de Datos----------------------//



//-------------------------------Operaciones de Entrada de Datos-------------------------------//

function guardaExpediente()
{		   
        document.formexp.ope.value="Ie";//Operacion Insertar
        document.formexp.action="abm_expediente_libreria.php";
	    document.formexp.submit();
		
}
function editarExpediente()
{		   
        document.formexp.ope.value="Ee";//Operacion Insertar
        document.formexp.action="abm_expediente_libreria.php";
	    document.formexp.submit();
		
}

function inicio_menu(ob) /* OK */
	{
	 ob.action="principal.php";
	 ob.submit();
	}