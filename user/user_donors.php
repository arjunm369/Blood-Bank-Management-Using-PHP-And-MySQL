<?php
include("user_header.php");

$donation_id = isset($_GET['donation']) ? intval($_GET['donation']) : 0;
if ($donation_id) {
    $stmt = executeQuery($con, "INSERT INTO tbl_request(reciever_id, sender_id, request_date, request_status) VALUES(?, ?, CURDATE(), 'Added')", "ii", array($donation_id, $sid));
    if ($stmt) {
        $stmt->close();
        $_SESSION['flash_message'] = "Donation Request Added Successfully";
        header("location:user_history.php");
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
                <li class="breadcrumb-item active">Donors</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Donors Info</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Blood Group</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Contact Number</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $donors = getRows($con, "SELECT * FROM tbl_donation a INNER JOIN tbl_user b ON a.user_id=b.user_id WHERE a.user_id<>? AND donation_status='Submitted'", "s", array($sid));
                                $i = 0;

                                foreach ($donors as $don_data) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i;?></th>
                                        <td><?php echo htmlspecialchars($don_data['user_name']);?></td>
                                        <td><?php echo htmlspecialchars($don_data['user_bgroup']);?></td>
                                        <td><?php echo htmlspecialchars($don_data['user_email']);?></td>
                                        <td><?php echo htmlspecialchars($don_data['user_phone']);?></td>
                                        <td><a href="user_donors.php?donation=<?php echo $don_data['donation_id'];?>" class="btn btn-sm btn-info">Request</a>
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
