$(function(){
    let headerHeight = $("header").outerHeight(),
        headerHeight_Big = 75,
        categoryHeight = $(".category").outerHeight(),
        userInfoHeight = $(".user_info").outerHeight(),
        _window = $(window),
        windowHeight = $(window).height(),
        baseFontSize = "16px",
        containerMarginRight = parseInt($(".container").css("margin-right"), 10);

        console.log(containerMarginRight);

    // Header =============================================================
    _window.resize(function() {
        if(_window.width() <= 425) {
            $("header h1").text("MP");
            $("header h1").css({
                "font-size": baseFontSize,
                "margin-bottom": 20
            });
        } else {
            $("header h1").text("My Passwords");
            $("header h1").css({
                "font-size": 26,
                "margin-bottom": 0
            });
        }
    });

    $(".user_info_dropdown").css("top", headerHeight);

    // Global Nav =============================================================
    $("nav").css("padding-top", $("header").outerHeight());

    $(".hamburger").click(function() {
        $("nav").toggleClass("fullWidth");
        $(this).toggleClass("active");
    });

    _window.resize(function() {
        if(_window.width() <= 425) {
            $(".hamburger").css({
                "left": containerMarginRight,
                "top" : 30
            });
        } else {
            $(".hamburger").css({
                "left": 10,
                "top" : 20
            });
        }
    });

    // User Info =============================================================
    _window.resize(function() {
        if (_window.width() <= 425) {
            $(".user_info p").css("display", "none");
            $(".user_info .fa-caret-down").css("margin-left" , 0);
            $(".user_info_dropdown").css("top" , -50);
        } else {
            $(".user_info p").css("display", "inline-block");
            $(".user_info .fa-caret-down").css("margin-left" , 10);
        }
    });

    // Body =============================================================
    _window.resize(function() {
        if(_window.width() <= 768) {
            $("main").css("margin-top", headerHeight);
        } else {
            $("main").css("margin-top", headerHeight_Big);
        }
    });
    if(_window.width() > 768) {
        $("main").css("margin-top", headerHeight_Big);
    }
    $("ul.items").css("margin-top", categoryHeight);

    // Modal =============================================================
    $(".js_modal_open").click(function(){
        $("#modal_newItem").fadeIn();
    });

    $(".js_modal_close").click(function(){
        $(".modal").fadeOut();
    });

    $(".js_modal_add").click(function(){
        $(".modal").fadeOut();
    });

    $(".edit_btn").click(function() {
        $("#modal_editItem").fadeIn();
    });

    $(".showPw").click(function(){
        $(this).toggleClass("closePw");
        let input = $(this).prev("input");
        if(input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    // User Info =============================================================
    $(".user_info_open").click(function() {
        $(".user_info_dropdown").toggleClass("open");
    });

    // Purge Button =============================================================
    $("input[type='checkbox']").click(function() {
        $(this).parent().parent().toggleClass("checked");
        $(this).parent().toggleClass("checked_bg");
        let check_count = $(".item :checked").length;
        if (check_count > 0) {
            $(".purge").fadeIn();
        } else {
            $(".purge").fadeOut();
        }

        $(".purge").click(function() {
            $(this).fadeOut();
        });
    });

    // Search =============================================================
    $("input#search").quicksearch(".item");
});