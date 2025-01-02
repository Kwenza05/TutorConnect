
use team15;
CREATE TABLE Messages (
    tutor_id INT,
    tutling_id INT,
    message_text TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (tutor_id, tutling_id, sent_at),
    FOREIGN KEY (tutor_id) REFERENCES Tutors(tutor_id),
    FOREIGN KEY (tutling_id) REFERENCES Tutlings(tutling_id)
);
