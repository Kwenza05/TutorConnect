USE team15; 
-- Tutors Table
CREATE TABLE Tutors (
    tutor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    bio TEXT,
    subject_specialization VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tutlings Table
CREATE TABLE Tutlings (
    tutling_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Subjects Table
CREATE TABLE Subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(100) NOT NULL
);

-- Tutors_Subjects Table (Many-to-Many Relationship)
CREATE TABLE Tutors_Subjects (
    tutor_id INT,
    subject_id INT,
    PRIMARY KEY (tutor_id, subject_id),
    FOREIGN KEY (tutor_id) REFERENCES Tutors(tutor_id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES Subjects(subject_id) ON DELETE CASCADE
);

-- Appointments Table
CREATE TABLE Appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    tutor_id INT,
    tutling_id INT,
    subject_id INT,
    date DATE NOT NULL,
    time TIME NOT NULL,
    duration INT NOT NULL,
    location VARCHAR(255),
    status ENUM('scheduled', 'completed', 'canceled') NOT NULL DEFAULT 'scheduled',
    FOREIGN KEY (tutor_id) REFERENCES Tutors(tutor_id) ON DELETE CASCADE,
    FOREIGN KEY (tutling_id) REFERENCES Tutlings(tutling_id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES Subjects(subject_id) ON DELETE CASCADE
);

-- Reviews Table
CREATE TABLE Reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    tutor_id INT,
    tutling_id INT,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tutor_id) REFERENCES Tutors(tutor_id) ON DELETE CASCADE,
    FOREIGN KEY (tutling_id) REFERENCES Tutlings(tutling_id) ON DELETE CASCADE
);

-- Messages Table (For Chat between Users)
CREATE TABLE Messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    sender_type ENUM('tutor', 'tutling') NOT NULL,
    message_body TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES Tutors(tutor_id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES Tutlings(tutling_id) ON DELETE CASCADE
);

-- Chatbot Conversations Table
CREATE TABLE Chatbot_Conversations (
    conversation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    user_type ENUM('tutor', 'tutling') NOT NULL,
    start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_time TIMESTAMP,
    status ENUM('active', 'completed') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES Tutors(tutor_id) ON DELETE CASCADE
);

-- Chatbot Messages Table
CREATE TABLE Chatbot_Messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    conversation_id INT,
    sender_type ENUM('user', 'chatbot') NOT NULL,
    message_body TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conversation_id) REFERENCES Chatbot_Conversations(conversation_id) ON DELETE CASCADE
);

-- Intents Table
CREATE TABLE Intents (
    intent_id INT AUTO_INCREMENT PRIMARY KEY,
    conversation_id INT,
    intent_name VARCHAR(100) NOT NULL,
    confidence DECIMAL(5,2),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conversation_id) REFERENCES Chatbot_Conversations(conversation_id) ON DELETE CASCADE
);
