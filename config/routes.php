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
  $routes->get('/groupmemo', function(){
    memoController::index();
  });
  $routes->post('/groupmemo', function(){
    memoController::groupstore();
  });
  $routes->get('/groupmemo/new', function(){
    memoController::groupcreate();
  });    
  $routes->get('/groupmemo/:id', function($id){
    memoController::groupshow($id);
  });
  $routes->get('/groupmemo/:id/edit', function($id){
    memoController::groupedit($id);
  });
  $routes->post('/groupmemo/:id/edit', function($id){
    memoController::groupupdate($id);
  });
  $routes->post('/groupmemo/:id/destroy', function($id){
    memoController::groupdestroy($id);
  });
  
  $routes->get('/login', function(){
    userController::login();
  });
  $routes->post('/login', function(){
    userController::handle_login();
  });
  $routes->post('/logout', function(){
    userController::logout();
  });
    $routes->get('/user', function() {
    userController::index();
  });
    $routes->post('/user', function(){
    userController::store();
  }); 
    $routes->get('/user/new', function(){
    userController::create();
  }); 
    $routes->get('/user/:id', function($id) {
    userController::show($id);
  });
    $routes->get('/user/:id/edit', function($id){
    userController::edit($id);
  });
  $routes->post('/user/:id/edit', function($id){
    userController::update($id);
  });
  $routes->post('/user/:id/destroy', function($id){
    userController::destroy($id);
  });
  
  
    $routes->get('/group', function() {
    groupController::index();
  });
    $routes->post('/group', function(){
    groupController::store();
  }); 
    $routes->get('/group/new', function(){
    groupController::create();
  }); 
    $routes->get('/group/:id', function($id) {
    groupController::show($id);
  });
    $routes->get('/group/:id/edit', function($id){
    groupController::edit($id);
  });
  $routes->post('/group/:id/edit', function($id){
    groupController::update($id);
  });
  $routes->post('/group/:id/destroy', function($id){
    groupController::destroy($id);
  });

 
  
  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  $routes->get('/memoedit', function() {
  HelloWorldController::memo_edit();
  });
