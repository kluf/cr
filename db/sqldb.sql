CREATE TABLE ReviewersTime(
id INTEGER PRIMARY KEY NOT NULL,
TimePerioud CHAR(13) NOT NULL);

CREATE TABLE state(
id integer primary key NOT NULL,
name varying charachter(255) NOT NULL);

CREATE TABLE usergroups(
id INTEGER PRIMARY KEY NOT NULL,
name VARYING CHARACTER(255) NOT NULL);

CREATE TABLE codereview(
id integer primary key NOT NULL,
creationdate datetime NOT NULL,
changeset varying charachter(255) NOT NULL,
jiraticket varying charachter(255) NOT NULL,
authorcomments text NOT NULL,
reviewercomments text NOT NULL,
stateid integer NOT NULL,
authorid integer NOT NULL,
reviewerid integer NOT NULL,
reviewertraineeid integer NOT NULL,
replacementid integer NOT NULL,
originreviewerid integer NOT NULL,
foreign key(stateid) references state(id),
foreign key(authorid) references users(id),
foreign key(reviewerid) references users(id),
foreign key(reviewertraineeid) references users(id),
foreign key(replacementid) references users(id),
foreign key(originreviewerid) references users(id));

CREATE TABLE schedule(
id INTEGER PRIMARY KEY NOT NULL,
Reviewer INTEGER NOT NULL,
TraineeBackupId INTEGER NOT NULL,
ReplacementReviewerId INTEGER NOT NULL,
OriginalReviewerId INTEGER NOT NULL,
DesignReviewerId INTEGER NOT NULL,
DesignTraineeReviewerId INTEGER NOT NULL,
DateOfSchedule DATE("MM-DD-YYYY") NOT NULL,
TimeReference INTEGER NOT NULL,
FOREIGN KEY(Reviewer) REFERENCES users(id),
FOREIGN KEY(TraineeBackupId) REFERENCES users(id),
FOREIGN KEY(ReplacementReviewerId) REFERENCES users(id),
FOREIGN KEY(OriginalReviewerId) REFERENCES users(id),
FOREIGN KEY(DesignReviewerId) REFERENCES users(id),
FOREIGN KEY(DesignTraineeReviewerId) REFERENCES users(id),
FOREIGN KEY(TimeReference) REFERENCES ReviewersTime(id));

CREATE TABLE users(
id integer primary key NOT NULL,
ldap varying charachter(255) NOT NULL,
email varying charachter(255) NOT NULL,
password varyiing charachter(255) NOT NULL,
groupid integer NOT NULL,
foreign key(groupid) references usergroups(id))