function cellulant() {
    var refresh = setInterval(() => {
        $.post(cellulantWebookURL, function(response) {
            console.log(response);
        });
    }, 1000);
}

function cellulant_feedback() {
    var refresh = setInterval(() => {
        $.get(cellulantFeedbackURL, function(response) {
            var table_row = ''
            var i = 1;
            response.forEach(el => {
                table_row += '<tr>'
                +'<th scope="row">'+i+'</th>'
                +'<td>'+el.merchantTransactionID+'</td>'
                +'<td>'+el.checkoutRequestID+'</td>'
                +'<td>'+el.statusCode+'</td>'
                +'<td>'+el.statusDescription+'</td>'
                +'</tr>'
                i++;
            })
            $('#feedback-cel').html(table_row);
            
        });
    }, 1000);
}

