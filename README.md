MasterKeys - Supercar Rental System

MasterKeys is a full-stack web application built with PHP and MySQL that allows users to browse, book, and pay for luxury supercars. The system includes a dynamic homepage, a full fleet listing, a detailed car info page with a booking system, and a comprehensive Admin Panel for fleet and booking management.
🚀 Features
User Features

    Dynamic Homepage: Showcases featured cars directly from the database and includes a professional brand logo slider.

    Our Fleet: A complete listing of all available vehicles. Unavailable (booked) cars are automatically grayed out to improve user experience.

    Car Details: Unique pages for every car generated dynamically using URL parameters.

    Booking System: A multi-step booking process including date selection and a simulated payment gateway.

    Responsive Design: Fully mobile-friendly UI built with modern CSS Grid and Flexbox.

Admin Features

    Car Management: Add, edit, and delete cars from the fleet.

    Booking Tracking: A dedicated dashboard to monitor active bookings, customer details, and total revenue.

    Status Management: One-click "Return" functionality that automatically updates car availability in the database.

🛠️ Tech Stack

    Frontend: HTML, CSS

    Backend: PHP 

    Database: MySQL

    Tools: XAMPP / Localhost environment

📋 Database Schema

The project relies on two main tables: cars and bookings.
Cars Table
```sql
        id	INT	Primary Key
        car_name	VARCHAR	Brand name of the car
        model	VARCHAR	Specific model name
        price_per_day	DECIMAL	Rental cost per 24 hours
        status	VARCHAR	'Available' or 'Unavailable'
        image	VARCHAR	Filename stored in /uploads
```        
Bookings Table
```sql
        id	INT	Primary Key
        car_id	INT	Foreign Key (linked to cars)
        user_name	VARCHAR	Customer name
        start_date	DATE	Rental start
        end_date	DATE	Rental end
        total_amount	DECIMAL	Calculated (Days * Price)
        booking_status	VARCHAR	'Active' or 'Completed' 
   ``` 


🔧 Installation & Setup

Clone the repository:
Bash

git clone https://github.com/yourusername/CarRentalProject.git

Move to Web Directory: Place the folder in your local server directory (e.g., C:/xampp/htdocs/).

Setup Database:

    Open phpMyAdmin.

    Create a database named car_rental.

    Import the provided SQL files or run the CREATE TABLE queries provided in the documentation.

Configure Connection: Open conn.php and update your database credentials:
PHP

    $host = 'localhost';
    $user = 'root';
    $pass = ''; 
    $db   = 'car_rental';

    Run the Project: Navigate to http://localhost/CarRentalProject/homepage.php in your browser.

📸 Screenshots


<img width="809" height="1174" alt="image" src="https://github.com/user-attachments/assets/08cec796-8f89-4a1b-900a-626adf9b2aae" />

<img width="917" height="868" alt="image" src="https://github.com/user-attachments/assets/ec335120-1abb-48c8-a0f5-8d81513c0744" />

<img width="875" height="424" alt="image" src="https://github.com/user-attachments/assets/a8353e23-692d-4d34-8dfe-2c297e95b4ac" />
<img width="923" height="209" alt="image" src="https://github.com/user-attachments/assets/03f15779-740e-467f-9fa5-34427fec6fb2" />

<img width="923" height="448" alt="image" src="https://github.com/user-attachments/assets/df997fbb-8e1a-4151-85de-036ef2f613e5" />

<img width="923" height="574" alt="image" src="https://github.com/user-attachments/assets/f5179581-5401-43b0-ae2a-133cd666f91d" />

<img width="816" height="721" alt="image" src="https://github.com/user-attachments/assets/a3459c5f-46a6-4b24-94c2-e221a063467b" />

<img width="923" height="633" alt="image" src="https://github.com/user-attachments/assets/3b7f5547-b75e-457b-880a-506e6747488b" />
<img width="923" height="160" alt="image" src="https://github.com/user-attachments/assets/fcdb62d5-ec6f-437e-8a9a-2dd9a4c50f93" />




ThankYou....

~ Kartik Naik

    






