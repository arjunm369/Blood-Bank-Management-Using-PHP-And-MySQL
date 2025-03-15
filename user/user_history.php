<?php
include("user_header.php");
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>DROPE OF HOPE</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">User</a></li>
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
                                $req_history = "select *from tbl_request a 
                                inner join tbl_donation b on a.reciever_id=b.donation_id 
                                inner join tbl_user c on b.user_id=c.user_id 
                                where request_status='Added' and sender_id='$sid'";
                                $rh_row = mysqli_query($con, $req_history);
                                $i = 0;
                                while ($rh_data = mysqli_fetch_array($rh_row)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $rh_data['user_name']; ?></td>
                                        <td><?php echo $rh_data['user_bgroup']; ?></td>
                                        <td><?php echo $rh_data['request_date']; ?></td>
                                        <td><?php echo $rh_data['request_status']; ?></td>
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
                                $donors = "select *from tbl_request a 
                                inner join tbl_donation b on a.reciever_id=b.donation_id 
                                inner join tbl_user c on a.sender_id=c.user_id 
                                where request_status='Confirmed' and sender_id='$sid'";
                                $don_row = mysqli_query($con, $donors);
                                $i = 0;
                                while ($data = mysqli_fetch_array($don_row)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $data['user_name']; ?></td>
                                        <td><?php echo $data['user_bgroup']; ?></td>
                                        <td><?php echo $data['request_date']; ?></td>
                                        <td><?php echo $data['donation_date']; ?></td>
                                        <td><?php echo $data['request_status']; ?></td>
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