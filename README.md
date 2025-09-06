📦 Inventory & Accounts Management System

A complete inventory and accounts management system built with PHP and MySQL. It includes modules for managing products, customers, suppliers, sales, purchases, banking, expenses, reporting, and profit/loss tracking.

🚀 Features
🔑 Authentication & User Access

Login, signup, and forgot password pages.

Role-based access control (Admin / User).

📊 Dashboard

Overview of sales, purchases, stock, and cash flow.

Quick links to important modules.

🛒 Product & Inventory Management

Add, edit, delete products with categories, subcategories, and units.

Barcode generation and printing.

Product details, stock report, expiry tracking.

Warehouse management with multiple warehouse support.

Product in stock reports, warehouse-wise reports.

👥 Customer Management

Add and update customers with full details.

Customer ledger and transaction history.

Customer payment tracking (list, edit, delete, history).

Customer-wise reports.

🏭 Supplier Management

Add and update suppliers.

Supplier ledger and transaction history.

Supplier payment management (list, edit, delete, details).

Supplier-wise reports.

💰 Sales Module

Add new sales with product selection.

Sales invoices and print options.

Sale details, product-wise reports.

Sale date-wise report and Ajax-powered quick search.

Sale returns management.

Today’s sales and profit/loss reports.

📦 Purchase Module

Add new purchase with product details.

Purchase date-wise reports.

Purchase return management.

Average purchase price reports.

Purchase and date-wise combined reports.

💵 Accounts & Banking

Create accounts and open bank accounts.

View account details and ledgers.

Debit and credit entries with Ajax validation.

Bank account details and transaction reports.

Cash in hand, cash out, cash flow reports.

📑 Expenses

Add expenses with categories.

Expense edit, list, and category management.

Date-wise and Ajax-powered expense reports.

📈 Reports & Analysis

Profit and loss reports.

Stock product-wise report.

Warehouse-wise reports.

Category-wise product reports.

Item-wise sales/purchase reports.

Customer-wise and supplier-wise reports.

🛡️ Backup & Export

Database backup system (dbBackup, db_export).

Reports exportable in CSV format.

⚙️ Utilities

QR code generator for products.

Barcode128 support.

Alert system for low stock or zero quantity.

Support for service charges, delivery charges, and discounts.

🗂️ Project Structure
.
├── assets/              # CSS, JS, plugins, fonts
├── images/              # Images and icons
├── include/             # Shared files (db.php, header.php, footer.php, menu.php)
├── pages/               # Main application pages
│   ├── administrator/   # Admin-specific features
│   ├── generate_temp_qr # QR code generator
│   ├── account_*        # Accounts & ledger management
│   ├── add_*            # Product, warehouse, battery add forms
│   ├── bank_*           # Bank account and transactions
│   ├── bar_code*        # Barcode generation and printing
│   ├── cash_*           # Cash flow and reports
│   ├── category*        # Category and subcategory management
│   ├── charge*          # Charges and expenses
│   ├── customer_*       # Customer management and reports
│   ├── expense_*        # Expense management
│   ├── profit_loss*     # Profit/loss reports
│   ├── purchase*        # Purchase management & reports
│   ├── sale*            # Sales management & reports
│   ├── stock*           # Stock and warehouse reports
│   ├── supplier_*       # Supplier management and reports
│   ├── unit*            # Unit management
│   ├── ware*            # Warehouse management
│   └── dbBackup.php     # Database backup
├── contact.php          # Contact page
├── expiry.php           # Product expiry report
├── signup.php           # Signup page
├── forgot_password.php  # Password recovery
├── index.php            # Main entry point

🛠️ Tech Stack

Backend: PHP

Frontend: HTML, CSS, JavaScript

Database: MySQL

Plugins: Barcode128, QR Code Generator, Ajax

📊 Use Cases

Retail shops 🛍️

Warehouses 🏭

Distributors & wholesalers 📦

Small to medium businesses 📈

🔮 Future Enhancements

Multi-user branch support

Role-based advanced permissions

API for mobile app integration

Advanced analytics with charts
