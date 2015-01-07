
;
(function ($) {
    $(document).ready(function () {
        $('[data-toggle="offcanvas"]').click(function (e) {
            $('.row-offcanvas').toggleClass('active');
            e.preventDefault();
        });
    });
})(jQuery);