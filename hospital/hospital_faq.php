<?php
include("hospital_header.php");

if (isset($_POST['submit'])) {
  $reply = sanitizeInput($_POST['reply']);
  $faq_id = intval($_POST['feed_id']);

  $stmt = executeQuery($con, "UPDATE tbl_faq SET faq_reply=? WHERE faq_id=?", "si", array($reply, $faq_id));
  if ($stmt) { $stmt->close(); }
  header('location:hospital_faq.php');
  exit;
}

?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>HEMOCONNECT</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="hospital_donors.php">Hospital</a></li>
        <li class="breadcrumb-item">FaQ</li>
        <li class="breadcrumb-item active">Reply</li>
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
                  <th scope="col">Reply</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $results = getRows($con, "SELECT a.*, b.user_name FROM tbl_faq a INNER JOIN tbl_user b ON a.user_id=b.user_id");
                $i = 0;
                foreach ($results as $data) {
                  $i++;
                ?>

                  <tr>
                    <th scope="row"><?php echo $i; ?></th>
                    <td><?php echo htmlspecialchars($data['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($data['faq_date']); ?></td>
                    <td><?php echo htmlspecialchars($data['faq_question']); ?></td>
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
                                      <input type="text" class="form-control" name="reply" id="reply" placeholder="add reply" required>
                                      <label for="reply">Enter Reply</label>
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
                        <?php echo htmlspecialchars($data['faq_reply']); ?>
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
