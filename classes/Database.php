<?php
namespace aitsyd;
class Database
{
    
    protected $connection;
    protected function __construct()
        {
            try
            {
                $conn = mysqli_connect(getenv('host'), getenv('dbuser'), getenv('dbpassword'), getenv('dbname') );
                if($conn)
                {
                    $this->connection=$conn;
                }
                
                else{
                    throw new Exception('database connection error :((((');
                    
                }
                    
                
                
            }
            catch(Exception $exc)
            {
                echo $exc;
            }
    
    
        }
    
}
?>