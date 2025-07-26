CREATE TABLE community (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE likes (
    id SERIAL PRIMARY KEY,
    comment_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (comment_id, user_id),
    FOREIGN KEY (comment_id) REFERENCES community(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);


ALTER TABLE likes
DROP CONSTRAINT likes_comment_id_fkey,
ADD CONSTRAINT likes_comment_id_fkey FOREIGN KEY (comment_id) REFERENCES community(id) ON DELETE CASCADE;


CREATE TABLE profile (
    user_id SERIAL PRIMARY KEY,
    stress_level INT NOT NULL,
    anxiety_level INT NOT NULL,
    sleep_quality INT NOT NULL,
    exercise_frequency VARCHAR(20) NOT NULL,
    diet_quality VARCHAR(20) NOT NULL,
    social_interaction_level VARCHAR(20) NOT NULL,
    mental_health_status VARCHAR(20) NOT NULL,
    mood_level INT NOT NULL,
    coping_strategies TEXT NOT NULL,
    professional_help BOOLEAN NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE mental_health_centers (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    latitude FLOAT NOT NULL,
    longitude FLOAT NOT NULL
);



INSERT INTO mental_health_centers (name, address, latitude, longitude) VALUES
('MindCare Center', '123 Wellness Road, Chennai, Tamil Nadu', 13.0827, 80.2707),
('Healing Minds Clinic', '45 Health Street, Coimbatore, Tamil Nadu', 11.0168, 76.9558),
('Peaceful Minds Institute', '789 Serenity Lane, Madurai, Tamil Nadu', 9.9251, 78.1198),
('Mental Health Hub', '234 Recovery Avenue, Salem, Tamil Nadu', 11.6643, 78.1460),
('Harmony Mental Health Center', '56 Support Street, Tiruchirappalli, Tamil Nadu', 10.7905, 78.7047),
('Balance Life Clinic', '12 Wellness Park, Erode, Tamil Nadu', 11.3410, 77.7173),
('Tranquil Minds Facility', '89 Calm Road, Vellore, Tamil Nadu', 12.9165, 79.1324),
('Serenity Mental Health Care', '34 Peaceful Plaza, Tirunelveli, Tamil Nadu', 8.7108, 77.7369),
('Wellbeing Center', '90 Harmony Lane, Kanyakumari, Tamil Nadu', 8.4334, 77.6374),
('Resilience Clinic', '7 Recovery Road, Puducherry, Tamil Nadu', 11.9416, 79.8083);

