--#2
--Drops lab10 if it exists
DROP SCHEMA IF EXISTS lab10 CASCADE;
--#3
--Creates a schema called lab10
CREATE SCHEMA lab10;
--#4
--Sets the search path to lab10
SET search_path = lab10;
--#5
--Createa table for the group standings that includes the team, its wins/losses/draws and its points total. Points must be whole numbers
CREATE TABLE group_standings(
  team varchar(25) NOT NULL PRIMARY KEY,
  wins smallint NOT NULL CHECK(wins >= 0),
  losses smallint NOT NULL CHECK(losses >= 0),
  draws smallint NOT NULL CHECK(draws >= 0),
  points smallint NOT NULL CHECK(points >= 0)

);
--#6
--Imports the lab10 data in CSV format from the address. 
 \copy group_standings FROM /facstaff/klaricm/public_cs3380/lab10/lab10_data.csv WITH CSV HEADER
--#7
--Calculates the points total based off of that 3 points = WIN and 1 point = DRAW zero points for LOSS
CREATE OR REPLACE FUNCTION
calc_points_total(smallint, smallint)
RETURNS integer AS $$
SELECT 3*$1 + $2 AS result;
$$ LANGUAGE SQL;
--#8
--Updates the points total using the calc_points_total function.
CREATE OR REPLACE FUNCTION update_points_total() RETURNS trigger AS $$
BEGIN
  NEW.points := calc_points_total(NEW.wins,NEW.draws);
RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER tr_update_points_total BEFORE INSERT OR UPDATE ON group_standings
FOR EACH ROW EXECUTE PROCEDURE update_points_total();
--#9
--Compares the old and new records for the teams and throws an error if you try to change the name 
CREATE OR REPLACE FUNCTION disallow_team_name_update() RETURNS trigger AS $$
BEGIN IF OLD.team != NEW.team THEN RAISE EXCEPTION;
END IF;
RETURN NEW;
END;
$$ LANGUAGE plpgsql;
--#10
--This triggers before any potential update to the team name
CREATE TRIGGER tr_disallow_team_name_update BEFORE UPDATE ON group_standings FOR EACH ROW EXECUTE PROCEDURE disallow_team_name_update();