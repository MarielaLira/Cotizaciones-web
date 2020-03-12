<!doctype html>

<html>

<head>

  <meta charset="utf-8">
  <?php wp_head(); ?>
  <title></title>

  <meta name="title" content="proyecto" />

  <meta name="description" content="" />


  <meta name="author" content="spaceshiplabs">
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no">



  <script src="<?php bloginfo('template_directory')?>/bower_components/jquery/dist/jquery.min.js"></script>
  <script> jQuery.fn.load = function (callback) {$(window).trigger("load", callback); };</script>
  
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/bower_components/angular-material/angular-material.css">

  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/bower_components/slick-carousel/slick/slick.css"> 

  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/bower_components/animate.css/animate.min.css">

  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/main.css">

  



</head>

<body ng-app="bores" scroll ng-controller="mainCTL as main">