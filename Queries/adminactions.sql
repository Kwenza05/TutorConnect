use team15;
CREATE TABLE AdminActions (
    action_id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT,
    tutor_id INT DEFAULT NULL,
    tutling_id INT DEFAULT NULL,
    action_type VARCHAR(50),
    action_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES Admins(admin_id),
    FOREIGN KEY (tutor_id) REFERENCES Tutors(tutor_id),
    FOREIGN KEY (tutling_id) REFERENCES Tutlings(tutling_id)
);
