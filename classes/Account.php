<?php
namespace aitsyd;
class Account extends Database{
  public function __construct(){
    parent::__construct();
  }
  public function signUp($username,$email,$password){
    // array to store errors
    $errors = array();
    // using the Validator class
    //validate username
    $validuser = Validator::username( $username );
    if( $validuser['success'] == false ){
      $errors['userName'] = $validuser['errors'];
    }
    //validate email
    $validemail = Validator::email( $email );
    if( $validemail == false ){
      $errors['email'] = $validemail['errors'];
    }
    //validate password
    $validpassword = Validator::password($password);
    if( $validpassword['success'] == false ){
      $errors['password'] = $validpassword['errors'];
    }
    //array for result
    $response = array();
    //check if there are errors
    if( count($errors) > 0 ){
      //signup not successful
      $response['success'] = false;
      $response['errors'] = $errors;
      return $response;
    }
    else{
      //no errors
      //add user to our database
           $query="INSERT INTO user (userName, password,email,userLevel) VALUES (?,?,?,2)";
      //hash the password
      $hash = password_hash($password,PASSWORD_DEFAULT);
      $statement = $this -> connection -> prepare( $query );
      $statement -> bind_param('sss',$email,$hash,$username);
      if( $statement -> execute() ){
        //executed successfully
        $account_id = $this -> connection -> insert_id;
        $response['email'] = $email;
        $response['userName'] = $username;
        $response['account_id'] = $account_id;
        $response['success'] = true;
      }
      elseif( $this -> connection -> errno == '1062'){
        //username or email already exists
        //check if error relates to username
        if( strpos( $this -> connection -> error, 'userName') > 0 ){
          //username already exists
          $response['success'] = false;
          $response['errors']['userName'] = 'username already exists';
        }
        elseif( strpos( $this -> connection -> error, 'email') > 0 ){
          //email already exists
          $response['success'] = false;
          $response['errors']['email'] = 'email already exists';
        }
      }
      return $response;
    }
  }
  
  public function signIn($user,$password){
    //check if $user is an email
    if( filter_var( $user , FILTER_VALIDATE_EMAIL ) ){
      //user is using email address
     $query="SELECT userID,email,userName,password
        FROM user
        WHERE email=?";
    }
    else{
      //user is using username
      $query="SELECT userID,email,userName,password
        FROM user
        WHERE userName=?";
    }

    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('s', $user );
    $statement -> execute();
    $result = $statement -> get_result();
    //array for response
    $response = array();
    
    if( $result -> num_rows == 0 ){
      //account does not exist
      $response['success'] = false;
      $response['user'] = $user;
      $response['error'] = 'account does not exist';
    }
    else{
      $row = $result -> fetch_assoc();
      $account_id = $row['userID'];
      $email = $row['email'];
      $username = $row['userName'];
      $hash = $row['password'];
      //check user's password against the hash
      if( password_verify($password,$hash) ){
        //password matches hash
        $response['success'] = true;
        $response['email'] = $email;
        $response['userName'] = $username;
        $response['account_id'] = $account_id;
      }
      else{
        //password does not match
        $response['success'] = false;
        $response['user'] = $user;
        $response['error'] = 'wrong password';
      }
    }
    return $response;
  }
}
?>