// $.noConflict();

jQuery(document).ready(function ($) {    
    $(".bg_color_loder").addClass('d-none');

    $('a:not(a[data-loader=0])').click(showLoader);
    $('form').submit(showLoader);
    $(document).ajaxError(hideLoader);
    $(document).ajaxComplete(hideLoader);

    function hideLoader(){
        $(".bg_color_loder").addClass('d-none');
    }
    function showLoader(){
        $(".bg_color_loder").removeClass('d-none');
    }

    $("#checkAll").change(function () {
        $(".sscheck:checkbox:not(.sscheck:disabled)").prop('checked', $(this).prop("checked"));
    });

    $(".sscheck, #checkAll").change(function () {        
        if($(".sscheck:checked").length){
            $('#selected-bar').show();
        } else {
            $('#selected-bar').hide();
        }
        $('#selected-itms').text($(".sscheck:checked").length + ' Selected');
    });

    $('#import-selected').click(function(e){
        e.preventDefault();
        $(this).prop('disabled', true);
        var searchIDs = $(".sscheck:checked").map(function(){
          return $(this).val();
        }).get();
        console.log(searchIDs);
        if(searchIDs.length == 0){
            swal("", "No selection to import", "error");
            hideLoader();
            return;
        }

        var data = {import: searchIDs};
        var url = $(this).attr('href');
        $.post(url, data, function(result){
            $('#import-selected').prop('disabled', false);
            if(result.success){
                $('#selected-bar').hide();
                swal("Success", result.msg, "success");
                $.each(result.imports, function(pid, prod){
                    
                    var row = '.pid-' + pid;
                    console.log('row', row);
                    $(row + ' .sscheck').prop('disabled', true).prop('checked', false);

                    $(row + ' a.product-import i').attr('class', 'fa fa-eye');
                    $(row + ' a.product-import').attr('target', '_blank')
                    .attr('href', 'https://scarletbrandingshop.myshopify.com/admin/products/'+prod.product.id)
                    .attr('class', 'btn text-white bg-success btn-sm view-product');

                });
            } else {
                swal("", result.msg, "error");
            }
        });
    });




    $(document).on('click', '.product-import', function (e) {
        e.preventDefault();
        
        $(this).find('i').attr('class', 'fa fa-spinner fa-pulse');
        $(this).addClass('disabled');

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            dataType: "json",
            success: (res) => {
                $(this).removeClass('disabled');
                
                if(res.hasOwnProperty('product')){
                    $(this).find('i').attr('class', 'fa fa-check');
                    $(this).attr('target', '_blank')
                    .attr('href', 'https://'+shop+'/admin/products/'+res.product.id)
                    .attr('class', 'btn text-white bg-success btn-sm view-product');
                    
                    $(this).parents(':eq(1)').find('.sscheck')
                            .prop('disabled', true)
                            .prop('checked', false);

                    setTimeout(() => {
                        $(this).find('i').attr('class', 'fa fa-pencil');
                    }, 1500);

                } else {
                    $(this).find('i').attr('class', 'fa fa-plus');
                    if(!res.hasOwnProperty('success')){
                        swal ("", "Something went wrong! Please try later", "error");
                    } else {
                        swal ("", res.msg, "error");
                    }
                }
            },
            error: () => {
                $(this).removeClass('disabled');
                $(this).find('i').attr('class', 'fa fa-plus');
                swal("", "There was an error with the request", "error");
            }
        });
    });



    $('form[data-ajaxsave]').on('submit', function(e){
        e.preventDefault();
        console.log('submit')

        // var btn = $("button[type=submit][clicked=true]");
        var btn = $(this).find("button[type=submit]:focus" )
        var btnlabel = btn.text();
            btn.prop('disabled', true);
            btn.text(btnlabel + "...");


          $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $('form').serialize(),
            success: function (response) {                
                btn.text(btnlabel);
                btn.prop('disabled', false);
                
                swal("", response.msg, (response.success ? "success" : "error"));
            },
            error: function(){
                btn.text(btnlabel);
                btn.prop('disabled', false);
                swal("ERROR", "Something went wrong! try later", "error");
            }
          });
    })



});