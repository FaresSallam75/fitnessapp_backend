
//////////////////////////////////
CREATE OR REPLACE VIEW messagesview AS 
SELECT * FROM  messages INNER JOIN users
on messages.sender = users.user_id
OR messages.receiver = users.user_id
INNER JOIN doctors 
ON messages.sender = doctors.doctor_id 
///////////////////////////////////////////

CREATE OR REPLACE VIEW  messagesview AS
SELECT * FROM  messages INNER JOIN users
on messages.sender = users.user_id
OR messages.receiver = users.user_id
INNER JOIN doctors 
ON messages.sender = doctors.doctor_id 
OR messages.receiver = doctors.doctor_id

/////////////////////////////////////////////
CREATE OR REPLACE VIEW chatview AS
SELECT chats.* from chats INNER JOIN users 
ON chats.sender = users.id 
OR chats.reciever = users.id
INNER JOIN coaches 
ON coaches.id = chats.sender
OR coaches.id = chats.reciever 

// update
CREATE OR REPLACE VIEW chatview AS
SELECT chats.*, coaches.*, users.id AS userId, users.name AS userName, users.email AS userEmail,  
users.password AS userPassword
from chats INNER JOIN users 
ON chats.sender = users.id 
OR chats.reciever = users.id
INNER JOIN coaches 
ON coaches.id = chats.sender
OR coaches.id = chats.reciever

