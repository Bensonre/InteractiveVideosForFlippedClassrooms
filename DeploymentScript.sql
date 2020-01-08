-------------------------------------------------------------------Create Tables with Primary and Forgien Keys-------------------------------------------------------------------------------------------------
-- This Table was added to satisfy forgien key requirements
Create Table Instructors(
    ID int NOT NULL,
    PRIMARY Key (ID)
);

-- This Table was added to satisfy forgien key requirements
CREATE TABLE Students(
    ID int NOT NULL,
    PRIMARY Key (ID)
);


CREATE TABLE Videos (
    ID int NOT NULL,
    InstructorID int NOT NULL,
    FilePath VARCHAR(Max) NOT NULL,
    Title VARCHAR(255),
    DateModified Date,
    PRIMARY KEY (ID),
    FOREIGN KEY (InstructorID) REFERENCES Instructors(ID)
);

Create Table Questions (
    ID int NOT NULL,
    QuestionText VARCHAR(Max) NOT NULL,
    Catagory VARCHAR(255),
    DateModified Date,
    PRIMARY KEY (ID)
);

CREATE Table Packages(
    ID int not NULL,
    DateModified Date,
    Title VARCHAR(255),
    PRIMARY KEY (ID)
);

Create Table Video_Questions (
    ID int NOT NULL,
    VideoID int,
    QuestionID int,
    PackageID int,
    QuestionTimeStamp int,
    PRIMARY KEY (ID),
    FOREIGN KEY (VideoID) REFERENCES Videos(ID),
    FOREIGN KEY (QuestionID) REFERENCES Questions(ID),
    FOREIGN KEY (PackageID) REFERENCES Packages(ID),
);

Create Table Choices (
    ID int NOT NULL,
    QuestionID int NOT NULL,
    ChoiceText VARCHAR(255) NOT NULL,
    ChoiceOrder int NOT NULL, --I find this unessary but it was in our design doc so I have included it
    DateModified Date,
    PRIMARY KEY (ID),
    FOREIGN KEY (QuestionID) REFERENCES Questions(ID),
);

Create Table StudentAnswers (
    ID int NOT NULL,
    QuestionID int NOT NULL,
    ChoiceID int NOT NULL,
    SudentID int NOT NULL,
    AnswerDate Date,
    PRIMARY KEY (ID),
    FOREIGN KEY (QuestionID) REFERENCES Questions(ID),
    FOREIGN KEY (ChoiceID) REFERENCES Choices(ID),
    FOREIGN KEY (StudentID) REFERENCES Students(ID),
);
----------------------------------------------------------------------------------Add values to tables-----------------------------------------------------
--TODO*