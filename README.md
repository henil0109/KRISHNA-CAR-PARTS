# 🚗 Krishna Car Parts - Premium Auto E-Commerce Platform

<div align="center">

![Krishna Car Parts Logo](assets/images/kcp.png)

**Your One-Stop Destination for Premium Auto Parts & Accessories**

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://javascript.com)

[🚀 Live Demo](#) • [📖 Documentation](#features) • [🛠️ Installation](#installation) • [🤝 Contributing](#contributing)

</div>

---

## 🌟 Project Overview

Krishna Car Parts is a **modern, full-featured e-commerce platform** specifically designed for automotive parts and accessories. Built with cutting-edge web technologies, it offers a seamless shopping experience for car enthusiasts, mechanics, and dealers.

### 🎯 Key Highlights
- 🛒 **Complete E-Commerce Solution** - From browsing to checkout
- 👨‍💼 **Dual Interface** - Customer portal + Admin dashboard  
- 🔐 **Secure Authentication** - User registration & login system
- 📱 **Responsive Design** - Works perfectly on all devices
- 🎨 **Modern UI/UX** - Dark theme with gradient aesthetics
- ⚡ **Real-time Updates** - Live cart counts & notifications

---

## ✨ Features

<details>
<summary>🛍️ <strong>Customer Features</strong></summary>

### 🏠 **User Experience**
- **Modern Landing Page** with hero video and company timeline
- **Advanced Product Browsing** with category-wise organization
- **Smart Filtering** by price, category, model, and stock status
- **Product Search** with real-time results
- **Detailed Product Pages** with specifications and related items

### 🛒 **Shopping Features**
- **Shopping Cart** with quantity management
- **Wishlist System** for saving favorite items
- **Multi-step Checkout** with shipping and payment options
- **Order Tracking** with real-time status updates
- **Invoice Generation** with professional formatting

### 👤 **Account Management**
- **User Registration & Login** with validation
- **Profile Management** with order history
- **Password Security** with strength requirements
- **Dashboard** with personalized content

</details>

<details>
<summary>⚙️ <strong>Admin Features</strong></summary>

### 📊 **Dashboard & Analytics**
- **Real-time Statistics** - Orders, revenue, users, products
- **Interactive Charts** - Sales trends and performance metrics
- **Business Notifications** - Low stock alerts, new orders
- **Quick Actions** - Direct access to key functions

### 📦 **Inventory Management**
- **Product Management** - Add, edit, delete products
- **Category Organization** - Hierarchical product categorization
- **Stock Tracking** - Real-time inventory levels
- **Image Management** - Product photo uploads

### 🛍️ **Order Management**
- **Order Processing** - Status updates and tracking
- **Payment Tracking** - Transaction monitoring
- **Customer Management** - User accounts and profiles
- **Inquiry System** - Customer support integration

</details>

<details>
<summary>🔧 <strong>Technical Features</strong></summary>

### 🏗️ **Architecture**
- **MVC Pattern** - Clean separation of concerns
- **Responsive Design** - Bootstrap 5 framework
- **AJAX Integration** - Seamless user interactions
- **Session Management** - Secure user state handling

### 🔒 **Security**
- **SQL Injection Protection** - Prepared statements
- **XSS Prevention** - Input sanitization
- **Authentication Guards** - Route protection
- **Data Validation** - Client & server-side validation

### 🎨 **Design System**
- **Dark Theme** - Modern aesthetic with neon accents
- **Gradient Effects** - Eye-catching visual elements
- **Smooth Animations** - Enhanced user experience
- **Icon Integration** - Font Awesome icons

</details>

---

## 🖼️ Screenshots

<div align="center">

### 🏠 Homepage
![Homepage](https://via.placeholder.com/800x400/0b0d10/00ffe5?text=Modern+Landing+Page+with+Hero+Video)

### 🛍️ Product Browsing
![Browse Products](https://via.placeholder.com/800x400/111317/ff3b2f?text=Advanced+Product+Filtering+%26+Search)

### 🛒 Shopping Cart
![Shopping Cart](https://via.placeholder.com/800x400/1b1f27/00ffe5?text=Interactive+Shopping+Cart)

### 📊 Admin Dashboard
![Admin Dashboard](https://via.placeholder.com/800x400/0b0d10/ff3b2f?text=Comprehensive+Admin+Panel)

</div>

---

## 🛠️ Installation

### 📋 Prerequisites
- **XAMPP/WAMP** - Local server environment
- **PHP 7.4+** - Server-side scripting
- **MySQL 5.7+** - Database management
- **Modern Browser** - Chrome, Firefox, Safari, Edge

### ⚡ Quick Setup

1. **Clone the Repository**
   ```bash
   git clone https://github.com/henil0109/KRISHNA-CAR-PARTS.git
   cd KRISHNA-CAR-PARTS
   ```

2. **Setup Local Server**
   ```bash
   # Move to XAMPP htdocs
   cp -r . /xampp/htdocs/KCP/
   
   # Start Apache & MySQL
   # Via XAMPP Control Panel
   ```

3. **Database Configuration**
   ```sql
   -- Create database
   CREATE DATABASE KCP_db;
   
   -- Import structure (auto-created on first run)
   -- Tables: users_tbl, products_tbl, orders_tbl, etc.
   ```

4. **Configure Connection**
   ```php
   // Admin/connection.php
   $host = "localhost";
   $username = "root";
   $password = "";
   $database = "KCP_db";
   ```

5. **Launch Application**
   ```
   🌐 User Portal: http://localhost/KCP/User/
   ⚙️ Admin Panel: http://localhost/KCP/Admin/
   ```

### 🔑 Default Credentials
```
👤 Admin Login:
   Email: admin@krishnacarparts.com
   Password: admin123

🛍️ Test User:
   Create account via signup page
```

---

## 🏗️ Project Structure

```
KCP/
├── 📁 Admin/                 # Admin panel & management
│   ├── 🏠 index.php         # Dashboard with analytics
│   ├── 📦 products_*.php    # Product management
│   ├── 🛍️ orders.php        # Order processing
│   ├── 💰 payments.php      # Payment tracking
│   ├── 👥 viewuser.php      # User management
│   └── 🔧 *.php             # Other admin functions
├── 📁 User/                  # Customer-facing portal
│   ├── 🏠 index.php         # Landing page
│   ├── 🛍️ browse.php        # Product catalog
│   ├── 🛒 cart.php          # Shopping cart
│   ├── 💳 checkout.php      # Order placement
│   ├── 👤 login.php         # Authentication
│   └── 📄 *.php             # Other user functions
├── 📁 assets/               # Static resources
│   ├── 🎨 css/              # Stylesheets
│   ├── 📜 js/               # JavaScript files
│   ├── 🖼️ images/           # Product & UI images
│   └── 🔤 fonts/            # Typography
└── 📄 README.md             # Project documentation
```

---

## 🚀 Usage Guide

### 👤 For Customers

1. **🔍 Browse Products**
   - Visit the homepage and explore categories
   - Use filters to find specific parts
   - View detailed product information

2. **🛒 Shopping Process**
   - Add items to cart or wishlist
   - Proceed to secure checkout
   - Choose payment method (Card/UPI/COD)
   - Track order status

3. **👨‍💼 Account Management**
   - Create account for personalized experience
   - View order history and invoices
   - Update profile information

### ⚙️ For Administrators

1. **📊 Dashboard Overview**
   - Monitor real-time business metrics
   - View recent orders and notifications
   - Access quick management tools

2. **📦 Inventory Management**
   - Add new products with images
   - Update stock levels and pricing
   - Organize products by categories

3. **🛍️ Order Processing**
   - Process incoming orders
   - Update order status
   - Manage customer inquiries

---

## 🛡️ Security Features

- **🔐 Authentication System** - Secure login/logout functionality
- **🛡️ SQL Injection Protection** - Prepared statements throughout
- **🚫 XSS Prevention** - Input sanitization and validation
- **🔒 Session Security** - Proper session management
- **✅ Data Validation** - Client and server-side validation
- **🔑 Password Security** - Strength requirements and hashing

---

## 🤝 Contributing

We welcome contributions from the community! Here's how you can help:

### 🐛 Bug Reports
- Use GitHub Issues to report bugs
- Include detailed reproduction steps
- Provide screenshots if applicable

### ✨ Feature Requests
- Suggest new features via GitHub Issues
- Explain the use case and benefits
- Consider implementation complexity

### 🔧 Pull Requests
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

---

## 📞 Support & Contact

<div align="center">

**Need Help? We're Here for You!**

[![Email](https://img.shields.io/badge/Email-D14836?style=for-the-badge&logo=gmail&logoColor=white)](mailto:info@krishnacarparts.com)
[![Phone](https://img.shields.io/badge/Phone-25D366?style=for-the-badge&logo=whatsapp&logoColor=white)](tel:+919876543210)
[![Location](https://img.shields.io/badge/Location-FF5722?style=for-the-badge&logo=google-maps&logoColor=white)](https://maps.google.com)

**📍 Address:** Pal, Surat, Gujarat, India  
**📞 Phone:** +91 98765 43210  
**📧 Email:** info@krishnacarparts.com

</div>

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

## 🙏 Acknowledgments

- **Bootstrap Team** - For the amazing CSS framework
- **Font Awesome** - For the comprehensive icon library
- **PHP Community** - For continuous language development
- **MySQL Team** - For the robust database system
- **Open Source Community** - For inspiration and resources

---

<div align="center">

**⭐ Star this repository if you found it helpful!**

**Made with ❤️ by the Krishna Car Parts Team**

[![GitHub stars](https://img.shields.io/github/stars/henil0109/KRISHNA-CAR-PARTS?style=social)](https://github.com/henil0109/KRISHNA-CAR-PARTS/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/henil0109/KRISHNA-CAR-PARTS?style=social)](https://github.com/henil0109/KRISHNA-CAR-PARTS/network)

</div>