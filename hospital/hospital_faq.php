<?php
include("hospital_header.php");

if (isset($_POST['submit'])) {
  $reply = $_POST['reply'];
  $feed_id = $_POST['feed_id'];

  $insq = "update tbl_faq set faq_reply='$reply' where faq_id='$feed_id'";
  mysqli_query($con, $insq);
  header('location:hospital_faq.php');
}



?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>HEMOCONNECT</h1>
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered<?php echo $data['faq_id'] ?>">
                          Reply
                        </button>
                        <div class="modal fade" id="verticalycentered<?php echo $data['faq_id'] ?>" tabindex="-1">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Add Reply</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form class="row g-3" method="post">
                                  <div class="col-md-12">
                                    <div class="form-floating">
                                      <input type="hidden" class="form-control" name="feed_id" value="<?php echo $data['faq_id'] ?>">
                                      <input type="text" class="form-control" name="reply" id="name" placeholder="add reply" required>
                                      <label for="floatingEmail">Enter Reply</label>
                                    </div>
                                  </div>
                                  <div class="text-center">
                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
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




<?php include("hospital_footer.php"); ?>