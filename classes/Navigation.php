<?php
namespace aitsyd;
class Navigation{
  public $pages = array();
  public $authStatus;
  public function __construct(){
    $this -> checkAuth();
    $this -> generateMainNavigation();
  }
  private function checkAuth(){
    if( isset( $_SESSION['email'] ) || isset( $_SESSION['userID'] ) ){
      //if user is admin, set authStatus to 2, otherwise 1
      $this -> authStatus = ( isset($_SESSION['userID']) ) ? 2 : 1;
    }
    else{
      $this -> authStatus == 0;
    }
  }
  protected function generateMainNavigation(){
    switch( $this -> authStatus ){
      case 0:
        $this -> pages['pages'] = array(
          'Food'=>'food.php',
          'Cosplay'=>'food.php',
          'Music'=>'food.php',
          'Nature' =>'food.php'
        );
        $this -> pages['account'] = array(
          'log in' => 'login.php',
          'sign up' => 'signup.php'
        );
        break;
      case 1:
        $this -> pages['pages'] = array(
          'Food'=>'food.php',
          'Cosplay'=>'food.php',
          'Music'=>'food.php',
          'Nature' =>'food.php',
          
        );
         $this -> pages['account'] = array(
          'account' => 'useraccount.php',
          'log out' => 'logout.php'
        );
        break;
      case 2:
        $this -> pages = array(
          'Food'=>'food.php',
          'Cosplay'=>'food.php',
          'Music'=>'food.php',
          'Nature' =>'food.php',
        );
         $this -> pages['account'] = array(
            'ADMIN' => 'admin.php',
          'log out' => 'logout.php'
        );
        break;
      default:
        break;
    }
  }
}
?>