$(function() {
    var txt = $('#content'),
        hiddenDiv = $(document.createElement('div')),
        content = null;

    hiddenDiv.addClass('hiddendiv');

    $('body').append(hiddenDiv);

    txt.on('keyup', function() {

        content = $(this).val();

        content = content.reaplce(/\n/g, '<br />');
        hiddenDiv.html(content + '<br />');

        $(this).css('height', hiddenDiv.height());
    });
});