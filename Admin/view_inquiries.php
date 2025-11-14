<?php
include 'connection.php';
include 'session.php';
?>
<!doctype html>
<html lang="en" class="semi-dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KRISHNA CAR PARTS</title>
    <!--favicon-->
    <link rel="icon" href="../assets/images/kcp.png" type="image/png" />
    <!--plugins-->
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="../assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="../assets/css/pace.min.css" rel="stylesheet" />
    <script src="../assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="../assets/css/app.css" rel="stylesheet">
    <link href="../assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="../assets/css/dark-theme.css" />
    <link rel="stylesheet" href="../assets/css/semi-dark.css" />
    <link rel="stylesheet" href="../assets/css/header-colors.css" />
</head>
<body>
<div class="wrapper">
    <!--sidebar wrapper -->
    <?php include 'sidebar.php' ?>
    <!--end sidebar wrapper -->
    <!--start header -->
    <?php include 'header.php' ?>
    <!--end header -->

    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User Inquiries</div>
            </div>

            <!-- Handle Delete -->
            <?php
            if(isset($_POST['delete_btn'])){
                $did = intval($_POST['delete_id']);
                $res = mysqli_query($conn,"DELETE FROM inquiries_tbl WHERE id='$did'");
                if($res){
                    echo '<div class="alert alert-success">Inquiry deleted successfully!</div>';
                }
            }

            // Handle Reply
            if(isset($_POST['reply_btn'])){
                $rid = intval($_POST['reply_id']);
                $reply_text = mysqli_real_escape_string($conn, $_POST['reply_message']);
                $res = mysqli_query($conn,"UPDATE inquiries_tbl SET reply='$reply_text', status='Resolved' WHERE id='$rid'");
                if($res){
                    echo '<div class="alert alert-success">Reply sent successfully!</div>';
                    // Optionally, send email to user
                    $user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT email, subject FROM inquiries_tbl WHERE id='$rid'"));
                    $to = $user['email'];
                    $subject = "Reply from Krishna Car Parts";
                    $message = "Hello,\n\nYour inquiry subject: ".$user['subject']."\n\nOur reply:\n".$reply_text."\n\nRegards,\nKrishna Car Parts Team";
                    // mail($to,$subject,$message); // Uncomment if mail() configured
                }
            }
            ?>

            <h6 class="mb-0 text-uppercase">All User Inquiries</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="inquiriesTable" class="table " style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Reply</th>
                                    <th>Status</th>
                                    <th>Date & Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cnt=1;
                                $res = mysqli_query($conn,"SELECT * FROM inquiries_tbl ORDER BY created_at DESC");
                                while($row=mysqli_fetch_assoc($res)){
                                    echo "<tr>
                                            <td>{$cnt}</td>
                                            <td>".htmlspecialchars($row['name'])."</td>
                                            <td>".htmlspecialchars($row['email'])."</td>
                                            <td>".htmlspecialchars($row['subject'])."</td>
                                            <td>".substr(htmlspecialchars($row['message']),0,50)."...</td>
                                            <td>".($row['reply'] ? substr(htmlspecialchars($row['reply']),0,50)."..." : "-")."</td>
                                            <td>
                                                <span class='badge bg-".($row['status']=='Resolved'?'success':'warning text-dark')."'>".$row['status']."</span>
                                            </td>
                                            <td>{$row['created_at']}</td>
                                            <td>
                                                <button class='btn btn-info btn-sm btnView' data-message='".htmlspecialchars($row['message'],ENT_QUOTES)."' data-subject='".htmlspecialchars($row['subject'],ENT_QUOTES)."' data-bs-toggle='modal' data-bs-target='#viewModal'>View</button>
                                                <button class='btn btn-success btn-sm btnReply' data-id='{$row['id']}' data-bs-toggle='modal' data-bs-target='#replyModal'>Reply</button>
                                                <button class='btn btn-danger btn-sm btnDelete' data-id='{$row['id']}' data-bs-toggle='modal' data-bs-target='#deleteModal'>Delete</button>
                                            </td>
                                          </tr>";
                                    $cnt++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">Warning!</div>
                <div class="modal-body">Are you sure you want to delete this inquiry?</div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" name="delete_btn" class="btn btn-primary">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Inquiry Details</h5></div>
                <div class="modal-body">
                    <p><strong>Subject:</strong> <span id="viewSubject"></span></p>
                    <p><strong>Message:</strong></p>
                    <p id="viewMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Reply to Inquiry</h5></div>
                <div class="modal-body">
                    <form method="post">
                        <input type="hidden" name="reply_id" id="reply_id">
                        <textarea name="reply_message" class="form-control" rows="5" placeholder="Type your reply..." required></textarea>
                        <button type="submit" name="reply_btn" class="btn btn-success mt-3">Send Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>
</div>
<!--end wrapper-->

<!-- Bootstrap JS -->
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="../assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<!--app JS-->
<script src="../assets/js/app.js"></script>
<script>
$(document).ready(function(){
    $('#inquiriesTable').DataTable();

    // Delete modal
    $('.btnDelete').click(function(){
        var id = $(this).data('id');
        $('#delete_id').val(id);
    });

    // View modal
    $('.btnView').click(function(){
        var subject = $(this).data('subject');
        var message = $(this).data('message');
        $('#viewSubject').text(subject);
        $('#viewMessage').text(message);
    });

    // Reply modal
    $('.btnReply').click(function(){
        var id = $(this).data('id');
        $('#reply_id').val(id);
    });
});
</script>
</body>
</html>
