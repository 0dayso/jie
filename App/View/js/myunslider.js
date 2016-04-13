/**
 * Created by Administrator on 2016/4/13.
 */
$(document).ready(function(e) {
    var myunslider = $('#unslider').unslider({
            dots: true
        }),
        data04 = myunslider.data('unslider');

    $('.unslider-arrow').click(function() {
        var fn = this.className.split(' ')[1];
        data04[fn]();
    });
});