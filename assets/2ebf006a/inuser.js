$(function () {
    //Проверить есть ли значение в куках
    user_in = $.cookie('confir');
    if (user_in !== 'true') {
        //Если нет открываем окно
        $(".wrapper").addClass("blur");
        $("#block_confirmation").css('display', 'block');
        $("html,body").css("overflow", "hidden");
    }

    //Отменить все действия с фоном
    block_display = $("#block_confirmation").css('display');
    //Откроем все обработчики
    if (block_display == 'block') {
        $('.wrapper').on('click', function () {
            event.preventDefault();
        });
    }

    //Клик по кнопке принять
    $('.bt_18').click(function () {
        //Запись кука
        $.cookie('confir', 'true', {expires: 360, path: '/'});
        //Закрываем все окна
        $(".wrapper").removeClass("blur");
        $("#block_confirmation").hide();
        $("html,body").css("overflow", "auto");

        //Откроем все обработчики
        $('.wrapper').off();

    });


});