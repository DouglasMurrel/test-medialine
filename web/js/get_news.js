var timeout_name;
function get_news(name){
    clearTimeout(timeout_name);
    timeout_name = setTimeout(function() {
        get_news_grid(name, 0);
    },500);
}
function get_news_grid(name, page){
    $('body').css('cursor','wait');
    $.ajax({
        type:'POST',
        url:$('#mainform').attr('action'),
        data:{
            'name': name.trim(),
            'page': page,
        },
        'success':function(html){
            $('#grid').html(html);
            $('#page').val(page);
        },
        'error': function (jqXhr, textStatus, errorMessage) {
            console.log('Ошибка! '+errorMessage);
        },
        'complete': function() {
            $('body').css('cursor','default');
        }
    })
}
function show_more(){
    name = $('#tag-name').val();
    page = parseInt($('#page').val());
    get_news_grid(name, page+1);
}