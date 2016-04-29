$(document).ready(function () {
    
    $('#dish_file').change(function () {
        $('#dish_setMain_0').prop('disabled', false);
        $('td .light-grey').removeClass('light-grey');
        $('#dish_setMain label').css({color:'red'});
    });
    
});
