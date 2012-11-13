$(function(){
  $('#date').datetimepicker({
     dateFormat: 'yy-mm-dd', //formato de la fecha - dd,mm,yy=dia,mes,año numericos  DD,MM=dia,mes en texto
     //minDate: '-2Y', maxDate: '+1M +10D', //restringen a un rango el calendario - ej. +10D,-2M,+1Y,-3W(W=semanas) o alguna fecha
     changeMonth: true, //permite modificar los meses (true o false)
     changeYear: true, //permite modificar los años (true o false)
     //yearRange: (fecha_hoy.getFullYear()-70)+':'+fecha_hoy.getFullYear(),
     numberOfMonths: 1, //muestra mas de un mes en el calendario, depende del numero
  });
});