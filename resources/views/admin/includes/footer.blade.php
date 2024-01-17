<script>
    $('#more').click(function(e) {
        $('#more-link').toggle();;

    });
    let fullSide = true;
    $('.toggle-half').click(function(e) {
        if (fullSide) {
            $('.side-nav span').css('display', 'none');
            $('.side-nav').css('width', '95px');
            $('.right-content').css('width', 'calc(100% - 95px)');
            $('.right-content .header').css('width', 'calc(100% - 95px)');
            $('.text-logo').css('display', 'none');

        } else {
            $('.side-nav span').css('display', 'inline-block');
            $('.side-nav').css('width', '250px');
            $('.right-content').css('width', 'calc(100% - 250px)');
            $('.right-content .header').css('width', 'calc(100% - 250px)');
            $('.text-logo').css('display', 'inline-block');
        }
        fullSide = !fullSide;
    });
</script>
</div>
</body>

</html>
