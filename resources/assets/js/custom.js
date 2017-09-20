var closeBtn = $(".close.remove");
var deleteBtn = $(".submitDelete");
var closeModal = $('.btn.btn-default');
var successMsg = $('.successMessage');
var errorMsg = $('.errorMessage');
var updateArticles = $('.updateArticles');
var spinnerContainer = $('.spinnerContainer');
var articleBlock = '';
var id = '';
var token = '';


closeBtn.on('click', function(){
    id = $(this).data('id');
    articleBlock = $(this).closest('.articleBlock');
});

deleteBtn.click(function(){
    token = $(this).data('token');

    $.ajax({
        url: 'dashboard/delete/'+id,
        type: 'post',
        data: {_method: 'delete', _token: token},
        success: function (msg) {
            notificationShow(msg);
        },
        error: function (xhr) {
            notificationShow(xhr);
        }
    });
});

function notificationShow(msg){
    var msgType = (msg === '"success"') ? successMsg : errorMsg;
    closeModal.click();
    articleBlock.hide();
    msgType.show().animate({
        top: '50px'
    });
    setTimeout(function(){
        msgType.animate({
            top: '-100px'
        });
    }, 3000);
}

updateArticles.click(function(){
    spinnerContainer.show();
});

