<?php
include("user_header.php");

if (isset($_GET['accept'])) {
    $request_id = intval($_GET['accept']);

    $donation_d = getRow($con, "SELECT * FROM tbl_request WHERE request_id=?", "i", array($request_id));
    $donation_id = $donation_d['reciever_id'];

    if ($donation_id != NULL) {
        $stmt = executeQuery($con, "UPDATE tbl_request SET request_status='Confirmed', donation_date=CURDATE() WHERE request_id=?", "i", array($request_id));
        if ($stmt) { $stmt->close(); }

        $stmt2 = executeQuery($con, "UPDATE tbl_donation SET last_donation_date=CURDATE(), donation_status='Not Submitted' WHERE donation_id=?", "i", array($donation_id));
        if ($stmt2) { $stmt2->close(); }

        $_SESSION['flash_message'] = "Donated Successfully";
        header('location:user_history.php');
        exit;
    }
}

?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>DROPE OF HOPE</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="user_donate.php">User</a></li>
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Requests</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Incoming Requests</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Blood Group</th>
                                    <th scope="col">Request Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $donors = getRows($con, "SELECT * FROM tbl_request a 
                                INNER JOIN tbl_donation b ON a.reciever_id=b.donation_id 
                                INNER JOIN tbl_user c ON a.sender_id=c.user_id 
                                WHERE request_status='Added' AND b.user_id=?", "s", array($sid));
                                $i = 0;
                                foreach ($donors as $data) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo htmlspecialchars($data['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($data['user_bgroup']); ?></td>
                                        <td><?php echo htmlspecialchars($data['request_date']); ?></td>
                                        <td>
                                        <a href="user_requests.php?accept=<?php echo $data['request_id']; ?>" class="btn btn-sm btn-success">Accept</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include("user_footer.php"); ?>
