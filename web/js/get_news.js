var timeout_name;
function get_news(name){
    clearTimeout(timeout_name);
    timeout_name = setTimeout(function() {
        $('body').css('cursor','wait');
        $.ajax({
            type:'POST',
            url:$('#mainform').attr('action'),
            data:{
                'name': name.trim()
            },
            'success':function(html){
                $('#grid').html(html);
            },
            'error': function (jqXhr, textStatus, errorMessage) {
                console.log('Ошибка! '+errorMessage);
            },
            'complete': function() {
                $('body').css('cursor','default');
            }
        })
    },500);
}