# Quick Start Guide - HemoConnect

## 🚀 5-Minute Setup

### Step 1: Database Setup (1 min)
```bash
# Open MySQL and import database
mysql -u root -p < database/db_hemoconnect.sql
```

### Step 2: Configure Environment (1 min)
```bash
# Copy and edit environment file
cp .env.example .env

# Edit .env file with your database credentials
# DB_USER=root
# DB_PASSWORD=your_password
```

### Step 3: Upload Directory (1 min)
```bash
mkdir -p asset_dashboard/file_uploads
chmod 755 asset_dashboard/file_uploads
```

### Step 4: Start Server (1 min)
```bash
# Option 1: PHP Built-in Server (Development)
php -S localhost:8000

# Option 2: Apache (Production)
# Place in htdocs and access: http://localhost/hemoconnect
```

### Step 5: Access & Login (1 min)
- **URL**: http://localhost:8000
- **Admin Login**: 
  - Email: `admin@hemo.com`
  - Password: `admin`

---

## 📱 Test Accounts

### Admin Account
```
Email: admin@hemo.com
Password: admin
Access: System dashboard, user management, ambulance management
```

### Create Test Accounts
1. Go to registration page
2. Select "Donor Registration" or "Hospital Registration"
3. Fill in details (any valid data works)
4. For donors, you can use any valid photo (JPG/PNG)
5. Login with new account

---

## 🎯 Test Workflows

### Workflow 1: Donor Registration & Donation
1. Register as a new donor
2. Upload a photo
3. Login with donor account
4. Go to "Blood Donation" section
5. Click "Donate Now"
6. Form submits donation

### Workflow 2: Hospital Search Donors
1. Register as a hospital
2. Login with hospital account
3. View "Donors" page
4. See all registered donors with blood groups
5. Contact information available

### Workflow 3: Admin Dashboard
1. Login as admin
2. View all users
3. View all hospitals
4. Manage ambulances
5. Manage FAQs

---

## 🔧 Troubleshooting

### Database Connection Error
```
Error: Connection failed
Solution: Check .env file, ensure DB credentials are correct
```

### File Upload Error
```
Error: File upload failed
Solution: 
1. Check folder permissions: chmod 755 asset_dashboard/file_uploads
2. Verify MIME type (only JPEG, PNG, GIF allowed)
```

### Login Fails
```
Error: Invalid email or password
Solution:
1. Check if user exists in database
2. Verify password is typed correctly
3. Use provided admin credentials for first test
```

### Session Timeout
```
Error: Redirected to login
Solution: Sessions expire after 30 minutes. Login again.
```

---

## 📋 Default Database Values

### Admin Account
- Email: admin@hemo.com
- Password: admin (stored as hash)
- Access Level: Admin

### Blood Groups
- O+, O-
- A+, A-
- B+, B-
- AB+, AB-

---

## 🔐 Important Security Notes

1. **Change Admin Password**: After first login, update admin credentials
2. **Hide .env File**: Never commit .env to git
3. **Use HTTPS**: In production, always use HTTPS
4. **Database Backups**: Regular backups recommended
5. **Input Validation**: All inputs are validated server-side

---

## 📚 Next Steps After Setup

1. ✅ Test all features with sample data
2. ✅ Review database schema in `database/db_hemoconnect.sql`
3. ✅ Check `config/security.php` for available functions
4. ✅ Read `ANALYSIS.md` for code structure details
5. ✅ Review `README.md` for complete documentation

---

## 💻 Development Tips

### Enable Debug Mode
```php
// In config/database.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### Check Database Connection
```php
require_once('config/database.php');
if (!$con) {
    die("Database connection failed");
} else {
    echo "Connected successfully!";
}
```

### View Active Sessions
```php
// In any protected page
echo "User ID: " . $_SESSION['id'];
echo "User Type: " . $_SESSION['user_type'];
```

---

## 📞 Support

If you encounter issues:
1. Check this guide first
2. Review error messages in browser console
3. Check MySQL error logs
4. Open GitHub issue with details

