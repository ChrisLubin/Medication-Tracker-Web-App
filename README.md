# Medication Tracker Web App

This is used so users can login and know when they need to take their medication.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### PHP Config File

Replace the lines below in the [config](https://github.com/ChrisLubin/Medication-Tracker-Web-App/tree/master/App/php/config.php) file with your credentials.

```php
$dbname = ''; // FAU username
$dbuser = ''; // FAU username
$dbpass = ''; // FAU LAMP password
```

### SQL Statements

Run the following SQL statements before using the application.

```sql
CREATE TABLE Users (email varchar(40) NOT NULL, password varchar(60), firstName varchar(20), lastName varchar(20), phone int(15), isDoc bool, PRIMARY KEY(email));
```

## Authors

- **Alexander Alonso** - _Front End_ - [AlexXXV](https://github.com/AlexXXV)
- **Christopher Lubin** - _Front End/Back End_ - [ChrisLubin](https://github.com/ChrisLubin)
- **Dylan Taylor** - _Back End_ - [coldshock](https://github.com/coldshock)
- **Jordan Morant** - _Front End_ - [jmorant2016](https://github.com/jmorant2016)
- **Kelsey Joseph** - _Front End_ - [KelJ27](https://github.com/KelJ27)
- **Natacha Barcala** - _Front End_ - [nabarcala](https://github.com/nabarcala)
