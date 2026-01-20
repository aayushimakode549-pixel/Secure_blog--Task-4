# Task 4 – Security Enhancements

## Objective
The objective of Task 4 is to secure the blog application against common web vulnerabilities and improve overall application security.

---

## Security Features Implemented

### 1. Prepared Statements
- Used MySQLi prepared statements for all database queries.
- Prevents SQL Injection attacks by safely handling user input.

### 2. Form Validation
- Implemented server-side validation to ensure data integrity.
- Basic client-side validation added for better user experience.
- Prevents empty or invalid form submissions.

### 3. User Authentication
- Only logged-in users can create, edit, or delete posts.
- Session-based authentication is used to manage user access.

### 4. User Roles and Permissions
- Post ownership is verified before allowing edit or delete operations.
- Ensures that users can modify only their own posts.

---

## Benefits
- Protects the application from SQL injection attacks.
- Prevents unauthorized access to sensitive features.
- Ensures secure and reliable data handling.

---

## Technologies Used
- PHP
- MySQL
- MySQLi Prepared Statements
- Bootstrap
- XAMPP

---

## Conclusion
Task 4 enhances the security of the application by implementing prepared statements, form validation, and access control mechanisms, making the application safer and more reliable.
