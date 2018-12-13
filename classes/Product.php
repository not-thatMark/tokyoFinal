<?php
namespace aitsyd;
class Product extends Database{
    public $product=array();
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getProducts()
{
    $query= "select @pid:=product_id as product_id,
name, description, price, 
@imageid:=(select image_id from product_image where product_id=@pid limit 1) as image_id, (select image_file_name from image where image_id=@imageid) 
as image_file_name
from product

where active=1";
    
    
    $statement=$this->connection->prepare($query);
    $statement->execute();
    $result= $statement->get_result();
    if($result->num_rows>0)
    {
        
        while($row=$result->fetch_assoc())
        {
            array_push($this->product, $row);
            
            
        }
        
    }
    return $this->product;
    
    
}
    
    
}
?>