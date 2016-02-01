<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  $routes->get('/login', function() {
  HelloWorldController::login();
  });
  $routes->get('/memo', function() {
  HelloWorldController::memo_list();
  });
  $routes->get('/memo/1', function() {
  HelloWorldController::memo_view();
  });
  $routes->get('/memoedit', function() {
  HelloWorldController::memo_edit();
  });
