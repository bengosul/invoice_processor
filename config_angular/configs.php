<?php


https://raw.githubusercontent.com/angular-ui/ui-grid.info/gh-pages/release/ui-grid-stable.min.js

require_once '../functions/general_functions.php';
session_start();
validate_session('Invalid session');
?>
<!doctype html>
<html ng-app="app">
  <head>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.js"></script> 
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular-touch.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular-animate.js"></script>
    <script src="http://ui-grid.info/docs/grunt-scripts/csv.js"></script>
<!--    <script src="http://ui-grid.info/docs/grunt-scripts/pdfmake.js"></script> -->
    <script src="http://ui-grid.info/docs/grunt-scripts/vfs_fonts.js"></script>
<!--    <script src="https://rawgit.com/angular-ui/ui-grid.info/gh-pages/release/ui-grid-stable.min.js"></script> -->
    <script src="ui-grid-stable.min.js"></script>
    <link rel="stylesheet" href="http://ui-grid.info/release/ui-grid-unstable.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../styles/config.css">


  </head>
  <body bgcolor="#001155">



<div ng-controller="MainCtrl">
  <div ui-grid="gridOptions" ui-grid-edit class="grid" ui-grid-auto-resize></div>
	 <button ng-click="addNewItem()" > ADD item</button>
<!--	 <button ng-click="deleteSelected()" > Delete item</button> -->

</div>


</br><a href="../index.php">Main Page</a></br>

    <script src="configs.js"></script>
  </body>
</html>

