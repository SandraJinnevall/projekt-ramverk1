--
-- Creating a User table.
--



--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "acronym" TEXT UNIQUE NOT NULL,
    "displayname" TEXT UNIQUE NOT NULL,
    "password" TEXT,
    "img" TEXT,
    "bio" TEXT,
    "reputation" INTEGER,
    "created" TIMESTAMP,
    "active" DATETIME
);

DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "questionid" INTEGER PRIMARY KEY NOT NULL,
    "userid" INTEGER,
    "title" TEXT,
    "question" TEXT,
    "tags" TEXT,
    "created" TIMESTAMP
);

DROP TABLE IF EXISTS QuestionComment;
CREATE TABLE QuestionComment (
    "questioncommentid" INTEGER PRIMARY KEY NOT NULL,
    "questionid" INTEGER,
    "userid" INTEGER,
    "comment" TEXT,
    "created" TIMESTAMP
);

DROP TABLE IF EXISTS Tags;
CREATE TABLE Tags (
    "tagid" INTEGER PRIMARY KEY NOT NULL,
    "tag" TEXT UNIQUE NOT NULL,
    "reputation" INTEGER,
    "created" TIMESTAMP
);

DROP TABLE IF EXISTS QuestionAnswer;
CREATE TABLE QuestionAnswer (
    "answerid" INTEGER PRIMARY KEY NOT NULL,
    "questionid" INTEGER,
    "userid" INTEGER,
    "answer" TEXT,
    "created" TIMESTAMP
);

DROP TABLE IF EXISTS AnswerComment;
CREATE TABLE AnswerComment (
    "answercommentid" INTEGER PRIMARY KEY NOT NULL,
    "answerid" INTEGER,
    "userid" INTEGER,
    "questionid" INTEGER,
    "answercomment" TEXT,
    "created" TIMESTAMP
);
