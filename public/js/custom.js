$(document).ready(function () {
    setTimeout(function () {
        $("#successMessage").fadeOut();
    }, 3000);
    $('.btn-delete').on('click', function () {
        var tripId = $(this).data('trip-id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '/trip/delete/' + tripId,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (data) {
                        Swal.fire('Deleted!', 'Your data has been deleted.', 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function (error) {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting the data.', 'error');
                    }
                });
            }
        });
    });

});

// function openNav() {
//     $("#sidebar").css("width", "250px");
//     $("#main").css("margin-left", "250px");
// }

// function closeNav() {
//     $("#sidebar").css("width", "0");
//     $("#main").css("margin-left", "0");
// }

// function toggleCheckboxes(checkbox) {
//     var otherCheckbox = checkbox.id === 'admin' ? $('#user') : $('#admin');
//     otherCheckbox.prop('disabled', checkbox.checked);
// }
