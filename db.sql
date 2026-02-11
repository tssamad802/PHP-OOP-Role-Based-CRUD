database name 'mydatabase'

CREATE TABLE users (
id int(11) PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(55) NOT NULL,
email VARCHAR(55) NOT NULL,
pwd VARCHAR(555) NOT NULL,
role VARCHAR(55) NOT NULL,
created_at timestamp DEFAULT CURRENT_DATE
);
    CREATE TABLE posts (
    id int(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(55) NOT NULL,
    slug VARCHAR(55) NOT NULL,
    content VARCHAR(55) NOT NULL,
    featured_image VARCHAR(255) NOT NULL,
    user_id int(11) NOT NULL,
    is_deleted VARCHAR(10) DEFAULT 'NULL',
    published_at timestamp DEFAULT CURRENT_DATE
    );
CREATE TABLE categories (
id int(11) PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(55) NOT NULL,
slug VARCHAR(55) NOT NULL,
created_at timestamp DEFAULT CURRENT_DATE
);

CREATE TABLE category_post (
id int(11) PRIMARY KEY AUTO_INCREMENT,
post_id int(11) NOT NULL,
category_id int(11) NOT NULL,
created_at timestamp DEFAULT CURRENT_DATE
);
INSERT INTO `users` (`name`, `email`, `pwd`, `role`) VALUES
('John Doe', 'admin@company.com', 'Admin@123', 'admin'),
('Jane Smith', 'editor@company.com', 'Editor@123', 'editor'),
('Bob Johnson', 'viewer@company.com', 'Viewer@123', 'viewer');
