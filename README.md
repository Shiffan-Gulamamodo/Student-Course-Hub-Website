# 🎓 Student Course Hub Website

A university team project developed to provide students with an easy way to browse courses, search programmes, register their interest, and access programme-related information through a responsive web application. The system also includes an administrator portal for managing programmes, modules, and student enquiries.

---

## 📖 Overview

Student Course Hub was developed as part of a university web development module. The aim of the project was to design and implement a dynamic course management website that allows prospective students to explore available programmes and register their interest, while providing administrators with tools to manage course information.

As part of a collaborative team project, I was primarily responsible for developing several student-facing pages, implementing database connectivity, and contributing to testing, debugging, and version control throughout development.

---

## 👨‍💻 My Contribution

My primary responsibilities included:

- Developed the website homepage and navigation
- Built the login and registration-related pages
- Implemented the course listing and programme pages
- Developed the course search functionality
- Integrated PHP with a MySQL database using PDO
- Assisted with testing, debugging, and bug fixing
- Used Git and GitHub for version control and team collaboration

---

## ✨ Features

- Student homepage
- Course and programme listings
- Search functionality
- Register Interest form
- User authentication
- Administrator login
- Programme management
- Module management
- Mailing list management
- Database integration using MySQL

---

## 🛠 Tech Stack

- HTML5
- CSS3
- JavaScript
- PHP
- MySQL
- PDO
- Git
- GitHub

---

## 📸 Screenshots

Screenshots will be added soon.

---

## 📂 Project Structure

```text
Student-Course-Hub/
│
├── database/
│   └── student_course_hub.sql
│
├── HomePage.php
├── Course.php
├── Programme.php
├── RegisterInterest.php
├── AdminLogin.php
├── Admin_D.php
├── programme.index.php
├── Modules_D.php
├── Connection.php
├── Functions.php
├── CSS Files
├── JavaScript Files
└── README.md
```

---

## Database Setup

The database file is included in:

```text
database/student_course_hub.sql
```

To set up the database locally:

1. Open MySQL or phpMyAdmin.
2. Import `database/student_course_hub.sql`.
3. The script creates a database called:

```text
student_course_hub
```

4. Update the database connection settings in the following files to match your local MySQL configuration:

- `Connection.php`
- `Connection_D.php`
- `connection_A.php`

Example configuration:

```text
Host: localhost
Port: 3306
Username: YOUR_DATABASE_USERNAME
Password: YOUR_DATABASE_PASSWORD
Database: student_course_hub
```
```

### Local Setup

1. Import the SQL file into MySQL or phpMyAdmin.
2. Ensure the database name is:

```text
student_course_hub
```

3. Update the connection details if required inside:

- Connection.php
- Connection_D.php
- connection_A.php

---

## ▶️ Running the Project

Using XAMPP, WAMP or MAMP:

1. Copy the project into your web server directory.

```text
htdocs/student-course-hub
```

2. Start Apache and MySQL.

3. Import the database.

4. Open:

```text
http://localhost/student-course-hub/HomePage.php
```

---

## 📚 Programming Concepts Demonstrated

- Full-Stack Web Development
- CRUD Operations
- PHP & MySQL Integration
- Database Connectivity (PDO)
- Form Validation
- Search Functionality
- Session Management
- Team Collaboration
- Version Control with Git

---

## 🎓 What I Learned

This project allowed me to gain practical experience in:

- Developing dynamic web applications using PHP
- Connecting web applications to relational databases
- Designing responsive web pages using HTML, CSS and JavaScript
- Implementing search and user interaction features
- Working collaboratively within a software development team
- Managing source code using Git and GitHub

---

## 📌 Notes

This project was developed as part of a university web development module.

Although developed as a team project, my primary contribution focused on the student-facing functionality, including the homepage, authentication pages, course listings, search functionality, database integration, testing, and version control.
