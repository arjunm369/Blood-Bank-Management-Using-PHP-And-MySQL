<?php
include("user_header.php");

if (isset($_POST['submit'])) {
  $content = sanitizeInput($_POST['question']);

  $stmt = executeQuery($con, "INSERT INTO tbl_feedback(user_id, feedback_date, feedback_content) VALUES(?, CURDATE(), ?)", "ss", array($sid, $content));
  if ($stmt) { $stmt->close(); }
  header('location:user_feedback.php');
  exit;
}

?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>DROPE OF HOPE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="user_donate.php">User</a></li>
        <li class="breadcrumb-item">Feedback</li>
        <li class="breadcrumb-item active">Add & View</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Feedbacks</h5>
            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Date</th>
                  <th scope="col">Message</th>
                  <th scope="col">Reply</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $results = getRows($con, "SELECT a.*, b.user_name FROM tbl_feedback a INNER JOIN tbl_user b ON a.user_id=b.user_id");
                $i = 0;
                foreach ($results as $data) {
                  $i++;
                ?>

                  <tr>
                    <th scope="row"><?php echo $i; ?></th>
                    <td><?php echo htmlspecialchars($data['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($data['feedback_date']); ?></td>
                    <td><?php echo htmlspecialchars($data['feedback_content']); ?></td>
                    <td>
                      <?php
                      if ($data['feedback_reply'] == NULL) {
                      ?>
                        Awaiting Reply
                      <?php
                      } else {
                      ?>
                        <?php echo htmlspecialchars($data['feedback_reply']); ?>
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
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Feedback</h5>
            <!-- Floating Labels Form -->
            <form class="row g-3" method="post">

              <div class="col-md-12">
                <div class="form-floating">
                  <input type="text" class="form-control" name="question" id="feedback" placeholder="enter your feedback" required>
                  <label for="feedback">Enter Feedback</label>
                </div>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </div>
            </form><!-- End floating Labels Form -->
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->




<?php include("user_footer.php"); ?>
