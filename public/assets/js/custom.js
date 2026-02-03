  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
      navigator.serviceWorker.register('/service-worker.js')
        .then(reg => console.log('Service Worker registered:', reg))
        .catch(err => console.log('Service Worker registration failed:', err));
    });
  }

  // Global Delete Confirmation Script
  $(document).ready(function () {
      $(document).on('submit', '.form-delete', function (e) {
          e.preventDefault();
          const form = this;
          Swal.fire({
              title: 'Yakin ingin menghapus?',
              text: "Data akan dihapus permanen.",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Ya, hapus!',
              confirmButtonColor: '#dc3545', // Red
              cancelButtonColor: '#6c757d', // Gray
              cancelButtonText: 'Batal'
          }).then((result) => {
              if (result.isConfirmed) {
                  form.submit();
              }
          });
      });
  });