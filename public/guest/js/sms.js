function Authorization() {
    // var credentials = {
    //     "name": "eddic",
    //     "password": 'eddy11'
    // }
    // var Host = "https://sms.opestechnologies.co.tz/api/get-api-key";

    // $.post(Host, credentials, (results) => {
    //     console.log(results.success.token)
    // })

  var settings = {
      "url":"https://sms.opestechnologies.co.tz/api/get-api-key",
      "method":"POST",
      "timeout": 0,
      "headers": {
          "Content-Type":"application/json"
      },
      "data": JSON.stringify({
          "name":"eddic",
          "password":"eddy11"
      }),
      };
      $.ajax(settings).done(function(response){
          console.log(response);
      });

}