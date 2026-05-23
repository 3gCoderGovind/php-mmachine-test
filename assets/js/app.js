$(document).ready(function () {

    // Bootstrap Modals
    const businessModal = new bootstrap.Modal(document.getElementById('businessModal'));
    const ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'));

    // =========================
    // INIT READONLY RATINGS
    // =========================
    function loadRatings() {

        $('.avg-rating').each(function () {

            // destroy old stars
            $(this).empty();

            $(this).raty({
                readOnly: true,
                half: true,
                score: $(this).attr('data-score'),
                path: 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.1.1/images'
            });
        });
    }

    loadRatings();

    // =========================
    // USER RATING STARS
    // =========================
    $('#userRating').raty({
        half: true,
        path: 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.1.1/images',

        click: function (score) {
            $('#ratingValue').val(score);
        }
    });

    // =========================
    // OPEN ADD MODAL
    // =========================
    $('#addBusinessBtn').click(function () {

        $('#businessForm')[0].reset();

        $('#business_id').val('');

        businessModal.show();
    });

    // =========================
    // SAVE BUSINESS
    // =========================
    $('#businessForm').submit(function (e) {

        e.preventDefault();

        $.ajax({
            url: 'ajax/business_save.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',

            success: function (response) {

                if (response.status) {

                    let data = response.data;

                    let row = `
                    <tr id="row-${data.id}">

                        <td>${data.id}</td>

                        <td>${data.name}</td>

                        <td>${data.address}</td>

                        <td>${data.phone}</td>

                        <td>${data.email}</td>

                        <td>
                            <div
                                class="avg-rating pointer"
                                id="avg-rating-${data.id}"
                                data-id="${data.id}"
                                data-score="${data.avg_rating}">
                            </div>
                        </td>

                        <td>

                            <button
                                class="btn btn-sm btn-warning edit-btn"
                                data-id="${data.id}">
                                Edit
                            </button>

                            <button
                                class="btn btn-sm btn-danger delete-btn"
                                data-id="${data.id}">
                                Delete
                            </button>

                        </td>

                    </tr>
                    `;

                    // update existing row
                    if ($('#row-' + data.id).length) {

                        $('#row-' + data.id).replaceWith(row);

                    } else {

                        // add new row
                        $('#businessTable').prepend(row);
                    }

                    loadRatings();

                    businessModal.hide();
                }
            },

            error: function () {
                alert('Something went wrong');
            }
        });
    });

    // =========================
    // EDIT BUSINESS
    // =========================
    $(document).on('click', '.edit-btn', function () {

        let id = $(this).data('id');

        $.ajax({
            url: 'ajax/business_get.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',

            success: function (data) {

                $('#business_id').val(data.id);
                $('#name').val(data.name);
                $('#address').val(data.address);
                $('#phone').val(data.phone);
                $('#email').val(data.email);

                businessModal.show();
            },

            error: function () {
                alert('Unable to fetch business');
            }
        });
    });

    // =========================
    // DELETE BUSINESS
    // =========================
    $(document).on('click', '.delete-btn', function () {

        if (!confirm('Are you sure want to delete?')) {
            return;
        }

        let id = $(this).data('id');

        $.ajax({
            url: 'ajax/business_delete.php',
            type: 'POST',
            data: { id: id },
            dataType: 'json',

            success: function (response) {

                if (response.status) {

                    $('#row-' + id).remove();
                }
            },

            error: function () {
                alert('Delete failed');
            }
        });
    });

    // =========================
    // OPEN RATING MODAL
    // =========================
    $(document).on('click', '.avg-rating', function () {

        let business_id = $(this).data('id');

        $('#ratingForm')[0].reset();

        $('#rating_business_id').val(business_id);

        $('#ratingValue').val(0);

        $('#userRating').raty('score', 0);

        ratingModal.show();
    });

    // =========================
    // SAVE RATING
    // =========================
    $('#ratingForm').submit(function (e) {

        e.preventDefault();

        $.ajax({
            url: 'ajax/rating_save.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',

            success: function (response) {

                if (response.status) {

                    let business_id = $('#rating_business_id').val();

                    let ratingDiv = $('#avg-rating-' + business_id);

                    ratingDiv.attr('data-score', response.avg_rating);

                    loadRatings();

                    ratingModal.hide();
                }
            },

            error: function () {
                alert('Rating save failed');
            }
        });
    });

});