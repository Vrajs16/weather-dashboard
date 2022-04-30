-- DROP DATABASE IF EXISTS weather;
-- DROP DATABASE IF EXISTS user;
-- CREATE DATABASE weather;
-- USE weather;
DROP TABLE IF EXISTS weather_data;

CREATE TABLE weather_data(
    day_id INT NOT NULL,
    city VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    day VARCHAR(255) NOT NULL,
    day_or_night INT(1) NOT NULL,
    temperature_text VARCHAR(255) NOT NULL,
    temperature INT(3) NOT NULL,
    short_description VARCHAR(255) NOT NULL,
    long_description VARCHAR(1000) NOT NULL,
    last_forecast_update DATETIME NOT NULL,
    last_update DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Put some personalization and preferences in this table, 
-- CREATE TABLE user(user_id INT NOT NULL AUTO_INCREMENT, ip_address VARCHAR(255) NOT NULL, preffered_city VARCHAR(255) NOT NULL DEFAULT "parsippany", PRIMARY KEY(user_id),);
-- CREATE TABLE users(
--     ip_addr VARCHAR(50) NOT NULL,
--     saved_city VARCHAR(50) NOT NULL DEFAULT "Parsippany",
--     saved_color CHAR(7) NOT NULL DEFAULT "#0a1f44",
--     PRIMARY KEY (ip_addr)
-- )