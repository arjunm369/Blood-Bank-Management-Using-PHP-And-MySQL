<?php
include("admin_header.php");
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>DROPE OF HOPE</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_participants.php">Admin</a></li>
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">History</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pending History</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Donor Name</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Blood Group</th>
                                    <th scope="col">Request Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT 
                                    a.*,
                                    b.*,
                                    c.user_name AS c_user_name, 
                                    c.user_bgroup AS c_user_bgroup,
                                    d.user_name AS d_user_name,
                                    d.user_bgroup AS d_user_bgroup
                                FROM tbl_request a 
                                INNER JOIN tbl_donation b ON a.reciever_id=b.donation_id 
                                INNER JOIN tbl_user c ON b.user_id=c.user_id 
                                INNER JOIN tbl_user d ON a.sender_id=d.user_id 
                                WHERE request_status='Added'";
                                $results = getRows($con, $query);
                                $i = 0;
                                foreach ($results as $data) {
                                    $i++;
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <td><?php echo htmlspecialchars($data['c_user_name']); ?></td>
                                            <td><?php echo htmlspecialchars($data['d_user_name']); ?></td>
                                            <td><?php echo htmlspecialchars($data['c_user_bgroup']); ?></td>
                                            <td><?php echo htmlspecialchars($data['request_date']); ?></td>
                                            <td><?php echo htmlspecialchars($data['request_status']); ?></td>
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
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Completed History</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Donor Name</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Blood Group</th>
                                    <th scope="col">Request Date</th>
                                    <th scope="col">Donation Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT 
                                    a.*,
                                    b.*,
                                    c.user_name AS c_user_name, 
                                    c.user_bgroup AS c_user_bgroup,
                                    d.user_name AS d_user_name,
                                    d.user_bgroup AS d_user_bgroup
                                FROM tbl_request a 
                                INNER JOIN tbl_donation b ON a.reciever_id=b.donation_id 
                                INNER JOIN tbl_user c ON b.user_id=c.user_id 
                                INNER JOIN tbl_user d ON a.sender_id=d.user_id 
                                WHERE request_status='Confirmed'";
                                $results = getRows($con, $query);
                                $i = 0;
                                foreach ($results as $data) {
                                    $i++;
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <td><?php echo htmlspecialchars($data['c_user_name']); ?></td>
                                            <td><?php echo htmlspecialchars($data['d_user_name']); ?></td>
                                            <td><?php echo htmlspecialchars($data['c_user_bgroup']); ?></td>
                                            <td><?php echo htmlspecialchars($data['request_date']); ?></td>
                                            <td><?php echo htmlspecialchars($data['donation_date']); ?></td>
                                            <td><?php echo htmlspecialchars($data['request_status']); ?></td>
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
<?php include("admin_footer.php"); ?>
