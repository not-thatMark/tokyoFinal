<?php 
namespace aitsyd;
class Categories extends Database
{
    public function __construct()
    {
        parent::__construct();
        
        
    }
    public function getCategories()
    {
        
        $query="SELECT category_id, category_name
        FROM category
        WHERE active=1";
        $statement =$this-> connection ->prepare($query);
        $statement->execute();
        $result=$statement->get_result();
        if($result->num_rows>0)
        {$categories=array();
            
        while($row=$result->fetch_assoc())
        {
            array_push($categories,$row);
            
        }
            return $categories;
        }
        else{
            return null;
        }
       
       
    }
     
     public function getActive()
        {
            return ($_GET['category'])?$_GET['category']:'';
            
        }
}
?>