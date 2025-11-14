<?php
include 'connection.php';
session_start();

if (isset($_POST['id']) && isset($_POST['reply'])) {
    $inquiry_id = intval($_POST['id']);
    $reply = mysqli_real_escape_string($conn, $_POST['reply']);

    // Get user email from inquiries_tbl
    $query = "SELECT email, subject FROM inquiries_tbl WHERE id = $inquiry_id";
    $result = mysqli_query($conn, $query);
    $inquiry = mysqli_fetch_assoc($result);

    if ($inquiry) {
        $email = $inquiry['email'];
        $subject = "Reply to your inquiry: " . $inquiry['subject'];

        // ✅ Fix: Use $inquiry_id instead of $id
        $update = "UPDATE inquiries_tbl 
                   SET reply = '$reply', status = 'Resolved' 
                   WHERE id = $inquiry_id";
        mysqli_query($conn, $update);

        // Send email to user
        $headers = "From: kcp.noreply@gmail.com\r\n";
        $headers .= "Reply-To: kcp.noreply@gmail.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $message = "
        <html>
        <body>
            <h2>Dear User,</h2>
            <p>We have responded to your inquiry:</p>
            <blockquote><b>$reply</b></blockquote>
            <p>Thank you for contacting us.</p>
            <br>
            <em>KRISHNA CAR PARTS Support Team</em>
        </body>
        </html>";

        if (mail($email, $subject, $message, $headers)) {
            echo "<script>alert('Reply sent successfully via email.'); window.location='view_inquires.php';</script>";
        } else {
            echo "<script>alert('Failed to send email. But reply saved in system.'); window.location='view_inquires.php';</script>";
        }
    } else {
        echo "<script>alert('Inquiry not found.'); window.location='view_inquires.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='view_inquires.php';</script>";
}
?>
