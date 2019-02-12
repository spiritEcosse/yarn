function slide(obj) {
	$(obj).next('.entry').slideToggle();
	$(obj).parent().toggleClass('inactive');

    // $(obj).each(function() {
    //     var trigger = $(this), state = false, el = trigger.next('.entry');
    //     trigger.click(function() {
    //         state = !state;
    //         el.slideToggle();
    //         trigger.parent().toggleClass('inactive');
    //     });
    // });
}