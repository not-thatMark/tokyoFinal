<?php
namespace aitsyd;

class ProductDetail extends Product{
  protected $product_id;
  public $product = array();
  public function __construct(){
    parent::__construct();
    $this -> product_id = $_GET['id'];
  }
  public function getProductById(){
    if( isset($this -> product_id) == false ){
      exit();
    }
    else{
    $query = "
    SELECT 
    @pid := postID AS postID,
    postTitle,postBriefDescription,ticketCapacity,
    @photoID :=(SELECT photoID FROM photoPost WHERE postID=@pid LIMIT 1) AS photoID,
    (SELECT photoName FROM photo WHERE photoID=@photoID) AS photoName
    FROM post
    WHERE (postTitle LIKE ? OR post.postBriefDescription LIKE ?)
    ";
      
      $statement = $this -> connection -> prepare($query);
      $statement -> bind_param( 'i' , $this -> product_id );
      if( $statement -> execute() ){
        $tmp_array = array();
        $result = $statement -> get_result();
        while( $row = $result -> fetch_assoc() ){
          array_push( $tmp_array, $row );
        }
        //add the rows from the first row (row[0]) to the product array
        $this -> product['postID'] = $tmp_array[0]['postID'];
        $this -> product['postName'] = $tmp_array[0]['postName'];
        $this -> product['price'] = $tmp_array[0]['price'];
        $this -> product['postBriefDescription'] = $tmp_array[0]['postBriefDescription'];
        //add images to an array
        $img_array = array();
        foreach( $tmp_array as $product ){
          array_push( $img_array, $product['image_file_name'] );
        }
        //add the images array to the product array as 'images'
        $this -> product['images'] = $img_array;
        
        return $this -> product;
      }
      
      
    }
  }
}
?>