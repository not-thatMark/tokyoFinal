<?php 
$connection=mysqli_connect('localhost', 'website', 'password', 'data');

//check connection 
if($connection)
{
    echo "connected !!";
    
}


else{
    echo" connection is not established !";
    
}
//query
$query="SELECT id,name,color,isorganic,price FROM fruit";
//prepare the query
$statement = $connection->prepare($query);
$statement->execute();
$result=$statement->get_result();
if($result->num_rows>0)
{
    
    while($row=$result -> fetch_assoc())
    {
            
        $id=$row['id'];
        $name=$row['name'];
        $color=$row['color'];
        $organic=$row['isorganic'];
        $price=$price['price'];
        echo "<h3>$name<h3>";
        echo "<p> color=$color <br> price=$ $price <br> Organic static: $organic</p>";
        
    }
}
?>
