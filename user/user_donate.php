<?php
include('user_header.php');

$user_data = getRow($con, "SELECT * FROM tbl_user WHERE user_id=?", "s", array($sid));

$lastDonationData = getRow($con, "SELECT MAX(donation_date) AS last_donation_date FROM tbl_donation WHERE user_id=?", "s", array($sid));

if (isset($_POST['button'])) {
    if (!empty($lastDonationData['last_donation_date'])) {
        $lastDonationTimestamp = strtotime($lastDonationData['last_donation_date']);
        $currentTimestamp = time();
        $secondsDifference = $currentTimestamp - $lastDonationTimestamp;

        $monthsDifference = floor($secondsDifference / (30 * 24 * 60 * 60));

        $remainingDays = ceil((3 - $monthsDifference) * 30);

        if ($monthsDifference >= 3) {
            $stmt = executeQuery($con, "INSERT INTO tbl_donation(user_id, donation_date, donation_status) VALUES(?, CURDATE(), 'Submitted')", "s", array($sid));
            if ($stmt) {
                $stmt->close();
                $_SESSION['flash_message'] = "Donation form Accepted Successfully!";
                header("location:user_donate.php");
                exit;
            }
        } else {
            $_SESSION['flash_message'] = "You can only donate after 3 months from the last donation date. Please wait for " . $remainingDays . " days.";
            header("location:user_donate.php");
            exit;
        }
    } else {
        $stmt = executeQuery($con, "INSERT INTO tbl_donation(user_id, donation_date, donation_status) VALUES(?, CURDATE(), 'Submitted')", "s", array($sid));
        if ($stmt) {
            $stmt->close();
            $_SESSION['flash_message'] = "Donation form Accepted Successfully!";
            header("location:user_donate.php");
            exit;
        }
    }
}

$donation_data = getRow($con, "SELECT * FROM tbl_donation WHERE user_id=?", "s", array($sid));
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Blood Donation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="user_donate.php">User</a></li>
                <li class="breadcrumb-item">Blood Donation</li>
                <li class="breadcrumb-item active">Consent Form and Status</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <?php
        if (!isset($donation_data['donation_status']) || $donation_data['donation_status'] != 'Submitted') {
        ?>

            <div class="row align-items-center justify-content-center vh-100">
                <div class="col-lg-6">
                    <div class="card">
                        <img src="../asset_dashboard/img/donation.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <form method="post">
                                <h3 class="card-title">Consent Form</h3>
                                <p class="card-text">
                                <h5 class="card-subtitle mb-2 text-muted">Donor Information</h5>
                                <ul class="nav-content collapse show">
                                    <li><b>Full Name:</b> <?php echo htmlspecialchars($user_data['user_name']); ?></li>
                                    <li><b>Date of Birth:</b> <?php echo htmlspecialchars($user_data['user_dob']); ?> </li>
                                    <li><b>Phone Number:</b> +91 <?php echo htmlspecialchars($user_data['user_phone']); ?> </li>
                                    <li><b>Email:</b> <?php echo htmlspecialchars($user_data['user_email']); ?> </li>
                                    <li><b>Address:</b> <?php echo htmlspecialchars($user_data['user_address']); ?> </li>
                                </ul>
                                <br>
                                <h5 class="card-subtitle mb-2 text-muted">Blood Donation Consent</h5>
                                <p>I, the undersigned, understand and voluntarily consent to donate my blood for the purpose of medical transfusion, research, or other medically-approved uses. Before signing this consent form, I acknowledge and confirm the following:</p>
                                <ul class="nav-content collapse show">
                                    <li><b>Medical History Disclosure:</b> I have provided an accurate medical and travel history to the best of my knowledge </li>
                                    <li><b>Understanding of Risks:</b> I understand that, as with any medical procedure, there may be potential risks associated with blood donation, but they are rare. </li>
                                    <li><b>Confidentiality:</b> I understand that all my personal and medical information will be kept confidential, except as required by law or as necessary for medical purposes </li>
                                    <li><b>Use of Blood:</b> My donated blood may be used for patients in need, research, or other medical uses </li>
                                    <li><b>Testing:</b> I understand that my blood will be tested for infectious diseases, including but not limited to HIV, Hepatitis B, and Hepatitis C. If any results are positive or questionable, the blood will not be used for transfusion, and I will be notified. </li>
                                    <li><b>Voluntary Donation:</b> I am donating my blood voluntarily without any coercion, and I have not received any form of payment or reward for my donation. </li>
                                </ul>
                                <br>
                                <h2 class="card-subtitle mb-2 text-muted">DECLARATION</h2>
                                <p>I have read (or had read to me) the information provided in this form. I had an opportunity to ask questions, and all of my questions have been answered to my satisfaction. By clicking the agree button i hereby give my consent to donate blood and for the blood to be used as mentioned above.</p>
                                <p><button class="btn btn-sm btn-success" name="button" type="submit">CONFIRM AS A DONOR</button></p>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>

            <div class="row align-items-center justify-content-center vh-100">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Thank You!</h3>
                            <p class="card-text">
                                Dear <?php echo htmlspecialchars($user_data['user_name']); ?>,
                            <p>
                                On behalf of HemoConnect, we extend our deepest gratitude to you for becoming a blood donor. Your selfless act today could be the lifeline for someone tomorrow.
                                Your generosity not only provides hope to those in urgent need but also inspires others to step forward and make a difference. It's individuals like you who play a pivotal role in ensuring that the gift of life continues to flow for those in critical situations.
                                Every drop counts, and your donation serves as a powerful testament to the kindness that humanity is capable of. Thank you for your commitment to saving lives and for being an invaluable part of our community.
                            </p>
                            <p>Warm regards,</p>
                            <p>HemoConnect</p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

    </section>

</main><!-- End #main -->




<?php
include('user_footer.php');
?>
