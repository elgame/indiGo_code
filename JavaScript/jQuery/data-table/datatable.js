$(function(){
  // INICIA EL PLUGIN
  $('.datatable').dataTable({
      "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
      "sPaginationType": "bootstrap",
      "bFilter": true,
      "oLanguage": {
        "sLengthMenu": "_MENU_ registros por página",
        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "sSearch": "Buscar:",
        "sInfoFiltered": " - filtrando desde _MAX_ registros",
        "sZeroRecords": "No se encontraron registros",
        "sInfoEmpty": "Mostrando _END_ de _TOTAL_ ",
        "oPaginate": {
          "sFirst": "Primera",
          "sPrevious": "Anterior",
          "sNext": "Siguiente",
          "sLast": "Ultima"
        }
       }
    } );
});

