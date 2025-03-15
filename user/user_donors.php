<?php
include("user_header.php");

$donation_id=$_GET['donation'];
if($donation_id)
{
    $insq="insert into tbl_request(reciever_id,sender_id,request_date,request_status) values('$donation_id','$sid',CURDATE(),'Added')";
    $query=mysqli_query($con,$insq);
    if($query==True)
    {
        $_SESSION['flash_message']="Donation Request Added Successfully";
        header("location:user_history.php");
    }
}


?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>DROPE OF HOPE</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">User</a></li>
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
                                    <th scope="col">Email</th>
                                    <th scope="col">Contact Number</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $donors = "select *from tbl_donation a inner join tbl_user b on a.user_id=b.user_id where a.user_id<>'$sid' and donation_status='Submitted'";
                                $don_row = mysqli_query($con, $donors);
                                $i = 0;

                                while ($don_data = mysqli_fetch_array($don_row)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i;?></th>
                                        <td><?php echo $don_data['user_name'];?></td>
                                        <td><?php echo $don_data['user_bgroup'];?></td>
                                        <td><?php echo $don_data['user_email'];?></td>
                                        <td><?php echo $don_data['user_phone'];?></td>
                                        <td><a href="user_donors.php?donation=<?php echo $don_data['donation_id'];?>" class="btn btn-sm btn-info">Request</a>
                                        </td>
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
</main>
<?php include("user_footer.php"); ?>