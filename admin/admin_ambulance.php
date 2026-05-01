<?php
include("admin_header.php");

if (isset($_POST['submit'])) {
  $name = sanitizeInput($_POST['name']);
  $type = sanitizeInput($_POST['type']);
  $contact = sanitizeInput($_POST['contact']);
  $regno = sanitizeInput($_POST['regno']);
  
  $photo_name = '';
  if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
    if (in_array($_FILES['photo']['type'], $allowed_types)) {
      $photo_name = time() . '_' . basename($_FILES['photo']['name']);
      move_uploaded_file($_FILES['photo']['tmp_name'], "../asset_dashboard/file_uploads/" . $photo_name);
    }
  }
  
  $stmt = executeQuery($con, "INSERT INTO tbl_ambulance(ambulance_name, ambulance_type, ambulance_contact, ambulance_regno, ambulance_photo) VALUES(?, ?, ?, ?, ?)", "sssss", array($name, $type, $contact, $regno, $photo_name));
  if ($stmt) { $stmt->close(); }
  header('location:admin_ambulance.php');
  exit;
}

$remove = isset($_GET['remove']) ? intval($_GET['remove']) : 0;
if ($remove) {
  $stmt = executeQuery($con, "DELETE FROM tbl_ambulance WHERE ambulance_id=?", "i", array($remove));
  if ($stmt) { $stmt->close(); }
  header('location:admin_ambulance.php');
  exit;
}

if (isset($_POST['edit_submit'])) {
  $id = intval($_POST['ambulance_id']);
  $name = sanitizeInput($_POST['name']);
  $contact = sanitizeInput($_POST['contact']);
  $regno = sanitizeInput($_POST['regno']);
  
  $stmt = executeQuery($con, "UPDATE tbl_ambulance SET ambulance_name=?, ambulance_contact=?, ambulance_regno=? WHERE ambulance_id=?", "ssii", array($name, $contact, $regno, $id));
  if ($stmt) { $stmt->close(); }
  header('location:admin_ambulance.php');
  exit;
}

?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Hemo Connect</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="admin_participants.php">Admin</a></li>
        <li class="breadcrumb-item">Ambulance</li>
        <li class="breadcrumb-item active">Add & View</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Ambulance</h5>
            <!-- Floating Labels Form -->
            <form class="row g-3" method="post" enctype="multipart/form-data">

              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" name="name" id="name" placeholder="enter ambulance name" required>
                  <label for="name">Name</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" name="regno" id="regno" placeholder="enter register number" required>
                  <label for="regno">Register Number</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <select class="form-control" name="type" id="type" required>
                    <option value="">--choose type--</option>
                    <option value="With ICU">With ICU</option>
                    <option value="without ICU">without ICU</option>
                  </select>
                  <label for="type">Type</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" name="contact" id="contact" placeholder="enter contact number" required>
                  <label for="contact">Contact Number</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="file" class="form-control" name="photo" id="photo">
                  <label for="photo">Photo</label>
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
                  <th scope="col">Action</th>
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
                    <th scope="row"><?php echo $i; ?></th>
                    <td><img src="../asset_dashboard/file_uploads/<?php echo htmlspecialchars($data['ambulance_photo']); ?>" height="55" width="45"></td>
                    <td><?php echo htmlspecialchars($data['ambulance_name']); ?></td>
                    <td><?php echo htmlspecialchars($data['ambulance_type']); ?></td>
                    <td><?php echo htmlspecialchars($data['ambulance_contact']); ?></td>
                    <td><?php echo htmlspecialchars($data['ambulance_regno']); ?></td>
                    <td>


                      <button type="button" class="btn  btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $data['ambulance_id'] ?>">
                        Edit
                      </button>

                      <!-- The Modal -->
                      <div class="modal fade" id="myModal<?php echo $data['ambulance_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Ambulance Data</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">

                              <form class="row g-3" method="post" enctype="multipart/form-data">

                                <input type="hidden" class="form-control" name="ambulance_id" value="<?php echo $data['ambulance_id'] ?>">

                                <div class="col-md-6">
                                  <div class="form-floating">
                                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($data['ambulance_name']) ?>" placeholder="enter ambulance name" required>
                                    <label for="name">Name</label>
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="form-floating">
                                    <input type="text" class="form-control" name="regno" value="<?php echo htmlspecialchars($data['ambulance_regno']) ?>" placeholder="enter register number" required>
                                    <label for="regno">Register Number</label>
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="form-floating">
                                    <input type="text" class="form-control" name="contact" value="<?php echo htmlspecialchars($data['ambulance_contact']) ?>" placeholder="enter contact number" required>
                                    <label for="contact">Contact Number</label>
                                  </div>
                                </div>

                                <div class="text-center">
                                  <button type="submit" class="btn btn-primary" name="edit_submit">Save Changes</button>
                                </div>
                              </form>

                            </div>
                          </div>
                        </div>
                      </div>


                      <a href="admin_ambulance.php?remove=<?php echo $data['ambulance_id']; ?>" class="btn btn-sm btn-danger">Remove</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->




<?php include("admin_footer.php"); ?>
