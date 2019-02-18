<?php
namespace aitsyd;

class Categories extends Database{
  public function __construct(){
    parent::__construct();
  }
  public function getCategories(){
    $query = "SELECT tagID,tagName
    FROM tag";
    $statement = $this -> connection -> prepare( $query );
    $statement -> execute();
    $result = $statement -> get_result();
    if( $result -> num_rows > 0 ){
      $items = array();
      while( $row = $result -> fetch_assoc() ){
        $category = array('id' => $row['tagID'],'name' => $row['tagName']);
        array_push( $items , $category );
      }
      $this -> categories['items'] = $items;
     // $this -> categories['active'] = $this -> getActive();
      return $this -> categories;
    }
    else{
      return null;
    }
  }
  public function getActive(){
    //if category validates as an integer
    if( isset($_GET['tag']) 
      && filter_var($_GET['tag'],FILTER_VALIDATE_INT) )
    {
      $category = $_GET['tag'];
    }
    else{
      $category = '';
    }
    return $category;
  }
}
?>