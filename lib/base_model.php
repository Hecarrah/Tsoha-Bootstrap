<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();
      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon 
        $errors = array_merge($errors, $this->{$validator}());
        //Kint::dump($errors);
      }
      return $errors;
    }
    
    public function validate_String_not_null($string){
        $errors = array();
        if($string == '' || $string == null){
            $errors[] = 'Minkään arvon ei tule olla null';
        }
        return $errors;
    }
    
    public function validate_String_lenght($string){
        $errors = array();
        if(strlen($string) < 3){
            $errors[] = 'Nimen ja kuvauksen ei tule olla kolmea merkkiä lyhyempiä';
        }
        return $errors;
    }

}
