

--ALL Players with jobs itemlevels and roles as int and text
SELECT
*
FROM ep_players as p
JOIN ep_players_jobs as pxj ON p.id = pxj.playerid
JOIN ep_jobs as j ON pxj.jobid = j.id
JOIN ep_roles as r on j.role = r.id;


SELECT
p.id as playerid,
p.charname as player_charname,
p.name as player_name,
p.classes as player_classes,
p.jobs as player_jobs,
p.lodestoneid as player_lodestoneid,
p.misc as player_misc,
pxj.jobid as job_id,
pxj.ilvl as job_ilvl,
j.jobname as job_name,
j.jobshortname as job_shortname,
r.id as role_id,
r.rolename as role_name,
r.roleshortname as role_shortname
FROM ep_players as p
JOIN ep_players_jobs as pxj ON p.id = pxj.playerid
JOIN ep_jobs as j ON pxj.jobid = j.id
JOIN ep_roles as r on j.role = r.id
;

Table: ep_players_jobs
Columns:
id	int(11) PK AI
playerid	int(11)
jobid	int(11)
ilvl	int(11)

DROP TABLE IF EXISTS ep_players_jobs;
CREATE TABLE `db1705936`.`ep_players_jobs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `playerid` INT NULL,
  `jobid` INT NULL,
  `ilvl` INT NULL,
  PRIMARY KEY (`id`));


INSERT INTO `db1705936`.`ep_players_jobs` (`playerid`, `jobid`, `ilvl`) VALUES ('1', '1', '93');
INSERT INTO `db1705936`.`ep_players_jobs` (`playerid`, `jobid`, `ilvl`) VALUES ('1', '9', '94');
INSERT INTO `db1705936`.`ep_players_jobs` (`playerid`, `jobid`, `ilvl`) VALUES ('1', '6', '76');
