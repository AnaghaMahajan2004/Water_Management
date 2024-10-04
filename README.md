# Water Management System

This project is a **Water Management System** designed to streamline and improve the allocation, monitoring, and management of water resources. It provides functionalities for customer management, complaint handling, billing, water testing, and meter monitoring through a user-friendly web interface.

## Project Overview
The main objectives of this system are:
- **Customer Management**: Centralizing customer information for easier management.
- **Water Quality Monitoring**: Testing water samples to ensure safety and compliance with standards.
- **Complaint Handling**: Efficient system for resolving customer complaints.
- **Billing**: Accurately tracking and billing customers based on actual water usage.
- **Data Analytics**: Providing insights into water usage patterns, system performance, and quality through visualizations using Power BI.

### Key Features
1. **User Roles**:
   - Customer Login
   - Employee Login
2. **Complaint Management**: Customers can raise complaints which are tracked and resolved through the system.
3. **Water Meter Monitoring**: Automated meter management and water usage tracking.
4. **Water Quality Testing**: Tracks test results from different water sources.
5. **Billing System**: Calculates customer bills based on water consumption.
6. **Database Triggers and Procedures**:
   - Automated generation of IDs for records.
   - Automatic billing calculations.
   - Meter updates on new customer records.
   - Complaint resolution tracking.

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript (for responsive user interface)
- **Backend**: PHP (handling database interactions and backend logic)
- **Database**: MariaDB (for storing all water management data)
- **Visualizations**: Power BI (for visual insights into water usage, complaints, and system performance)

## Database Design

### Entity-Relationship (ER) Model
- **Customer and Complaints**: Each customer can raise multiple complaints. The `Customer_Id` is a primary key in the `CUSTOMER` table and a foreign key in the `COMPLAINTS` table.
- **Water Sources and Water Testing**: Water sources are linked to testing data. The `Source_Id` in the `WATER_SOURCE` table is a primary key and a foreign key in the `WATER_TESTING` table.
- **Customer and Billing**: Customer details are linked with their billing data. The `Customer_Id` is a foreign key in the `BILLING` table.

### Database Triggers and Procedures
- **Triggers**:
    1. **before_insert_water_source**: Auto-increments the `Source_Id` in the `WATER_SOURCE` table.
    2. **calculate_water_consumption_and_amount**: Automatically calculates water consumption and billing amount in the `BILLING` table.
    3. **insert_meter_record**: Automatically inserts a meter record when a new customer is added.
    
- **Procedures**:
    1. **CountMeterStatus**: Returns the number of active and inactive meters.
    2. **CountNoWaterSupplyComplaints**: Returns the count of complaints related to "No water supply".
    3. **PrintResolvedComplaints**: Lists customer complaints resolved before a specified date.

## Installation and Setup

### Prerequisites
- PHP
- MariaDB/MySQL
- Apache/Nginx (for hosting)
- Power BI (for visualizations)

### Steps to Setup

1. **Clone the repository**:
    ```bash
    git clone https://github.com/your-repo-url/water-management-system.git
    cd water-management-system
    ```

2. **Database Setup**:
    - Import the provided SQL schema (`schema.sql`) to set up the MariaDB database.
    - Ensure your database server is configured correctly with the appropriate user credentials.

3. **Configure Database Connection**:
    Open `config.php` and update your database credentials:
    ```php
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = 'password';
    $dbName = 'water_management';
    ```

4. **Run the application**:
    - Deploy the frontend (`index.html`) on a web server (e.g., Apache or Nginx).
    - Access the system by navigating to `localhost/index.html` in your web browser.

## Usage

### Customer
- **Login**: Customers can log in to the system using their credentials.
- **Profile**: View and update personal details.
- **Complaints**: Submit complaints about water services and track complaint status.
- **Billing**: View current and past bills based on water consumption.

### Admin/Employee
- **Monitor**: View water sources, test results, and system status.
- **Manage Complaints**: Track and resolve customer complaints.
- **Billing Management**: Generate and manage customer bills.
- **Data Analytics**: Visualize key data points using Power BI.

## Power BI Visualizations
- **Bill amount paid by each customer.**
- **Complaints filed by year, month, and day.**
- **Complaints descriptions analysis.**

## Frontend Design

### User Interface Elements
- **Input Forms**: For user input such as complaints and feedback.
- **Navigation**: User-friendly navigation with links to different system sections.
- **Error Handling**: Alerts and error messages for invalid inputs.

### Technologies
- **HTML**: For structuring the web pages.
- **CSS**: For styling and presentation.
- **JavaScript**: For interactive features and form validations.

## Backend Design

### Technologies
- **PHP**: Handles business logic and interaction with the database.
- **MariaDB**: Stores all water management data including customers, complaints, billing, water sources, and tests.

### Triggers and Procedures
- **Triggers**:
    - **before_insert_water_source**: Automatically increments the `Source_Id`.
    - **calculate_water_consumption_and_amount**: Automatically calculates water consumption and billing amounts.
    - **insert_meter_record**: Automatically inserts a meter record when a new customer is added.

- **Procedures**:
    - **CountMeterStatus**: Counts the active and inactive meters.
    - **CountNoWaterSupplyComplaints**: Counts complaints related to no water supply.
    - **PrintResolvedComplaints**: Lists complaints resolved before a given date.

