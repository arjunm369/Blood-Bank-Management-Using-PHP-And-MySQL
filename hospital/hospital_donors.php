<?php
include("hospital_header.php");

?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>HemoConnect</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="hospital_donors.php">Hospital</a></li>
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
                                    <th scope="col">Contact Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $donors = getRows($con, "SELECT * FROM tbl_donation a INNER JOIN tbl_user b ON a.user_id=b.user_id WHERE donation_status='Submitted'");
                                $i = 0;

                                foreach ($donors as $don_data) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i;?></th>
                                        <td><?php echo htmlspecialchars($don_data['user_name']);?></td>
                                        <td><?php echo htmlspecialchars($don_data['user_bgroup']);?></td>
                                        <td><?php echo htmlspecialchars($don_data['user_phone']);?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include("hospital_footer.php"); ?>
