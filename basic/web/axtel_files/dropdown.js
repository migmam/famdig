(function($){
    $.fn.Dropdown = function( options ){
        var defaults = {
        };

        var $this = $(this)
            ;

        var clearDropdown = function(){
            $(".dropdown-menu").each(function(){
                if ( $(this).css('position') == 'static' ) return;
                $(this).fadeOut('fast');
                $(this).parent().removeClass("active");
            });
        }

        var initSelectors = function(selectors){
            selectors.on('click', function(e){
                e.stopPropagation();
                //$("[data-role=dropdown]").removeClass("active");

                clearDropdown();
                $(this).parents("ul").css("overflow", "visible");

                var $m = $(this).children(".dropdown-menu, .sidebar-dropdown-menu");
                if ($m.css('display') == "block") {
                    $m.fadeOut('fast');
                    $(this).removeClass("active");
                } else {
                    $m.fadeIn('fast');
                    $(this).addClass("active");
                }
            }).on("mouseleave", function(){
                //$(this).children(".dropdown-menu").hide();
            });
            $('html').on("click", function(e){
                clearDropdown();
            });
        }

        return this.each(function(){
            if ( options ) {
                $.extend(defaults, options)
            }

            initSelectors($this);
        });
    }

    $(function () {
        $('[data-role="dropdown"]').each(function () {
            $(this).Dropdown();
        })
    })
})(window.jQuery);


(function($){
    $.fn.PullDown = function( options ){
        var defaults = {
        };

        var $this = $(this);

        var initSelectors = function(selectors){

            selectors.on('click', function(e){
                e.preventDefault();
                var $m = $this.parent().children("ul");
                //console.log($m);
                if ($m.css('display') == "block") {
                    $m.fadeOut('fast');
                } else {
                    $m.fadeIn('fast');
                }
                //$(this).toggleClass("active");
            });
        }

        return this.each(function(){
            if ( options ) {
                $.extend(defaults, options)
            }

            initSelectors($this);
        });
    }

    $(function () {
        $('.pull-menu, .menu-pull').each(function () {
            $(this).PullDown();
        })
    })
})(window.jQuery);