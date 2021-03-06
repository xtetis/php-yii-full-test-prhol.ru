



/**
 * Нажата кнопка "Сгенерировать яблоко"
 */
//============================================================================
function genApple() {
    $.post("/test/genapple",
        function (obj) {
            if (obj.reload_page) {
                $.pjax.reload({ container: "#pjax_apples_container", url: "/test/index" });
            }
        },
        'json');
}
//============================================================================





/**
 * Нажата кнопка "Удалить все яблоки"
 */
//============================================================================
function delAllApples() {
    $.post("/test/delall",
        function (obj) {
            if (obj.reload_page) {
                $.pjax.reload({ container: "#pjax_apples_container", url: "/test/index" });
            }
        },
        'json');
}
//============================================================================


/**
 * Нажата кнопка "Удалить"
 */
//============================================================================
function delOneApple(idx) {
    $.post("/test/delone", { idx: idx },
        function (obj) {
            if (obj.reload_page) {
                $.pjax.reload({ container: "#pjax_apples_container", url: "/test/index" });
            }
        },
        'json');
}
//============================================================================

/**
 * Нажата кнопка "Упасть на землю"
 */
//============================================================================
function fallToGround(idx) {
    $.post("/test/falltoground", { idx: idx },
        function (obj) {
            if (obj.reload_page) {
                $.pjax.reload({ container: "#pjax_apples_container", url: "/test/index" });
            }
        },
        'json');
}
//============================================================================


/**
 * Откусываем
 */
//============================================================================
function sendEat() {
    var formdata = $("#form_eat")
        .serialize();

    $('.span_error')
        .html('')
        .hide();

    $.post("/test/eat", formdata,
        function (obj) {
            if (obj.reload_page) {
                $.pjax.reload({ container: "#pjax_apples_container", url: "/test/index" });
                $('#modal_eat').modal('hide');
            }
        },
        'json');
}
//============================================================================




/**
 * Показываем ошибку
 */
//============================================================================
function showErrorAlertTop(message) {
    $('#error_alert_top').html(message);
    $('#error_alert_top').show();
    setTimeout(function request() {
        $('#error_alert_top').hide('slow');
    }, 4000);
}
//============================================================================


/**
 * Показываем сообщение
 */
//============================================================================
function showMessageAlertTop(message) {
    $('#message_alert_top').html(message).show();
    setTimeout(function request() {
        $('#message_alert_top').hide('slow');
    }, 4000);
}
//============================================================================


$(function () {
    /**
     * Нажата кнопка "Сгенерировать яблоко"
     */
    //============================================================================
    $(document)
        .on("click", '#btn__gen_apple', function (event) {
            genApple();
        });
    //============================================================================


    /**
     * Нажата кнопка "Удалить все яблоки"
     */
    //============================================================================
    $(document)
        .on("click", '#btn__del_all_apples', function (event) {
            delAllApples();
        });
    //============================================================================



    /**
     * Нажата кнопка "Удалить"
     */
    //============================================================================
    $(document)
        .on("click", '#btn__del_one_apple', function (event) {
            delOneApple($(this).attr('idx'));
        });
    //============================================================================


    /**
     * Нажата кнопка "Упасть на землю"
     */
    //============================================================================
    $(document)
        .on("click", '#btn__fall_to_ground', function (event) {
            fallToGround($(this).attr('idx'));
        });
    //============================================================================

    /**
     * Нажата кнопка "Упасть на землю"
     */
    //============================================================================
    $(document)
        .on("click", '#btn__send_eat', function (event) {
            sendEat();
        });
    //============================================================================


    /**
     * Нажата кнопка "Съесть" - показываем модалку
     */
    //============================================================================
    $(document)
        .on("click", '#btn__modal_eat', function (event) {
            $('#apple_slider').val(0);
            $('#apple_slider_value').html('0');
            $('#eat_idx').val($(this).attr('idx'))
            $('#modal_eat').modal('show');
        });
    //============================================================================

    // Изменение бегунка
    //============================================================================
    $(document).on('input', '#apple_slider', function () {
        $('#apple_slider_value').html($(this).val());
    });
    //============================================================================


    // Показываем ошибки в модалке
    //============================================================================
    $(document).ajaxError(function (event, xhr) {
        if (xhr.status == 200) {
            showMessageAlertTop(xhr.responseText);
        }
        else {
            showErrorAlertTop(xhr.responseText);
        }
    });
    //============================================================================

});