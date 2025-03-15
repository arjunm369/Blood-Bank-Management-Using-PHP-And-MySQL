<?php
include("admin_header.php");
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Hemo Connect</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="">User</a></li>
        <li class="breadcrumb-item">FaQ</li>
        <li class="breadcrumb-item active">Add & View</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">FaQs</h5>
            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Date</th>
                  <th scope="col">Query</th>
                  <th scope="col">Reply</th>\
                </tr>
              </thead>
              <tbody>
                <?php
                $selq = "select *from tbl_faq a inner join tbl_user b on a.user_id=b.user_id";
                $row = mysqli_query($con, $selq);
                $i = 0;
                while ($data = mysqli_fetch_array($row)) {
                  $i++;
                ?>

                  <tr>
                    <th scope="row"><?php echo $i; ?></th>
                    <td><?php echo $data['user_name']; ?></td>
                    <td><?php echo $data['faq_date']; ?></td>
                    <td><?php echo $data['faq_question']; ?></td>
                    <td>
                      <?php
                      if ($data['faq_reply'] == NULL) {
                      ?>
                        Awaiting Reply
                      <?php
                      } else {
                      ?>
                        <?php echo $data['faq_reply']; ?>
                      <?php
                      }
                      ?>
                    </td>
                  </tr>
                <?php } ?>
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