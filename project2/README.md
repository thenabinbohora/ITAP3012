
# Project 2 (Standalone)
This is a separate Project 2 folder. It **copies your original Project 1 files** (index.html, styles.css, script.js) 
and adds PHP+MySQL features. Run it as its own site (e.g., `http://localhost/project2/`).

## Quick Start
1) Move `project2/` into your web root (e.g., `C:/xampp/htdocs/project2`).
2) Create DB and run `project2/database.sql` (it seeds an admin).
3) Copy `includes/config.sample.php` → `includes/config.php` and set:
   - db_host, db_name, db_user, db_pass
   - base_path: `/project2`  (change if your folder name/URL is different)
4) Start Apache + MySQL, then open:
   - Auth:        `/project2/auth/register.php`, `/project2/auth/login.php`
   - Dynamic Shop:`/project2/views/shop.php`
   - Cart:        `/project2/views/cart.php`
   - Checkout:    `/project2/views/checkout.php`
   - Admin:       `/project2/admin/dashboard.php` (admin: admin@vithub.com.au / Admin@123)

## Notes
- Your original `index.html`, `styles.css`, `script.js` here are **exact copies**; not modified.
- Dynamic pages **reuse** the same CSS/JS via a configurable `base_path`.
- Uses PDO + prepared statements, sessions, and role checks.
