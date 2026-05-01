<?php
include("user_header.php");
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>DROPE OF HOPE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="user_donate.php">User</a></li>
        <li class="breadcrumb-item">Ambulance</li>
        <li class="breadcrumb-item active">View</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ambulance Info</h5>
            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Photo</th>
                  <th scope="col">Name</th>
                  <th scope="col">Type</th>
                  <th scope="col">Contact Number</th>
                  <th scope="col">Register Number</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $ambulances = getRows($con, "SELECT * FROM tbl_ambulance");
                $i = 0;
                foreach ($ambulances as $data) {
                  $i++;
                ?>

                  <tr>
                    <th scope="row"><?php echo $i;?></th>
                    <td><img src="../asset_dashboard/file_uploads/<?php echo htmlspecialchars($data['ambulance_photo']);?>" height="55" width="45"></td>
                    <td><?php echo htmlspecialchars($data['ambulance_name']);?></td>
                    <td><?php echo htmlspecialchars($data['ambulance_type']);?></td>
                    <td><?php echo htmlspecialchars($data['ambulance_contact']);?></td>
                    <td><?php echo htmlspecialchars($data['ambulance_regno']);?></td>
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

</main><!-- End #main -->




<?php include("user_footer.php"); ?>
