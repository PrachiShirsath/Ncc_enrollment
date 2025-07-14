# DBATU NCC Registration System

A comprehensive web-based registration and tracking system for the National Cadet Corps (NCC) unit at Dr. Babasaheb Ambedkar Technological University, Lonere.

## 🎯 Features

### For Students
- **Easy Application Form**: Simple and user-friendly application form for NCC enrollment
- **Unique Registration ID**: Each applicant receives a unique tracking ID
- **Real-time Status Tracking**: Check application status anytime using registration ID
- **Email Notifications**: Automatic email confirmations with tracking links
- **Batch Assignment**: View assigned training batch details and schedules

### For NCC Officers (Admin)
- **Admin Dashboard**: Complete management interface for NCC officers
- **Application Management**: Review, approve, reject, or assign applications to batches
- **Batch Management**: Create and manage training batches with capacity limits
- **Statistics Dashboard**: Real-time statistics and analytics
- **Email Integration**: Send notifications to applicants

## 🚀 Quick Start

### 1. Database Setup
```bash
# Import the database schema
mysql -u root -p < database_setup.sql
```

### 2. Configure Database Connection
Edit the database configuration in these files:
- `forms/process_application.php`
- `track-application.php`
- `admin/index.php`

Update the following variables:
```php
$host = 'localhost';
$dbname = 'ncc_dbatu';
$username = 'your_username';
$password = 'your_password';
```

### 3. Web Server Setup
- Place all files in your web server directory
- Ensure PHP and MySQL are installed and configured
- Make sure the `forms/` directory is writable for email functionality

### 4. Email Configuration
Configure your server's email settings or update the mail() function in `forms/process_application.php` to use SMTP.

## 📁 File Structure

```
ncc-main/
├── index.html                 # Main NCC website
├── track-application.php      # Application tracking page
├── forms/
│   ├── process_application.php    # Form processing backend
│   ├── application-success.php    # Success page after submission
│   └── contact.php               # Contact form (existing)
├── admin/
│   └── index.php                 # Admin dashboard
├── database_setup.sql            # Database schema and sample data
├── assets/                       # CSS, JS, images (existing)
└── README.md                     # This file
```

## 🔧 System Workflow

### Student Application Process
1. **Fill Application**: Student fills the "Join NCC" form on the main website
2. **Get Registration ID**: System generates unique registration ID (e.g., NCC2024ABC12345)
3. **Email Confirmation**: Student receives email with tracking link
4. **Track Status**: Student can check application status using the tracking link
5. **Batch Assignment**: Once approved, student gets assigned to a training batch

### Admin Management Process
1. **Login**: NCC officer logs into admin panel
2. **Review Applications**: View all pending applications
3. **Update Status**: Approve, reject, or assign to batches
4. **Manage Batches**: Create new training batches
5. **Monitor Statistics**: Track enrollment numbers and batch capacity

## 🗄️ Database Schema

### Tables
- **ncc_applications**: Stores all student applications
- **ncc_batches**: Stores training batch information
- **admin_users**: Stores admin user credentials
- **application_status_view**: View for easy status queries

### Key Fields
- `registration_id`: Unique tracking identifier
- `status`: Application status (pending/approved/rejected/assigned)
- `batch_id`: Reference to assigned training batch
- `created_at`: Application submission timestamp

## 🎨 Customization

### Styling
The system uses Bootstrap 5 with custom CSS. Main styling files:
- `assets/css/style.css`
- Inline styles in HTML files

### Branding
Update the following for your institution:
- Logo images in `assets/img/`
- Color scheme in CSS variables
- Contact information in forms
- Email templates in PHP files

## 🔒 Security Features

- **SQL Injection Protection**: Prepared statements for all database queries
- **Input Validation**: Server-side validation of all form inputs
- **Session Management**: Secure admin login system
- **Email Verification**: Confirmation emails for applications

## 📧 Email Templates

The system sends the following emails:
1. **Application Confirmation**: Sent when application is submitted
2. **Status Updates**: Can be extended for status change notifications

Email templates are in `forms/process_application.php` and can be customized.

## 🚀 Deployment

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Email server configuration

### Production Setup
1. **Security**: Change default admin credentials
2. **SSL**: Enable HTTPS for secure data transmission
3. **Backup**: Set up regular database backups
4. **Monitoring**: Configure error logging and monitoring

## 🐛 Troubleshooting

### Common Issues
1. **Database Connection**: Check database credentials and server connectivity
2. **Email Not Sending**: Verify email server configuration
3. **Form Not Submitting**: Check file permissions and PHP error logs
4. **Admin Login**: Default credentials are admin/admin123

### Debug Mode
Enable PHP error reporting for development:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📞 Support

For technical support or customization requests:
- **Email**: ncc@dbatu.ac.in
- **Phone**: 02140 275081
- **Developers**: Sudharshan and Prachi

## 📄 License

This project is developed for DBATU NCC Unit. All rights reserved.

---

**Made with ❤️ for DBATU NCC Unit** 