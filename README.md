# PHP Cron Job Runner & Monitor

This is a simple and extensible PHP-based Cron Job Runner and Monitor system. It allows you to define, execute, and track scheduled tasks (cron jobs) with automatic logging and error handling.

## Features

- Register unlimited jobs with a unique name and a callback
- Run all or selected jobs from a runner script
- Monitor execution status, time, and errors
- Log success or failure in structured log files
- Customizable logging path and format
- Lightweight and framework-independent

## Usage

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/php-cron-runner.git
```

### 2. Include the main class

require_once "classes/CronRunner.php";

### 3. Register jobs and execute them

```php
use App\Cron\CronRunner;

$cron = new CronRunner();

// Register a job with a name and a callable function
$cron->addJob("clean_temp", function () {
    // Your task code here
    unlink("/path/to/temp/file.txt");
});

$cron->addJob("send_reminder", function () {
    // Code to send email reminders
    mail("admin@example.com", "Daily Reminder", "This is your task.");
});

// Run all registered jobs
$cron->runAll();

```

### 4. Logs

Each job’s execution result is stored in the /logs/cron/ folder with daily log files like cron-2025-05-13.log. The log contains job name, status, timestamp, and error messages if any.

## License

This project is licensed under the MIT License – see the LICENSE file for details.

## Author

Developed by Mohamad Zangane
