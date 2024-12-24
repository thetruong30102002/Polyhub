<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="dark" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <script src="https://cdn.tiny.cloud/1/ucbbhja701oxqnbdgr0j3pabzgks4lk6simsn0047qsyv61m/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <link
    rel="shortcut icon"
    type="image/png"
    href="{{ asset('storage/images/logos/favicon.png') }}"
    />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

    <title>Spike Bootstrap Admin</title>
    <!-- jvectormap  -->
    <link rel="stylesheet" href="{{ asset('assets/libs/jvectormap/jquery-jvectormap.css') }}">
</head>
<body>
    @include('Backend.components.preloader')

    <div id="main-wrapper">
        @include('Backend.includes.sidebar_1')

        <div class="page-wrapper">
            @include('Backend.includes.sidebar_2')

            <div class="body-wrapper">
                <div class="container-fluid">
                    @include('Backend.includes.header')

                    @yield('content')
                </div>
            </div>
            <script>
                function handleColorTheme(e) {
                $("html").attr("data-color-theme", e);
                $(e).prop("checked", !0);
                }
            </script>

            @include('Backend.components.setting_button')

            @include('Backend.components.customize_layout_table')
        </div>

        <div class="dark-transparent sidebartoggler"></div>
    </div>

    

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- Import Js Files -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.dark.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/theme/feather.min.js') }}"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('assets/libs/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/extra-libs/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards/dashboard.js') }}"></script>

    <script>
tinymce.init({
    selector: '#mytextarea',
    apiKey: 'ucbbhja701oxqnbdgr0j3pabzgks4lk6simsn0047qsyv61m',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker code',
    toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image media link | code',
    height: 400,
    content_style: `
        body { font-family:Helvetica,Arial,sans-serif; font-size:14px; }
        img { width: 500px; height: auto; }
      `,
    image_caption: true,
    image_advtab: true,
    media_live_embeds: true,
    automatic_uploads: true,
    init_instance_callback: function (editor) {
      editor.on('NodeChange', function (e) {
      editor.contentDocument.querySelectorAll('img').forEach(img => {
      img.style.width = '500px'; // Kích thước cố định
      img.style.height = 'auto';
    });
  });
},

setup: function (editor) {
  editor.on('BeforeSetContent', function (e) {
    // Xử lý kích thước ảnh trước khi thiết lập nội dung
    e.content = e.content.replace(/<img([^>]+)>/g, function (match, p1) {
      return `<img ${p1} style="width: 500px; height: auto;" />`;
    });
  });
},
file_picker_callback: function (callback, value, meta) {
    if (meta.filetype === 'image') {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.onchange = function () {
            var file = this.files[0];
            var formData = new FormData();
            formData.append('file', file);

            // Gửi yêu cầu AJAX tới server
            fetch('/admin/blog/upload_image', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(result => {
                // Chèn URL tuyệt đối vào nội dung và thêm style
                callback(result.location, {
                    alt: file.name,
                    style: 'width: 500px; height: auto;'
                });
            })
            .catch(error => {
                console.error('Error uploading image:', error);
            });
        };
        input.click();
    }
},
    relative_urls: false,  // Tắt relative URLs
    remove_script_host: false,  // Giữ lại hostname
    document_base_url: 'http://localhost:8000/'
});
    </script>
</body>
</html>