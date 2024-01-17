<script>
    pusher.subscribe('private-order-update.' + user_current_id).bind('order', function(element) {
        console.log(element);
        jSuites.notification({
            name: 'New order',
            message: 'You receive a new order',
            onClick: () => {
                location.href = `/school/orders/${element['id']}/view`;

            }
        })
        if (typeof orderTable != 'undefined') {
            orderTable.row.add(element).draw(false);
        }

    });

    $('#toggle-burger').click(function(e) {
        e.preventDefault();
        $('.side-nav').css('display', 'block');
    });
    $('#more').click(function(e) {
        $('#more-link').toggle();
    });
    let fullSide = true;
    // $('.toggle-half').click(function(e) {
    //     if (fullSide) {
    //         $('.side-nav span').css('display', 'none');
    //         $('.side-nav').css('width', '95px');
    //         $('.right-content').css('width', 'calc(100% - 95px)');
    //         $('.right-content .header').css('width', 'calc(100% - 95px)');
    //         $('.text-logo').css('display', 'none');
    //     } else {
    //         $('.side-nav span').css('display', 'inline-block');
    //         $('.side-nav').css('width', '250px');
    //         $('.right-content').css('width', 'calc(100% - 250px)');
    //         $('.right-content .header').css('width', 'calc(100% - 250px)');
    //         $('.text-logo').css('display', 'inline-block');
    //     }
    //     fullSide = !fullSide;
    // });

    function messageWithUser(userid) {
        $.ajax({
            type: "POST",
            url: "/school/messages/user/getconvo",
            data: {
                'user_id': userid
            },
            success: function(response) {
                console.log(userid);
                console.log(response);
                if(response.code==200){
                    window.location.href = '/school/messages/' + response.id;
                }
            }
        });
    }
</script>
</div>
</body>

</html>
