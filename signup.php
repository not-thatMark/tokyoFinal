<?php
include('vendor/autoload.php');

use aitsyd\Account;
$page_title = 'Sign Up';
//start session
session_start();

//handle POST request
if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
  //handle POST variables
  $username = $_POST['userName'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  //create instance of account class
  $account = new Account();
  $signup = $account -> signUp( $userName, $email, $password );
  if( $signup['success'] == true ){
    //signup is successful
    //create session variables for user
    $_SESSION['email'] = $signup['email'];
    $_SESSION['userName'] = $signup['userName'];
    $_SESSION['userID'] = $signup['userID'];
    
  }
}

//generate navigation
include('includes/navigation.inc.php');

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
  //'cache' => 'cache'
));

$template = $twig -> load('signup.twig');

echo $template -> render( array(
      'pages' => $pages,
      'pagetitle' => $page_title,
      'currentPage' => $currentPage,
      'response' => $signup
      )
    );
?>