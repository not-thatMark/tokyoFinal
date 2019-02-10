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
        $this -> pages = array(
          'home' => 'index.php',
          'Food'=>'food.php',
          'Cosplay'=>'cosplay.php',
          'Music'=>'music.php',
          'Nature' =>'nature.php',
          'sign in' => 'signin.php',
          'sign up' => 'signup.php'
        );
        break;
      case 1:
        $this -> pages = array(
          'home' => 'index.php',
          'Food'=>'food.php',
          'Cosplay'=>'cosplay.php',
          'Music'=>'music.php',
          'Nature' =>'nature.php',
          'account' => 'useraccount.php',
          'sign out' => 'signout.php'
        );
        break;
      case 2:
        $this -> pages = array(
          'home' => 'index.php',
          'Food'=>'food.php',
          'Cosplay'=>'cosplay.php',
          'Music'=>'music.php',
          'Nature' =>'nature.php',
          'account' => 'useraccount.php',
          'admin' => 'admin.php',
          'sign out' => 'signout.php'
        );
        break;
      default:
        break;
    }
  }
}
?>