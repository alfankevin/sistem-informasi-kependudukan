"use strict";

$("[data-checkboxes]").each(function() {
  var me = $(this),
    group = me.data('checkboxes'),
    role = me.data('checkbox-role');

  me.change(function() {
    var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
      checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
      dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
      total = all.length,
      checked_length = checked.length;

    if(role == 'dad') {
      if(me.is(':checked')) {
        all.prop('checked', true);
      }else{
        all.prop('checked', false);
      }
    }else{
      if(checked_length >= total) {
        dad.prop('checked', true);
      }else{
        dad.prop('checked', false);
      }
    }
  });
});

$("#penduduk").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [11] }
  ],
  "language": {
    "lengthMenu": "Tampilkan _MENU_ data",
    "zeroRecords": "Tidak ada data pada tabel",
    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
    "infoEmpty": "Menampilkan 0 data",
    "infoFiltered": "(difilter dari _MAX_ total data)"
  },
  "pageLength": 25
});

$("#keluarga").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [6] }
  ],
    "language": {
    "lengthMenu": "Tampilkan _MENU_ data",
    "zeroRecords": "Tidak ada data pada tabel",
    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
    "infoEmpty": "Menampilkan 0 data",
    "infoFiltered": "(difilter dari _MAX_ total data)"
  },
  "pageLength": 25
});

$("#bantuan").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [9] }
  ],
    "language": {
    "lengthMenu": "Tampilkan _MENU_ data",
    "zeroRecords": "Tidak ada data pada tabel",
    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
    "infoEmpty": "Menampilkan 0 data",
    "infoFiltered": "(difilter dari _MAX_ total data)"
  },
  "pageLength": 10
});