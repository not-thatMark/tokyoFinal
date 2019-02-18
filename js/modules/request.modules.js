export class XhrRequest{
  static async make(reqObj){
    return new Promise( ( resolve, reject ) => {
      try{
        if(!reqObj.url){
          throw 'no destination url defined';
        }
        else{
          let timeStamp = new Date().getTime();
          let url = `${ reqObj.url }?ts=${ timeStamp } `;
          let method = (reqObj.method) ? reqObj.method : 'get';
          let payload = (reqObj.data) ? JSON.stringify(reqObj.data) : '';
          
          let request = new XMLHttpRequest();
          request.open( method, url );
          request.setRequestHeader('Content-Type', 'application/json');
          request.addEventListener('load', ( response ) => {
            if( request.status == '200' && request.readyState == '4' ){
              resolve( request.responseText );
            }
            else{
              throw('request failed');
            }
          });
          request.send( payload );
        }
      }
      catch(error){
        reject(error);
      }
    });
  }
}