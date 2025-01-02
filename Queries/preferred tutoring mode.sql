Use team15;
ALTER TABLE Tutors 
ADD preferred_tutoring_mode ENUM('online', 'face-to-face') DEFAULT 'online';
