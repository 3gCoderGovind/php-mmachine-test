<?php
include 'db.php';

$query = "SELECT b.*, ROUND(AVG(r.rating),1) as avg_rating
          FROM businesses b
          LEFT JOIN ratings r ON b.id = r.business_id
          GROUP BY b.id
          ORDER BY b.id DESC";

$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Business Rating System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
        }

        .pointer {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Business Listing</h2>

        <button class="btn btn-primary" id="addBusinessBtn">
            Add Business
        </button>
    </div>

    <table class="table table-bordered table-striped bg-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>Business Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Average Rating</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody id="businessTable">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>

            <tr id="row-<?php echo $row['id']; ?>">

                <td><?php echo $row['id']; ?></td>

                <td><?php echo $row['name']; ?></td>

                <td><?php echo $row['address']; ?></td>

                <td><?php echo $row['phone']; ?></td>

                <td><?php echo $row['email']; ?></td>

                <td>
                    <div
                        class="avg-rating pointer"
                        id="avg-rating-<?php echo $row['id']; ?>"
                        data-id="<?php echo $row['id']; ?>"
                        data-score="<?php echo $row['avg_rating'] ? $row['avg_rating'] : 0; ?>">
                    </div>
                </td>

                <td>
                    <button
                        class="btn btn-sm btn-warning edit-btn"
                        data-id="<?php echo $row['id']; ?>">
                        Edit
                    </button>

                    <button
                        class="btn btn-sm btn-danger delete-btn"
                        data-id="<?php echo $row['id']; ?>">
                        Delete
                    </button>
                </td>

            </tr>

        <?php } ?>

        </tbody>
    </table>
</div>

<!-- Business Modal -->
<div class="modal fade" id="businessModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="businessForm">

                <div class="modal-header">
                    <h5 class="modal-title">Business Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="id" id="business_id">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Address</label>
                        <textarea name="address" id="address" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rating Modal -->
<div class="modal fade" id="ratingModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="ratingForm">

                <div class="modal-header">
                    <h5 class="modal-title">Submit Rating</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="business_id" id="rating_business_id">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Rating</label>
                        <div id="userRating"></div>
                        <input type="hidden" name="rating" id="ratingValue">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Submit Rating
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raty/3.1.1/jquery.raty.js"></script>

<script src="assets/js/app.js"></script>

</body>
</html>
