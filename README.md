# Group 2.3 - COS20031-Computing Technology Design Project

### Group Members

-   Nguyen Hoang Nguyen
-   Nguyen Huu Duc Anh
-   Nguyen Dang Duc Anh
-   Truong Minh Son
-   Nguyen Cuong Nhat (Leader)

### Project Introduction

[Click here to see the Introduction](Introduction.md)

## Table of Contents

1. [Home](#home)
2. [Courses](#courses)
    1. [Paid Courses](#paid-courses)
    2. [Search for Courses](#search-for-courses)
    3. [Submit](#submit-courses)
3. [Jobs](#jobs)
    1. [Details](#job-details)
    2. [Submit](#submit-jobs)
4. [Logout](#logout)
5. [Upload Job](#upload-job)
6. [Apply for Jobs](#apply-for-jobs)
7. [Registered Courses](#registered-courses)
8. [Interview Schedule](#interview-schedule)
9. [Contact](#contact)
10. [Create your candidate profile](#create-your-candidate-profile)
11. [Enhanched Search (Using Elastic Search)](#enhanced-search)

## Home

[Click here to see the code](index.php)

-   The homepage is the first page that the user will see when they access the website.
-   Links to other pages are displayed on homepage:
    -   [Courses](#courses)
    -   [Jobs](#jobs)
    -   [Logout](#logout)
    -   [Upload Job](#upload-job)
    -   [Apply for Jobs](#apply-for-jobs)
    -   [Registered Courses](#registered-courses)
    -   [Interview Schedule](#interview-schedule)
    -   [Contact](#contact)
    -   [Create your candidate profile](#create-your-candidate-profile)

## Courses

[Click here to see the code](courses.php)

-   The courses page displays all the courses that are available on the website.
-   Links to other pages are displayed on courses page:
    -   [Home](#home)
    -   [Paid Courses](#paid-courses)
    -   [Search for Courses](#search-for-courses)
    -   [Submit](#submit-courses)
    -   [Enhanched Search (Using Elastic Search)](#enhanced-search)

# Jobs

[Click here to see the code](jobs.php)

-   The jobs page displays all the jobs that are available on the website.
-   Links to other pages are displayed on jobs page:
    -   [Home](#home)
    -   [Job Details](#job-details)
    -   [Submit](#submit-jobs)
    -   [Enhanched Search (Using Elastic Search)](#enhanced-search)

## Logout

[Click here to see the code](logout.php)

## Upload Job

Todo: Complete the README.md

## What You Should Have Before Run

Before running the application, ensure you have the following installed:

-   XAMPP on Windows: This is a free and open-source cross-platform web server solution stack package, mainly used for web development projects.
-   Python: This is a high-level, interpreted programming language with easy syntax and dynamic semantics.
-   Elastic Search: This is a search engine based on the Lucene library. It provides a distributed, multitenant-capable full-text search engine with an HTTP web interface and schema-free JSON documents.

## How to Run

To run the application, follow these steps:

1. Create `key.php` and `key.py` in the `secret` folder.

2. Complete the following fields:

### In `key.php`, create a class `DB` with the following constants:

```php
class DB {
    const HOST = "your-host-url";
    const USER = "your-username";
    const PSWD = "your-password";
    const DBNM = "your-database";
}
```

### In key.py, define the following variables:

```python
ENDPOINT = "your-elastic-endpoint-url"
USERNAME = "your-username"
PASSWORD = "your-password"
CERT_FINGERPRINT = "your-fingerprint"
```
