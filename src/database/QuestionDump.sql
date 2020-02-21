INSERT INTO questions (QuestionText, Category, DateModified, instructorId) VALUES ('What time is it?','Time', CURDATE(), 99 );
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('1','9 AM','1',CURDATE(), TRUE);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('1','10 AM','2',CURDATE(), FALSE);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('1','11 AM','3',CURDATE(), FALSE);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('1','12 PM','4',CURDATE(), FALSE);

INSERT INTO questions (QuestionText, Category, DateModified, instructorId) VALUES ('How old are you?','Age', CURDATE() , 99);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('2','9','1',CURDATE(), FALSE);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('2','10','2',CURDATE(), FALSE);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('2','11','3',CURDATE(), TRUE);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('2','12','4',CURDATE(), FALSE);

INSERT INTO questions (QuestionText, Category, DateModified, instructorId) VALUES ('What bear is best?','Age', CURDATE(), 99);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('3','Brown Bear','1',CURDATE(), FALSE);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('3','Black Bear','2',CURDATE(), TRUE);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('3','Polar Bear','3',CURDATE(), FALSE);
INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) VALUES ('3','Pink Bear','4',CURDATE(), FALSE);
