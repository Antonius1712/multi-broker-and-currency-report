# LGI Collection

**LGI Collection** is an application designed to automate the monthly reporting process. It generates monthly reports, transforms them into Excel files, separates the reports by broker ID and broker name, and organizes the data by currency within the sheets of each generated Excel file.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Cron Job Setup](#cron-job-setup)
- [Contact](#contact)

## Overview
The LGI Collection application simplifies the monthly reporting process by automatically generating reports, converting them into Excel files, and structuring the data based on brokers and currency types. This ensures that each broker receives a report tailored to their specific needs.

## Features
- **Automated Monthly Report Generation**: Automatically generates reports at the end of each month.
- **Excel Transformation**: Converts generated reports into Excel format for easy distribution and analysis.
- **Broker-Based Separation**: Creates separate Excel files for each broker based on broker ID and broker name.
- **Currency Segregation**: Organizes data within each Excel file into separate sheets based on currency type.

## Technology Stack
- **Backend**: [Laravel](https://laravel.com/) - A robust PHP framework for handling server-side logic.
- **Database**: [MSSQL](https://www.microsoft.com/en-us/sql-server/sql-server-downloads) - A reliable relational database management system for storing report data.
- **Excel Generation**: Laravel packages such as [Maatwebsite Excel](https://docs.laravel-excel.com/) for generating and manipulating Excel files.

## Installation

### Prerequisites
- [PHP](https://www.php.net/) >= 7.4
- [Composer](https://getcomposer.org/) for dependency management
- [MSSQL](https://www.microsoft.com/en-us/sql-server/sql-server-downloads) for the database

### Steps
1. **Clone the repository**:
   ```bash
   git clone https://github.com/Antonius1712/LGI-COLLECTION.git
   cd lgi-collection
   ```
2. **Install backend dependencies**:
   ```bash
   composer install
   ```
3. **Environment setup**:
   Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```
   Configure the .env file with your MSSQL database credentials and other environment-specific variables.

4. **Database migration: Run the migrations to set up the required tables in your MSSQL database**:
   ```bash
   php artisan migrate
   ```
5. **Generate application key**:
   ```bash
   php artisan key:generate
   ```
6. **Start the development server**:
   ```bash
   php artisan serve
   ```

## Configuration

Edit the `.env` file to configure your database connection, report generation settings, and other environment-specific parameters. Ensure that the necessary configurations for Excel generation and broker separation are set up correctly.

## Usage

- **Monthly Report Generation**: At the end of each month, the application automatically generates reports.
- **Excel Transformation**: The reports are converted into Excel files, which are then separated by broker ID and broker name.
- **Currency Segregation**: Each Excel file contains sheets organized by different currency types.

## Cron Job Setup

To ensure that the application runs as a scheduled job, set up a cron job on your server:

1. Open the crontab file:
    ```bash
    crontab -e
    ```
2. Add the following line to schedule the job:
    ```bash
    * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
    ```
    Replace /path-to-your-project/ with the actual path to your Laravel project. Adjust the cron timing (* * * * *) based on your scheduling needs.

## Contact

For any questions or support, please reach out to:

- **Name**: Antonius Christian
- **Email**: antonius1712@gmail.com
- **Phone**: +6281297275563
- **LinkedIn**: [Antonius Christian](https://www.linkedin.com/in/antonius-christian/)

Feel free to connect with me via email or LinkedIn for any inquiries or further information.