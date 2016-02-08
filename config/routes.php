<?php

  $routes->get('/', function() {
      HelloWorldController::index();
  });
  $routes->get('/memo', function() {
    memoController::index();
  });
  $routes->post('/memo', function(){
    memoController::store();
  });
  $routes->get('/memo/new', function(){
    memoController::create();
  });    
  $routes->get('/memo/:id', function($id){
    memoController::show($id);
  });

 
  
  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  $routes->get('/login', function() {
  HelloWorldController::login();
  });
  $routes->get('/memoedit', function() {
  HelloWorldController::memo_edit();
  });
