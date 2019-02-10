//to be loaded in useraccount.twig

//validator class
//Validator class
class Validator{
  static email( email ){
    //check where '@' occurs
    let at = email.indexOf('@');
    //check where the last '.' occurs
    let dot = email.lastIndexOf('.');
    //get length of the email string
    let len = email.length;
    //if email has an '@' after first character and a '.' after '@" and before the end
    if( at > 0 && dot > at && dot < len-2 ){
      return true;
    }
    else{
      return false;
    }
  }
  static username( username ){
    //check for length
    if( username.length < 6 ){
      return false;
    }
    //check for space
    else if( username.indexOf(' ') !== -1){
      return false;
    }
    //check if it contains letters or numbers
    else if( this.isAlphaNumeric(username) == false ){
      return false;
    }
    else{
      return true;
    }
  }
  static password( password ){
    return (password.length >= 8) ? true : false;
  }
  //function to check two passwords
  static twoPasswords( password1, password2){
    //if password 2 has not been filled
    if( password2 == '' ){
      return this.password( password1 );
    }
    else{
      let validPassword1 = this.password(password1);
      let validPassword2 = this.password(password2);
      let match = (password1 == password2) ? true : false;
      if( validPassword1 && validPassword2 && match ){
        return true;
      }
    }
  }
  static isAlphaNumeric( str ){
    let result = true;
    let allowedChrs = 'abcdefghijklmnopqrstuvwxyz1234567890';
    let allowed = allowedChrs.split('');
    let usernameChrs = str.split('');
    usernameChrs.forEach( (chr) =>{
      if( allowedChrs.indexOf( chr.toLowerCase()) == -1){
       result = false;
      }
    });
    return result;
  }
  isNotAlphaNumeric(str){
    return ( !this.isAlphaNumeric( str )) ? true : false;
  }
}
$(document).ready(
  () => {
    //'input' occurs when use inputs any field in the form
    //we delegate the event listener to the form
    $('#useraccount').on('input', (event) => {
      const target = $(event.target);
      switch( target.attr('name') ){
        case 'username':
          let username = target.val();
          let validUser = ( Validator.username(username) ) ? true : false;
          changeValidationStatus(validUser,target);
          break;
        case 'email':
          let email = target.val();
          let validEmail = ( Validator.email(email) ) ? true : false;
          changeValidationStatus(validEmail,target);
          break;
        case 'password1':
          let password11 = target.val();
          let password21 = $('[name="password2"]').val();
          let validPassword1 = ( Validator.twoPasswords(password11,password21) ) ? true : false;
          if( password11.length > 0 ){
            //change both status
          }
          changeValidationStatus(validPassword1,target);
          break;
        case 'password2':
          let password22 = target.val();
          let password12 = $('[name="password1"]').val();
          let validPassword2 = ( Validator.twoPasswords(password12,password22) ) ? true : false;
          changeValidationStatus(validPassword2,target);
          break;
      }
    });
  }
);

function changeValidationStatus(valid,target){
  if( valid ){
    target.removeClass('is-invalid');
    target.addClass('is-valid');
  }
  else{
    target.removeClass('is-valid');
    target.addClass('is-invalid');
  }
}

function xhrRequest( destinationUrl, data ){
  $.ajax({ 
    url: destinationUrl,
    dataType: 'json',
    method: 'post'
  })
  .done( (response) => {
    return response;
  })
  .fail( (error) => {
    console.log(error);
  });
}