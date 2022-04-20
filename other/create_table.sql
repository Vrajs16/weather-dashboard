DROP DATABASE weather;

-- DROP DATABASE user;
CREATE DATABASE weather;

USE weather;

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
    last_forecast_update DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_update DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Put some personalization and preferences in this table, 
-- CREATE TABLE user(user_id INT NOT NULL AUTO_INCREMENT, ip_address VARCHAR(255) NOT NULL, preffered_city VARCHAR(255) NOT NULL DEFAULT "parsippany", PRIMARY KEY(user_id),);