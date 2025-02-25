$('#userForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: 'process.php',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            //console.log("Response dari server:", response);

            if (response.status === 'success') {
                $('#response').html('<p style="color:green;">' + response.message + '</p>');
                $('#userForm')[0].reset();
            } else {
                let errors = '<ul style="color:red;">';
                $.each(response.errors, function (key, value) {
                    errors += '<li>' + value + '</li>';
                });
                errors += '</ul>';
                $('#response').html(errors);
            }
        },
        error: function (xhr, status, error) {
            //console.log("AJAX Error:", xhr.responseText);
            $('#response').html('<p style="color:red;">Terjadi kesalahan saat mengirim data.</p>');
        }
    });
});
