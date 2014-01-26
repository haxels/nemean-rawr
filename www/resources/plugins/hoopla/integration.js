require(['xdm-client'], function() {
    console.log("Integration.js loaded!");
    if(window.location.search.match(/orderRef/)) {
        // We're redirected back to this page when done paying.
        hoopla.client.complete(hoopla.client.getOrderRef()).then(function(data) {
            if(data.ok) {
                console.log('woo, you completed the purchase!');
            }
        });
    } else {
        console.log("Reserve!");
        hoopla.client.reserve({
            
            // You'd get this from your custom form.
            tickets: [
                {
                    event: 1896380461, // EventID or identifier of your Hoopla-event
                    ticket: 'Deltaker', // TicketTypeID or identifier
                    data: { // Store arbitrary data on the ticket as a JSON object.
                        first_name: 'Ola',
                        last_name: 'Nordmann',
                        something: {
                            awesome: [42]
                        }
                    }
                }
            ]
        }).always(function(result) {
            console.log("Hya!");
            if(result.ok) {
                hoopla.client.checkout({
                    // Same with this.
                    email: 'hans@mail.no'
                }).always(function(result) {
                    if(result.ok) {
                        // Send the user to payment gateway, if paid purchase. (Assuming this here. If it's just free tickets, then "finalized" will be non-null.)
                        window.location.href = result['purchase']['redirect_url'];
                    } else {
                        console.log('checkout failed');
                    }

                });
            } else {
                console.log('Damn it!', result);
            }
            console.log(result);
        });
    }
});