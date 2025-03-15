<?php
include("user_header.php");


if(isset($_GET['accept']))
{
    $request_id=$_GET['accept'];

    $donation_c="select *from tbl_request where request_id='$request_id'";
    $donation_r=mysqli_query($con,$donation_c);
    $donation_d=mysqli_fetch_array($donation_r);
    $donation_id=$donation_d['reciever_id'];

    if($donation_id != NULL)
    {
        $upq="update tbl_request set request_status='Confirmed', donation_date=CURDATE() where request_id='$request_id'";
        $query=mysqli_query($con,$upq);
    
        $upq2="update tbl_donation set last_donation_date=CURDATE(), donation_status='Not Submitted' where donation_id='$donation_id'";
        $query2=mysqli_query($con,$upq2);
    
    
        if($query2==True)
        {
            $_SESSION['flash_message']="Donated Successfully";
            header('location:user_history.php');
        }
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
                <li class="breadcrumb-item active">History</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">History</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Blood Group</th>
                                    <th scope="col">Request Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $donors = "select *from tbl_request a 
                                inner join tbl_donation b on a.reciever_id=b.donation_id 
                                inner join tbl_user c on a.sender_id=c.user_id 
                                where request_status='Added' and b.user_id='$sid'";
                                $don_row = mysqli_query($con, $donors);
                                $i = 0;
                                while ($data = mysqli_fetch_array($don_row)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $data['user_name']; ?></td>
                                        <td><?php echo $data['user_bgroup']; ?></td>
                                        <td><?php echo $data['request_date']; ?></td>
                                        <td>
                                        <a href="user_requests.php?accept=<?php echo $data['request_id']; ?>" class="btn btn-sm btn-success">Accept</a>
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