<?php
include("admin_header.php");
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Hemo Connect</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="">Admin</a></li>
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Participants</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Participants Info</h5>
            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Photo</th>
                  <th scope="col">Name</th>
                  <th scope="col">Blood Group</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact Number</th>
                  <th scope="col">Address</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $selq = "select *from tbl_user";
                $row = mysqli_query($con, $selq);
                $i = 0;
                while ($data = mysqli_fetch_array($row)) {
                ?>
                  <tr>
                    <th scope="row"><?php echo $i;?></th>
                    <td><img src="../asset_dashboard/file_uploads/<?php echo $data['user_photo'];?>" height="75" width="60"></td>
                    <td><?php echo $data['user_name'];?></td>
                    <td><?php echo $data['user_bgroup'];?></td>
                    <td><?php echo $data['user_email'];?></td>
                    <td><?php echo $data['user_phone'];?></td>
                    <td><?php echo $data['user_address'];?></td>
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




<?php include("admin_footer.php"); ?>