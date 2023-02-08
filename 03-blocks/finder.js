// focus on label with checkbox, not just checkbox
function itemFocus(event) {
    if(event.target) event.target.parentNode.classList.add("focus");
}
function itemBlur(event) {
    if(event.target) event.target.parentNode.classList.remove("focus");
}
window.addEventListener('load', function load(event) {
    var itemList = document.querySelectorAll('div.search-filters form input');
    for(var i = 0; i < itemList.length; i++) {
        var item = itemList[i];
        item.addEventListener('focus', itemFocus, true);
        item.addEventListener('blur', itemBlur, true);
    }
}, false);
// search
jQuery(function($){
    $('#filter').submit(function(){
        var filter = $('#filter');
        $.ajax({
            url:filter.attr('action'),
            data:filter.serialize(), // form data
            type:filter.attr('method'), // POST
            beforeSend:function(xhr){
                filter.find('button').text('Processing...'); // changing the button label
            },
            success:function(data){
                filter.find('button').text('Apply filter'); // changing the button label back
                $('#stmu-results').html(data); // insert data
            }
        });
        return false;
    });
});