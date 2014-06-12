

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
CREATE TABLE `db1705936`.`ep_players_jobs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `playerid` INT NULL,
  `jobid` INT NULL,
  `ilvl` INT NULL,
  PRIMARY KEY (`id`));


INSERT INTO `db1705936`.`ep_players_jobs` (`playerid`, `jobid`, `ilvl`) VALUES ('1', '1', '93');
INSERT INTO `db1705936`.`ep_players_jobs` (`playerid`, `jobid`, `ilvl`) VALUES ('1', '9', '94');
INSERT INTO `db1705936`.`ep_players_jobs` (`playerid`, `jobid`, `ilvl`) VALUES ('1', '6', '76');
