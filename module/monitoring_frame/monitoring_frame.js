if (window !=top ) {top.location=window.location;}
	
/*function resize(height,width) {
	var height=81;
	var width=200;
	$(".iframe").height($(window).height() - height);
	$(".iframe").width($(window).width() - width);
}

$(document).ready(function() {
	resize();
});
$(window).resize(function(){
	resize();
});*/

$(function() {
    $(window).bind("load resize", function() {
        topOffset = 51;
		leftOffset = 200;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            topOffset = 100; // 2-row-menu
			leftOffset=0
        } 
		
        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
		$(".iframe").css("top",topOffset);
		$(".iframe").css("left",leftOffset);
		$(".iframe").height(height-$(".footer").height());
		$(".iframe").width(width-leftOffset);
		$(".iframe").css("display","unset");
    });
});