  'use strict';
  $(document).ready(function() {
      $('#example-1').Tabledit({

          editButton: false,
          deleteButton: false,
          hideIdentifier: true,
          columns: {
              identifier: [0, 'id'],
              editable: [
                  [1, 'ARTICULO'],
                  [2, 'UBICACION'],
                  [3, 'STOCK'],
                  [4, 'ALMACEN PRINCIPAL'],
                  [5, 'ALMACEN DESTINO'],

              ]
          }
      });
      $('#example-2').Tabledit({

          columns: {

              identifier: [0, 'id'],

              editable: [
                  [1, 'First Name'],
                  [2, 'Last Name']
              ]

          }

      });
      $('#example-3').Tabledit({

          editButton: false,
          deleteButton: false,
          hideIdentifier: true,
          columns: {
              identifier: [0, 'id'],
              editable: [
                  [1, 'ARTICULO'],
                  [2, 'UNIDAD'],
                  [3, 'CANTIDAD'],
                  [4, 'ALMACEN'],
              ]
          }
      });
      $('#example-4').Tabledit({

          editButton: false,
          deleteButton: false,
          hideIdentifier: true,
          columns: {
              identifier: [0, 'id'],
              editable: [
                  [1, 'ARTICULO'],
                  [2, 'UNIDAD'],
                  [3, 'CANTIDAD'],
                  [4, 'RESPONSABLE'],
                  [5, 'ALMACEN'],
              ]
          }
      });
  });

  function add_row() {
      var table = document.getElementById("example-1");
      var t1 = (table.rows.length);
      var row = table.insertRow(t1);
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);
      var cell4 = row.insertCell(3);
      var cell5 = row.insertCell(4);

      cell1.className = 'abc';
      cell2.className = 'abc';

      $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="First" value="undefined" disabled="">').appendTo(cell1);
      $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="Last" value="undefined"  disabled="">').appendTo(cell2);
      $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="Last" value="undefined"  disabled="">').appendTo(cell3);
      $('<span class="tabledit-span" > PRINCIPAL</span><select class="tabledit-input form-control input-sm" name="ALMACEN PRINCIPAL"  disabled="" ><option value="1">EMBARCACIONES</option><option value="2">PRINCIPAL</option><option value="3">MANTENIMIENTO</option></select>').appendTo(cell4);
      $('<span class="tabledit-span" > EMBARCACIONES</span><select class="tabledit-input form-control input-sm" name="ALMACEN DESTINO"  disabled="" ><option value="1">EMBARCACIONES</option><option value="2">PRINCIPAL</option><option value="3">MANTENIMIENTO</option></select>').appendTo(cell5);

  };

  $('#example-3').Tabledit({

      editButton: false,
      deleteButton: false,
      hideIdentifier: true,
      columns: {
          identifier: [0, 'id'],
          editable: [
              [1, 'ARTICULO'],
              [2, 'UNIDAD'],
              [3, 'CANTIDAD'],
              [4, 'ALMACEN'],
          ]
      }
  });

  function add_row2() {
      var table = document.getElementById("example-3");
      var t1 = (table.rows.length);
      var row = table.insertRow(t1);
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);
      var cell4 = row.insertCell(3);

      cell1.className = 'abc';
      cell2.className = 'abc';

      $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="" value=""  enable="">').appendTo(cell1);
      $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="" value=""  enable="">').appendTo(cell2);
      $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="" value=""  enable="">').appendTo(cell3);
      $('<span class="tabledit-span" > </span><select class="tabledit-input form-control input-sm" name="ALMACEN PRINCIPAL"  enable="" ><option value="1">EMBARCACIONES</option><option value="2">PRINCIPAL</option><option value="3">MANTENIMIENTO</option></select>').appendTo(cell4);

  };

  $('#example-4').Tabledit({

      editButton: false,
      deleteButton: false,
      hideIdentifier: true,
      columns: {
          identifier: [0, 'id'],
          editable: [
              [1, 'ARTICULO'],
              [2, 'UNIDAD'],
              [3, 'CANTIDAD'],
              [4, 'RESPONSABLE'],
              [5, 'ALMACEN'],
          ]
      }
  });

  function add_row3() {
      var table = document.getElementById("example-4");
      var t1 = (table.rows.length);
      var row = table.insertRow(t1);
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);
      var cell4 = row.insertCell(3);
      var cell5 = row.insertCell(4)

      cell1.className = 'abc';
      cell2.className = 'abc';

      $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="First" value="undefined" enable="">').appendTo(cell1);
      $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="Last" value="undefined"  enable="">').appendTo(cell2);
      $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="Last" value="undefined"  enable="">').appendTo(cell3);
      $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="Last" value="undefined"  enable="">').appendTo(cell4);
      $('<span class="tabledit-span" > PRINCIPAL</span><select class="tabledit-input form-control input-sm" name="ALMACEN PRINCIPAL"  enable="" ><option value="1">EMBARCACIONES</option><option value="2">PRINCIPAL</option><option value="3">MANTENIMIENTO</option></select>').appendTo(cell5);

  };