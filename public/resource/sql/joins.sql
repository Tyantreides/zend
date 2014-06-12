

--ALL Players with jobs itemlevels and roles as int and text
SELECT
*
FROM ep_players as p
JOIN ep_players_jobs as pxj ON p.id = pxj.playerid
JOIN ep_jobs as j ON pxj.jobid = j.id
JOIN ep_roles as r on j.role = r.id;


Table: ep_players_jobs
Columns:
id	int(11) PK AI
playerid	int(11)
jobid	int(11)
ilvl	int(11)

DROP TABLE IF EXISTS ep_players_jobs;
CREATE TABLE ep_players_jobs (
  id int(11) PK AI,
  playerid int(11) ,
  jobid varchar(6) COLLATE latin1_german1_ci NOT NULL,
  ilvl	int(11) ,
  PRIMARY KEY (id)
);