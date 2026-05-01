<?php
include("user_header.php");
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>DROPE OF HOPE</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="user_donate.php">User</a></li>
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
                        <h5 class="card-title">Your Requests History</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Requested From</th>
                                    <th scope="col">Blood Group</th>
                                    <th scope="col">Request Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $req_history = getRows($con, "SELECT * FROM tbl_request a 
                                INNER JOIN tbl_donation b ON a.reciever_id=b.donation_id 
                                INNER JOIN tbl_user c ON b.user_id=c.user_id 
                                WHERE request_status='Added' AND sender_id=?", "s", array($sid));
                                $i = 0;
                                foreach ($req_history as $rh_data) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo htmlspecialchars($rh_data['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($rh_data['user_bgroup']); ?></td>
                                        <td><?php echo htmlspecialchars($rh_data['request_date']); ?></td>
                                        <td><?php echo htmlspecialchars($rh_data['request_status']); ?></td>
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
                        <h5 class="card-title">Accepted Donations History</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Donated To</th>
                                    <th scope="col">Blood Group</th>
                                    <th scope="col">Request Date</th>
                                    <th scope="col">Donated Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $donors = getRows($con, "SELECT * FROM tbl_request a 
                                INNER JOIN tbl_donation b ON a.reciever_id=b.donation_id 
                                INNER JOIN tbl_user c ON a.sender_id=c.user_id 
                                WHERE request_status='Confirmed' AND sender_id=?", "s", array($sid));
                                $i = 0;
                                foreach ($donors as $data) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo htmlspecialchars($data['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($data['user_bgroup']); ?></td>
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
<?php include("user_footer.php"); ?>
