<!doctype html>
<html ng-app="app">
  <head>
      <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular-touch.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular-animate.js"></script>
    <script src="http://ui-grid.info/docs/grunt-scripts/csv.js"></script>
    <script src="http://ui-grid.info/docs/grunt-scripts/pdfmake.js"></script>
    <script src="http://ui-grid.info/docs/grunt-scripts/vfs_fonts.js"></script>
    <script src="http://ui-grid.info/release/ui-grid-unstable.js"></script>
    <link rel="stylesheet" href="http://ui-grid.info/release/ui-grid-unstable.css" type="text/css">
    </head>
  <body>

<div ng-controller="MainCtrl">
<div ui-grid="{ data: data, columnDefs: columnDefs,enableRowSelection: true,
    enableSelectAll: true,
    enableFiltering: true, }" class="grid" ui-grid-selection ui-grid-edit ui-grid-cellnav></div>
<button ng-click="addNewItem()" > ADD item</button>
<button ng-click="insertNewItem()" > Insert item</button>
</div>


    <script src="configs.js"></script>
  </body>
</html>

