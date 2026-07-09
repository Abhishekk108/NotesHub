# NotesHub

NotesHub is a simple Notes Management System built with Core PHP and MySQL. It is designed as a beginner-friendly project to practice CRUD operations, PDO, prepared statements, and clean project organization.

## Overview

This project helps users:
- create, view, edit, and delete notes
- organize notes by category
- manage categories efficiently
- explore basic PHP and database integration concepts

## Features

- Dashboard with summary statistics
- Create, read, update, and delete notes
- Manage categories
- Search and filter notes
- Clean and modular file structure

## Tech Stack

- PHP 8+
- MySQL
- PDO
- HTML5
- CSS3
- Bootstrap 5
- JavaScript

## Project Structure

```text
noteshub/
├── assets/
├── categories/
├── config/
├── database/
├── includes/
├── notes/
├── index.php
├── context.md
├── README.md
└── .gitignore
```

## Prerequisites

Before running the project, make sure you have the following installed:
- XAMPP or WAMP
- Apache and MySQL running
- PHP 8+
- A web browser

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/noteshub.git
   ```

2. Move the project folder into your local web server directory, such as:
   - XAMPP: `htdocs`

3. Start Apache and MySQL from XAMPP.

4. Import the database schema from the SQL file located in:
   - `database/noteshub.sql`

5. Update the database connection settings in:
   - `config/db.php`

6. Open the project in your browser:
   ```text
   http://localhost/noteshub/
   ```

## Database Configuration

Make sure your database credentials match your local environment, such as:
- host: `localhost`
- database name: `noteshub`
- username: `root`
- password: empty (for local XAMPP default)

## Usage

Once the project is running, you can:
- view the dashboard
- add new notes
- manage categories
- edit or delete existing notes

## Development Notes

The project follows a simple structure with reusable includes and separate files for pages and logic. It is intended for learning and further development.

## Contributing

Contributions are welcome. If you would like to improve the project:
1. Fork the repository
2. Create a new branch
3. Make your changes
4. Submit a pull request

## License

This project is intended for educational and personal use.
