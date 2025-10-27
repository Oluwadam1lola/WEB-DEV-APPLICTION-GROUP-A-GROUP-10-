# COURSE ENROLLMENT SYSTEM

## GROUP MEMBERS

1. AKINBILE OLUWADAMILOLA MICHAEL 23/1749 Oluwadam1lola (username)
2. Aberuagba Oluwafimihan Maikudi 23/2226
3. Agbabiaka Oluwabusayomi Elizabeth 23/233
5. Ajayi Oluwamayokun Emmanuel 23/0422
6. Aina Oluwafisayo David 23/0799
7. Faleye Oluwanifemi Shalom 23/2690
8. James Rotimi Mathew. 23/2768


A simple web-based application that allows students to enroll in courses and enables administrators to view, manage, and export the enrollment data.


### Project Breakdown & Team Contribution

1. Enrollment View
Handles the student-facing form where users can register for courses.
- Includes input fields for name, course selection, etc.
- Uses the POST method to send data.
- Done by:James Rotimi Matthew 


2. Enrollment Controller
Processes data from the form and stores it securely in the database.
- Handles form validation and input sanitization.
- Done by:Aberuagba Oluwafimihan Maikudi — 23/2226


3. Admin View
Displays all submitted enrollments with filtering and export options.
- Allows filtering by course.
- Shows total count per course.
- Done by:Faleye Oluwanifemi Shalom 


4. Admin Controller
Manages the backend logic for the admin interface.
- Fetches, filters, and prepares enrollment data for display and export.
- Done by:AKINBILE OLUWADAMILOLA MICHAEL — 23/1749
  

5. Styling
Gives the application a modern and clean appearance using CSS.

- Ensures user-friendly layout and responsive design.
- Done by:Ajayi Oluwamayokun Emmanuel — 23/0422

6. Database SQL
SQL file for setting up tables like `enrollments`, `users`, etc.
- Ensures relational structure for efficient data access.
- Done by:Agbabiaka Oluwabusayomi Elizabeth* — 23/233


7. config.php
Contains database connection setup.
- Central configuration for accessing MySQL database using MySQLi.
- Done by:Agbabiaka Oluwabusayomi Elizabeth* — 23/233


8. Documentation
Explained the workflow, structure, and how to run the project.
- Described each contributor's role. Done by Aina  Oluwafisayo David  23/0799


### How to Run the Project
1. Clone or download the repository.
2. Import `database.sql` into your MySQL server.
3. Configure database credentials in `config/config.php`.
4. Open `index.php` and `admin.php` using a local server (e.g., XAMPP).
5. Begin registration and management.


### Features
- Real-time student course registration.
- Admin dashboard with filtering and export.
- Clean and responsive interface.


- Secure data validation.
*Technologies Used*
- PHP (Procedural)
- MySQL
- HTML/CSS
- JavaScript (optional)
