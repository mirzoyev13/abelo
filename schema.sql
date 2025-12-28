CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255),
    title VARCHAR(255) NOT NULL,
    description TEXT,
    content TEXT,
    views INT DEFAULT 0,
    published_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE article_category (
    article_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (article_id, category_id),
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
