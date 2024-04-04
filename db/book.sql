CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    role ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn VARCHAR(13),
    publish_date DATE,
    genre VARCHAR(100),
    description TEXT,
    img VARCHAR(255),
    score DOUBLE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE userbooks (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    bookid INT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE bookcomments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bookid int NOT NULL,
	userid int NOT NULL,
	comments text,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- test
--update books set author=SUBSTRING_INDEX(author, ' / ', 1);
--update books set isbn=UPPER(LEFT(MD5(id),10));
--update books set publish_date=DATE_ADD('1970-01-01', INTERVAL FLOOR(RAND() * (DATEDIFF('2023-12-31', '1970-01-01')+1)) DAY);
--update books set genre=ELT(FLOOR(1 + (RAND() * 9)), 'Science', 'Nature', 'Geography','Philosophy','Astronomy','History','Literature','Politics','Economics');
--update books set description=concat('I am description ',id);