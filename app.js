$(function () {
    //メッセージ表示
    var $jsShowMsg = $('#js-show-msg');
    var msg = $jsShowMsg.text();
    if (msg.replace(/\s+/g, "").length) {
        $jsShowMsg.slideToggle('slow');
        setTimeout(function () {
            $jsShowMsg.slideToggle('slow');
        }, 3000);
    }

//画像preview
    var $dropArea = $('.p-FormFile-area-drop');
    var $fileInput = $('.p-FormFile-input-file');

    $dropArea.on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', '3px #CCC dashed');
    });

    $dropArea.on('dragleave', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', 'none');
    });
    $fileInput.on('change', function (e) {
        $dropArea.css('border', 'none');
        var file = this.files[0],
            $img = $(this).siblings('.p-FormFile-prev-img');
        fileReader = new FileReader();

        fileReader.onload = function (event) {

            $img.attr('src', event.target.result).show();

        };
        fileReader.readAsDataURL(file);
    });

//文字数カウント
    var $countup = $('#js-form-text'),
        $countview = $('#js-text-count');
    $countup.on('keyup', function (e) {
        $countview.html($(this).val().length);
    });

//検索BOXに何もないなら送信キャンセ
    var serachbox = $('.js-search'),
        serachBan = $('.js-btn');
    serachBan.on('click', function (e) {
        if (serachbox.val().length === 0) {
            e.preventDefault();
        }
    });


    //


});

