<?php
include("user_header.php");

if (isset($_POST['submit'])) {
  $question = $_POST['question'];

  $insq = "insert into tbl_faq(user_id,faq_date,faq_question) values('$sid',CURDATE(),'$question')";
  mysqli_query($con, $insq);
  header('location:user_faq.php');
}



?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>DROPE OF HOPE</h1>
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
                  <th scope="col">Reply</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $selq = "select *from tbl_faq a inner join tbl_user b on a.user_id=b.user_id ";
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
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ask FaQ</h5>
            <!-- Floating Labels Form -->
            <form class="row g-3" method="post">

              <div class="col-md-12">
                <div class="form-floating">
                  <input type="name" class="form-control" name="question" id="name" placeholder="enter place name">
                  <label for="floatingEmail">Enter Query</label>
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