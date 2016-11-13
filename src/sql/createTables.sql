USE cinf201_cmdaly;

CREATE TABLE IF NOT EXISTS soc_users(
  id            INT(11)         AUTO_INCREMENT,

  username      VARCHAR(255)    UNIQUE,
  password      VARCHAR(255),

  email         VARCHAR(255),

  first_name    VARCHAR(255),
  last_name     VARCHAR(255),

  PRIMARY KEY (id),

  INDEX (username),
  INDEX (email),
  INDEX (first_name),
  INDEX (last_name)
);

CREATE TABLE IF NOT EXISTS soc_posts(
  id              INT(11)         AUTO_INCREMENT,
  author_id       INT(11),
  recipient_id    INT(11),

  message         VARCHAR(500),

  time_posted     DATETIME,

  PRIMARY KEY (id),
  FOREIGN KEY (author_id) REFERENCES soc_users (id),
  FOREIGN KEY (recipient_id) REFERENCES soc_users (id),

  INDEX (time_posted)
);

CREATE TABLE IF NOT EXISTS soc_friends(
  user_id     INT(11),
  friend_id   INT(11),

  FOREIGN KEY (user_id) REFERENCES soc_users (id),
  FOREIGN KEY (user_id) REFERENCES soc_users (id)
);

