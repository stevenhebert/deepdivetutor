-- purge tables
-- drop tables in reverse order
DROP TABLE IF EXISTS profileSkill;
DROP TABLE IF EXISTS skill;
DROP TABLE IF EXISTS review;
DROP TABLE IF EXISTS profile;

-- create tables
CREATE TABLE profile (
	-- NOT NULL means they are required
	profileId              INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileName            VARCHAR(50)                 NOT NULL,
	profileEmail           VARCHAR(128)                NOT NULL,
	-- true is 1 false is 0
	profileType            BIT DEFAULT 1               NOT NULL,
	-- profileGithubToken
	profileBio             VARCHAR(500)                NOT NULL,
	profileRate            INT UNSIGNED                NOT NULL,
	-- not sure if image is right
	profileImage           BLOB                        NULL,
	profileLastEditDate    DATETIME(6)                 NOT NULL,
	profileActivationToken CHAR(32)                    NOT NULL,
	profileHash            CHAR(128)                   NOT NULL,
	profileSalt            CHAR(64)                    NOT NULL,
	UNIQUE (profileEmail),
	PRIMARY KEY (profileId)
);

-- create review entity
CREATE TABLE review (
	reviewId               INT UNSIGNED AUTO_INCREMENT NOT NULL,
	reviewStudentProfileId INT UNSIGNED                NOT NULL,
	reviewTutorProfileId   INT UNSIGNED                NOT NULL,
	-- not sure about reviewRating
	reviewRating           INT(5)                      NOT NULL,
	reviewText             VARCHAR(500)                NOT NULL,
	-- should reviewDate be reviewDateTime?
	reviewDate             TIMESTAMP(6)                NOT NULL,
	FOREIGN KEY (reviewStudentProfileId) REFERENCES profile (profileId),
	FOREIGN KEY (reviewTutorProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (reviewId)
);

CREATE TABLE skill (
	skillId   INT UNSIGNED AUTO_INCREMENT NOT NULL,
	skillName VARCHAR(32)                 NOT NULL,
	UNIQUE (skillName),
	PRIMARY KEY (skillId)
);

CREATE TABLE profileSkill (
	profileSkillprofileId INT UNSIGNED NOT NULL,
	profileSkillSkillId   INT UNSIGNED NOT NULL,
	FOREIGN KEY (profileSkillProfileId) REFERENCES profile (profileId),
	FOREIGN KEY (profileSkillSkillId) REFERENCES skill (skillId)
);
