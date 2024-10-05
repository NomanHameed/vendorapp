<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/colorbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}?v=1.1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="bg-light mt-5 py-5">
    <div class="bg_color_loder">
        <div class="loader"></div>
    </div>
    @include('partials.header')
    <div class="container">
        @yield('content')
    </div>
    <script>
//        var shop = "
<?php
// echo $_GET['shop'] ?? $_POST['shop']
?>
// ";

        // var links = document.getElementsByTagName('a');
        // for(var i = 0; i< links.length; i++){
        //     var href = links[i].href + (links[i].href.indexOf('?') != -1 ? "&" : "?") + "shop="+shop
        //     links[i].setAttribute('href', href);
        // }
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- <script src="{{ asset('js/jquery.colorbox.js') }}"></script> -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.tiny.cloud/1/sod2yr6cboapswfwqzlg6fgvwdk5d3wpggddhbnc2zsp9h56/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/app-script.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        /**
        $(function() {
            $("a:not(.view-product)").attr('href', function(i, h) {
                return h + (h.indexOf('?') != -1 ? "&" : "?") + "shop="+shop;
            });
            if ($('form').length) {
                $('form').each(function() {
                    $(this).prepend('<input type="hidden" name="shop" value="' + shop + '">');
                });
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            tinymce.init({
                selector: 'textarea.tinymce-editor',
                height: 300,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount', 'image'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css'
            });

        });
        **/
    </script>
    <script src="{{ asset('js/category.js') }}?v=1.7"></script>
    @yield('pageScript')
</body>

</html>
