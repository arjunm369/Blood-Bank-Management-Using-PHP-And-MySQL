# HemoConnect - Blood Bank Management System

<p align="center">
  <strong>A modern, secure, and user-friendly platform for managing blood donations and donor networks.</strong>
</p>

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [Usage](#usage)
- [Security Features](#security-features)
- [Database Schema](#database-schema)
- [Future Improvements](#future-improvements)
- [Contributing](#contributing)
- [License](#license)

---

## 🎯 Overview

**HemoConnect** is a comprehensive blood bank management system designed to connect blood donors, hospitals, and administrators on a single platform. The system streamlines the blood donation process, maintains donor records, tracks donation history, and enables hospitals to quickly find available donors based on blood type.

### Problem Solved
- **For Donors**: Simple registration, easy donation tracking, and health information management
- **For Hospitals**: Quick access to available donors, real-time donor database
- **For Admins**: Centralized control, system monitoring, and data management

---

## ✨ Features

### 👤 User Management
- **Three-tier authentication system** (Admin, Donor, Hospital)
- Role-based access control with secure session management
- User profile management with photo uploads
- Secure password hashing using PHP's `password_hash()`

### 🩸 Blood Donation Management
- Blood donation form submission for registered donors
- Automatic 3-month donation interval validation
- Donation history tracking for each donor
- Blood group categorization (O+, O-, A+, A-, B+, B-, AB+, AB-)

### 🏥 Hospital Features
- View all available donors by blood group
- Real-time donor database access
- Track donation submissions and status
- Contact information for donors

### 👨‍💼 Admin Dashboard
- View all registered users and hospitals
- System monitoring and management
- FAQ management system
- Donation statistics and reports
- Ambulance inventory management

### 🔒 Security
- **SQL Injection Prevention**: All queries use prepared statements
- **Input Validation**: Server-side validation for all forms
- **Password Security**: Passwords hashed with bcrypt algorithm
- **File Upload Protection**: MIME type validation, unique filenames
- **Session Security**: Session timeout and secure headers

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| **Frontend** | HTML5, CSS3, Bootstrap 5, jQuery |
| **Backend** | PHP 7.0+ |
| **Database** | MySQL 5.0+ |
| **Server** | Apache/Nginx |
| **Security** | Prepared Statements, Password Hashing, Input Validation |

---

## 📁 Project Structure

```
hemoconnect/
├── config/
│   ├── database.php              # Database connection (centralized)
│   └── security.php              # Security functions & validation
├── public/
│   ├── index.html                # Landing page
│   ├── login.php                 # Unified login (Admin/User/Hospital)
│   ├── register.php              # Donor registration
│   ├── register_hospital.php      # Hospital registration
│   ├── logout.php                # Session logout
│   └── assets/
│       ├── css/                  # Stylesheets
│       ├── js/                   # JavaScript files
│       └── uploads/              # User photo storage
├── app/
│   ├── admin/
│   │   ├── admin_participants.php    # View all users
│   │   ├── admin_ambulance.php       # Manage ambulances
│   │   ├── admin_faq.php            # Manage FAQs
│   │   ├── admin_feedback.php       # View feedback
│   │   └── admin_header.php         # Admin navigation
│   ├── user/
│   │   ├── user_donate.php       # Donation form
│   │   ├── user_history.php      # View donation history
│   │   ├── user_donors.php       # List of donors
│   │   └── user_header.php       # User navigation
│   └── hospital/
│       ├── hospital_donors.php   # View available donors
│       ├── hospital_ambulance.php # Manage ambulances
│       └── hospital_header.php   # Hospital navigation
├── database/
│   └── db_hemoconnect.sql        # Database schema
├── .env.example                  # Environment variables template
├── .gitignore                    # Git ignore rules
└── README.md                     # This file
```

---

## 🚀 Getting Started

### Prerequisites
- PHP 7.0 or higher
- MySQL 5.0 or higher
- Apache/Nginx web server
- Composer (optional, for package management)

### Installation

#### Step 1: Clone the Repository
```bash
git clone https://github.com/yourusername/hemoconnect.git
cd hemoconnect
```

#### Step 2: Create Database
```bash
mysql -u root -p < database/db_hemoconnect.sql
```

#### Step 3: Configure Database Connection
```bash
# Copy environment template
cp .env.example .env

# Edit .env with your database credentials
nano .env
```

Example `.env` file:
```
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=your_password
DB_NAME=db_hemoconnect
DB_PORT=3306
```

#### Step 4: Create Upload Directory
```bash
mkdir -p asset_dashboard/file_uploads
chmod 755 asset_dashboard/file_uploads
```

#### Step 5: Start Web Server
```bash
# Using PHP built-in server (development only)
php -S localhost:8000

# Or use Apache
# Place project in htdocs and access via http://localhost/hemoconnect
```

#### Step 6: Access Application
```
Browser: http://localhost:8000
```

---

## 📖 Usage

### Admin Access
- **Email**: `admin@hemo.com`
- **Password**: `admin`
- **Dashboard**: View all users, manage FAQs, manage ambulances

### Donor Registration
1. Click "Create an Account" on login page
2. Fill in personal details
3. Upload profile photo (JPEG/PNG/GIF only)
4. Blood group selection
5. Account activation and login

### Make Donation
1. Login as donor
2. Navigate to "Blood Donation"
3. Click "Donate Now"
4. System validates 3-month interval
5. Donation recorded in database

### Hospital Dashboard
1. Login as hospital
2. View all available donors
3. Filter by blood group
4. Access contact information

---

## 🔐 Security Features Implemented

### 1. **SQL Injection Prevention**
```php
// ❌ BEFORE (Vulnerable)
$query = "SELECT * FROM tbl_user WHERE email='$email'";

// ✅ AFTER (Secure)
$query = "SELECT * FROM tbl_user WHERE email = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $email);
```

### 2. **Password Security**
```php
// Hashing on registration
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Verification on login
if (password_verify($password, $hash)) {
    // Login successful
}
```

### 3. **Input Validation**
```php
// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Invalid email
}

// Phone validation
if (strlen($phone) < 10 || strlen($phone) > 12) {
    // Invalid phone
}
```

### 4. **File Upload Security**
```php
// Validate MIME type
$allowed = array('image/jpeg', 'image/png', 'image/gif');
if (!in_array($_FILES['photo']['type'], $allowed)) {
    // Invalid file type
}

// Generate unique filename
$filename = time() . '_' . basename($_FILES['photo']['name']);
```

### 5. **Session Security**
```php
// Prevent page caching
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

// Check session on protected pages
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
```

---

## 📊 Database Schema

### Key Tables

**tbl_user** (Donors)
```sql
- user_id (Primary Key)
- user_name
- user_email (Unique)
- user_password (Hashed)
- user_phone
- user_bgroup
- user_photo
- user_dob
- user_address
```

**tbl_hospital** (Hospitals)
```sql
- hospital_id (Primary Key)
- hospital_name
- hospital_email (Unique)
- hospital_password (Hashed)
- hospital_phone
- hospital_address
```

**tbl_donation** (Donation Records)
```sql
- donation_id (Primary Key)
- user_id (Foreign Key)
- donation_date
- donation_status
- last_donation_date
```

**tbl_admin** (System Administrators)
```sql
- admin_id (Primary Key)
- admin_name
- admin_email
- admin_password (Hashed)
```

---

## 🔮 Future Improvements

### High Priority
- [ ] Implement JWT token-based authentication
- [ ] Add email verification on registration
- [ ] Create REST API for mobile app integration
- [ ] Implement rate limiting for login attempts
- [ ] Add 2FA (Two-Factor Authentication)

### Medium Priority
- [ ] Donation eligibility questionnaire
- [ ] Blood inventory tracking system
- [ ] Automated SMS notifications
- [ ] Advanced search and filtering
- [ ] Dashboard analytics and reporting

### Low Priority
- [ ] Mobile app (React Native/Flutter)
- [ ] Multi-language support
- [ ] Blockchain for donation records
- [ ] Integration with blood test labs
- [ ] Chatbot support system

### Known Limitations
- **Single Language**: Currently only in English
- **Basic Reporting**: Limited to simple data tables
- **File Storage**: Uploaded photos stored locally (no CDN)
- **Email Integration**: No automated email notifications
- **Scalability**: Not optimized for large datasets (>100K records)

---

## 🧪 Testing

### Manual Testing Checklist
- [ ] User registration with valid data
- [ ] User registration with invalid email
- [ ] User registration with duplicate email
- [ ] Login with correct credentials
- [ ] Login with wrong password
- [ ] Photo upload with invalid file type
- [ ] Donation form submission
- [ ] 3-month interval validation
- [ ] Hospital donor search
- [ ] Admin dashboard functionality

### Sample Test Data
```
Donor Credentials:
Email: donor@test.com
Password: test123

Hospital Credentials:
Email: hospital@test.com
Password: test123

Admin Credentials:
Email: admin@hemo.com
Password: admin
```

---

## 📝 Code Examples

### Secure Database Query
```php
<?php
require_once('config/database.php');
require_once('config/security.php');

// Safe query with prepared statement
$email = sanitizeInput($_POST['email']);
$query = "SELECT * FROM tbl_user WHERE user_email = ?";
$user = getRow($con, $query, "s", array($email));

if ($user) {
    echo "User found: " . $user['user_name'];
}
?>
```

### File Upload with Validation
```php
<?php
$allowed_types = array('image/jpeg', 'image/png');
$file = $_FILES['photo'];

if (in_array($file['type'], $allowed_types)) {
    $filename = time() . '_' . basename($file['name']);
    move_uploaded_file($file['tmp_name'], 'uploads/' . $filename);
}
?>
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Code Standards
- Follow PSR-12 coding standards
- Write comments for complex logic
- Test all changes before submitting PR
- Update README.md for new features

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**Your Name / Team Name**
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

---

## 📞 Support

For issues, feature requests, or questions, please:
1. Check existing GitHub issues
2. Create a new issue with detailed description
3. Include steps to reproduce bugs
4. Share screenshots when relevant

---

## 🙏 Acknowledgments

- Bootstrap team for the responsive framework
- PHP community for security best practices
- Inspired by real-world blood bank management needs

---

**Last Updated**: January 2026  
**Version**: 1.0.0  
**Status**: Production Ready ✅

