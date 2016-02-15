<?php
require 'app/controllers/userController.php';
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
  $routes->get('/memo/:id/edit', function($id){
    memoController::edit($id);
  });
  $routes->post('/memo/:id/edit', function($id){
    memoController::update($id);
  });
  $routes->post('/memo/:id/destroy', function($id){
    memoController::destroy($id);
  });
  $routes->get('/login', function(){
    userController::login();
  });
  $routes->post('/login', function(){
    userController::handle_login();
  });

 
  
  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  $routes->get('/memoedit', function() {
  HelloWorldController::memo_edit();
  });
