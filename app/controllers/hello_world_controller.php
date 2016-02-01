<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('home.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }
    public static function memo_list(){
      // Testaa koodiasi täällä
      View::make('suunnitelmat/memoList.html');
    }
    public static function memo_view(){
      // Testaa koodiasi täällä
      View::make('suunnitelmat/memoView.html');
    }
    public static function memo_edit(){
      // Testaa koodiasi täällä
      View::make('suunnitelmat/memoEdit.html');
    }
    public static function login(){
      // Testaa koodiasi täällä
      View::make('suunnitelmat/login.html');
    }
  }
