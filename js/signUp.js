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
  
  static isAlphaNumeric(username){
    let result = true;
    let allowedChrs = 'abcdefghijklmnopqrstuvwxyz1234567890';
    let allowed = allowedChrs.split('');
    let usernameChrs = username.split('');
    usernameChrs.forEach( (chr) =>{
      if( allowedChrs.indexOf( chr.toLowerCase()) == -1){
       result = false;
      }
    });
    return result;
  }
}

let validation = { username: false, email: false, password: false };

$(document).ready( () => {
  //disable the submit button
  $('button[type="submit"]').attr('disabled', true );
  watchValidation();
  $('#sign-up').on('input',( event ) => {
    let targetName = $(event.target).attr('name');
    switch(targetName){
      case 'username' :
        if( Validator.username( $(event.target).val() )){
          validation.username = true;
          $(event.target).removeClass('is-invalid');
          $(event.target).addClass('is-valid');
        }
        else{
          validation.username = false;
          $(event.target).addClass('is-invalid');
        }
        break;
      case 'email' :
        if( Validator.email( $(event.target).val() )){
          validation.email = true;
          $(event.target).removeClass('is-invalid');
          $(event.target).addClass('is-valid');
        }
        else{
          validation.email = false;
          $(event.target).addClass('is-invalid');
        }
        break;
      case 'password' :
        if( Validator.password( $(event.target).val() )){
          validation.password = true;
          $(event.target).removeClass('is-invalid');
          $(event.target).addClass('is-valid');
        }
        else{
          validation.password = false;
          $(event.target).addClass('is-invalid');
        }
        break;
      default:
        break;
    }
  });
  
});

function watchValidation(){
  if( validation.email == false || validation.username == false || validation.password == false ){
    $('button[type="submit"]').attr('disabled', true );
    animId = requestAnimationFrame(watchValidation);
  }
  else{
    $('button[type="submit"]').removeAttr('disabled');
  }
}
