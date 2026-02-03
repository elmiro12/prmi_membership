    $(document).ready(function () {
        tinymce.init({
            selector: 'textarea#isi',
            height: 400,
            base_url: '/vendor/tinymce',
            suffix: '.min',
            skin_url: '/vendor/tinymce/skins/ui/oxide',
            content_css: '/vendor/tinymce/skins/content/default/content.css',

            // AGAR LINK FILE GAMBAR BENAR
            relative_urls: false,
            remove_script_host: false,
            plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'media', 'charmap', 'preview', 'anchor',
            'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'code','help','wordcount',
            'codesample'
            ],
            toolbar: ['undo redo | blocks fontsize | ' +
                    'bold italic underline forecolor backcolor | ',
                    'alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | ' +
                    'link image media codesample | ' +
                    'removeformat preview code'],
            menubar: false,
            branding: false,
            paste_as_text: true,
            images_upload_url: '{{ route("upload-image") }}', // endpoint Laravel
            automatic_uploads: true,
            images_upload_credentials: true,

            file_picker_types: 'image',
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function () {
                    const file = this.files[0];
                    const formData = new FormData();
                    formData.append('file', file);

                    fetch('/upload-image', {
                        method: 'POST',
                        headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(result => {
                        callback(result.location); // lokasi URL file gambar
                    })
                    .catch(error => {
                        console.error('Upload error:', error);
                        alert('Upload gagal!'+ error.message);
                    });
                    };

                    input.click();
                }
            },
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save(); // agar isi TinyMCE disalin ke textarea saat form submit
                });
            }
        });

        // Validasi manual agar error tidak muncul saat textarea hidden
        document.querySelector('form').addEventListener('submit', function (e) {
            const isi = tinymce.get('isi').getContent({ format: 'text' }).trim();
            if (isi === '') {
            alert('Isi pengumuman tidak boleh kosong.');
            e.preventDefault();
            tinymce.get('isi').focus();
            }
        });

    });
