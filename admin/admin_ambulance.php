<?php
include("admin_header.php");




if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $type = $_POST['type'];
  $contact = $_POST['contact'];
  $regno = $_POST['regno'];
  $photo = $_FILES['photo']['name'];
  $temp = $_FILES['photo']['tmp_name'];
  move_uploaded_file($temp, "../asset_dashboard/file_uploads/" . $photo);
  $insq = "insert into tbl_ambulance(ambulance_name,ambulance_type,ambulance_contact,ambulance_regno,ambulance_photo)
values('$name','$type','$contact','$regno','$photo')";
  mysqli_query($con, $insq);
  header('location:admin_ambulance.php');
}

$remove = $_GET['remove'];
if ($remove) {
  $delq = "delete from tbl_ambulance where ambulance_id='$remove'";
  $query = mysqli_query($con, $delq);
  if ($query == True) {
    header('location:admin_ambulance.php');
  }
}

if (isset($_POST['edit_submit'])) {
  $id = $_POST['ambulance_id'];
  $name = $_POST['name'];
  $contact = $_POST['contact'];
  $regno = $_POST['regno'];
  $upq = "update tbl_ambulance set ambulance_name='$name', ambulance_contact='$contact', ambulance_regno='$regno' where ambulance_id='$id'";
  mysqli_query($con, $upq);
  header('location:admin_ambulance.php');
}


?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Hemo Connect</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="">Admin</a></li>
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
                  <input type="name" class="form-control" name="name" id="name" placeholder="enter place name">
                  <label for="floatingEmail">Name</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="name" class="form-control" name="regno" id="district" placeholder="enter district name">
                  <label for="floatingEmail">Register Number</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <select class="form-control" name="type" id="state">
                    <option value="">--choose type--</option>
                    <option value="With ICU">With ICU</option>
                    <option value="without ICU">without ICU</option>
                  </select>
                  <label for="floatingEmail">Type</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="name" class="form-control" name="contact" id="state" placeholder="enter contact number">
                  <label for="floatingEmail">Contact Number</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="file" class="form-control" name="photo" id="photo">
                  <label for="floatingEmail">Photo</label>
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
                $selq = "select *from tbl_ambulance";
                $row = mysqli_query($con, $selq);
                $i = 0;
                while ($data = mysqli_fetch_array($row)) {
                  $i++;
                ?>

                  <tr>
                    <th scope="row"><?php echo $i; ?></th>
                    <td><img src="../asset_dashboard/file_uploads/<?php echo $data['ambulance_photo']; ?>" height="55" width="45"></td>
                    <td><?php echo $data['ambulance_name']; ?></td>
                    <td><?php echo $data['ambulance_type']; ?></td>
                    <td><?php echo $data['ambulance_contact']; ?></td>
                    <td><?php echo $data['ambulance_regno']; ?></td>
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

                                <input type="hidden" class="form-control" name="ambulance_id" id="name" value="<?php echo $data['ambulance_id'] ?>" placeholder="enter place name">

                                <div class="col-md-6">
                                  <div class="form-floating">
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $data['ambulance_name'] ?>" placeholder="enter place name">
                                    <label for="floatingEmail">Name</label>
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="form-floating">
                                    <input type="text" class="form-control" name="regno" id="district" value="<?php echo $data['ambulance_regno'] ?>" placeholder="enter district name">
                                    <label for="floatingEmail">Register Number</label>
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="form-floating">
                                    <input type="text" class="form-control" name="contact" id="state" placeholder="enter contact number" value="<?php echo $data['ambulance_contact'] ?>">
                                    <label for="floatingEmail">Contact Number</label>
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