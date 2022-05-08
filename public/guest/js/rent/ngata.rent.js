class Rent {
    constructor () {
        this.loaderOnSubmit = function(className, formbtn)  {
            $('.' + className).on('submit', function(e){
                // e.preventDefault();
                $.message.warning({
                    message: "<span class='fa fa-circle-o-notch fa-spin'></span> &nbsp;Please wait... a page will response soon",
                    duration: 5000
                });
            })
        }


        this.imageSlider = () => {
            $('.thumbnail img').on('click', function(){
                var src = $(this).attr('src');
                $(this).addClass('active').siblings().removeClass('active');
                $(".preview img").hide();
                $('.preview img').attr('src', src).fadeIn();

            })

            $('.prev-btn').on('click', function() {
                var prevSRC = $('.thumbnail img.active').prev().attr('src');
                $('.thumbnail img.active').prev().addClass('active').siblings().removeClass('active')
                $(".preview img").hide();
                $('.preview img').attr('src', prevSRC).fadeIn();
                
            })

            $('.next-btn').on('click', function() {
                var nextSRC = $('.thumbnail img.active').next().attr('src');
                $('.thumbnail img.active').next().addClass('active').siblings().removeClass('active')
                $(".preview img").hide();
                $('.preview img').attr('src', nextSRC).fadeIn();
            })    
        }
        
        
    }
}
var obj = new Rent();
obj.loaderOnSubmit('searchForm', 'search-btn');
obj.imageSlider();



