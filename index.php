<?php
include('vendor/autoload.php');
//start session
session_start();

//generate navigation
include('includes/navigation.inc.php');



$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
  //'cache' => 'cache'
  ));

$template = $twig -> load('index.twig');

echo $template -> render( array(
      'pages' => $pages,
      'products' => $products, 
      'pagetitle' => $page_title,
      'currentPage' => $currentPage,
      'categories' => $categories,
     
      'user' => $user
      )
    );

?>
