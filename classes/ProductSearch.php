<?php
namespace aitsyd;
use aitsyd\Product;
use Exception;

class ProductSearch extends Product{
  private $keywords;
  public $searchResult = array();
  public $searchTotal;
  public function __construct(){
    parent::__construct();
  }
  public function search( $keywords ){
    //user a query with LIKE for more matches
    $query = "SELECT  
    @pid := postID AS postID,
    postTitle,
    postBriefDescription,
    ticketCapacity,
    @photoID := ( SELECT photoID FROM photoPost WHERE postID = @pid LIMIT 1 ) AS photoName,
    ( SELECT photoName FROM photo WHERE photoID = @photoID ) AS photoName
    
    FROM post 
    WHERE ( post.postTitle LIKE ? OR post.postBriefDescription LIKE ? ) ";
    
    //pad keywords with %keyword%
    $search_param = "%$keywords%";
    
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('ss',$search_param, $search_param);
    try{
      if($statement -> execute() == false ){
        throw new Exception('query error');
      }
      else{
        $result = $statement -> get_result();
        if( $result -> num_rows > 0 ){
          $this -> searchTotal = $result -> num_rows;
          while( $row = $result -> fetch_assoc() ){
            array_push( $this -> searchResult, $row );
          }
        }
        return $this -> searchResult;
      }
    }
    catch(Exception $exc){
      error_log($exc -> getMessage() );
    }
  }
}
?>