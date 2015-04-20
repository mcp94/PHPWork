--mcpv49 LAB9
--Query1
--Returns the states that intersect a rectangular polygon at the provided coordinates
SELECT name10 AS name FROM tl_2010_us_state10 WHERE ST_Intersects(coords,ST_SetSRID(ST_MakeBox2D(ST_Point(-110, 35), ST_Point(-109, 36)), 4326));
--Query2
--Returns the states that touch North Carolina 
SELECT stusps10 AS USPS, name10 AS name FROM tl_2010_us_state10 WHERE ST_Touches(coords, (SELECT coords FROM tl_2010_us_state10 WHERE stusps10 IN ('NC'))) ORDER BY name ASC;
--Query3
--Returns the names of urban areas in Colorado in ALPHABETICAL order
SELECT name10 AS name FROM tl_2010_us_uac10 WHERE ST_Within(coords,(SELECT coords FROM tl_2010_us_state10 WHERE stusps10 IN ('CO'))) ORDER BY name ASC;
--Query4
--Returns the names and combined area of all urban areas that overlap part of Pennsylvania, but not entirely in it
SELECT name10 AS name, ((aland10 + awater10)*.001) AS area FROM tl_2010_us_uac10 WHERE ST_Overlaps(coords,(SELECT coords FROM tl_2010_us_state10 WHERE stusps10 IN ('PA'))) ORDER BY area DESC;
--Query5
--Returns the urban areas that intersect one another but only returns one set
SELECT one.name10 AS nameOne, two.name10 AS nameTwo FROM tl_2010_us_uac10 AS one, tl_2010_us_uac10 AS two WHERE ST_Intersects(one.coords, two.coords) AND  one.gid != two.gid AND one.gid < two.gid;
--Query6
--Returns all combined areas with an area greater than 1500Km AND intersect multiple states
SELECT u.name10, COUNT(ST_Intersects(s.coords,u.coords)) AS statesInterCount FROM tl_2010_us_uac10 AS u CROSS JOIN tl_2010_us_state10 AS s WHERE ST_Intersects(s.coords,u.coords) GROUP BY u.gid HAVING (u.aland10+u.awater10)/1000000 > 1500 and count(ST_Intersects(s.coords,u.coords)) > 1 ORDER BY statesInterCount, u.name10;