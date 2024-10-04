$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $("#sortable").sortable();
    $("#sortable").disableSelection();
    $(".toggle-active").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        $(this).parent().toggleClass("unactive");
        $(this).next().val($(this).next().val() == '1' ? 0 : 1);
    });
})
