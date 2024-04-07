# Deploy Guide
## Step 1: Set virtual host
Append following code to 'C:\xampp\apache\conf\extra\httpd-vhosts.conf', the path depends on your environment:
```<VirtualHost *:80>
   ServerAdmin liu00638@algonquinlive.com
   DocumentRoot "C:/xampp/htdocs/assignment2"
   ServerName bookmanager.com
   <Directory "C:/xampp/htdocs/assignment2">
       DirectoryIndex pages/index.html
   </Directory>
</VirtualHost>
```

## Step 2 : Set hosts
Append following code to 'C:\Windows\System32\drivers\etc\hosts',
```
127.0.0.1       bookmanager2024.com
```
# Step 3: create database and insert test database
find sql files in ./assignment2/db
book_create.sql: create database
books_insert.sql: insert test data into table books

## Step 4 : Restart XAMPP's apache

# User Guide

# Response Code & Message
| Response Code | Response Message 
| -----:| :---- |
| 0| success|
| 1| login fail: username or password is incorrect|
| 2| client should send POST request|
| 3| db error|
| 4| user does not exist|
| 5| book does not exist|
| 6| book exists|
| 7| insert error|
| 8| no login|

TEST