// Call the dataTables jQuery plugin

$(document).ready(function() {
  $('#dataTable').DataTable( {
      "language": {
          "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
      },
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
  } );
} );