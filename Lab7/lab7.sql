/*
1. This query utilized an index because PSQl creates an index on the primary key once it is generated.
This is done to increase the efficiency of the primary key.
*/

/*Q2*/
EXPLAIN ANALYZE SELECT * FROM banks WHERE state = 'Missouri';
/*
                                               QUERY PLAN

----------------------------------------------------------------------------------------------------
----
 Seq Scan on banks  (cost=0.00..894.98 rows=996 width=124) (actual time=0.388..15.077 rows=996 loops
=1)
   Filter: ((state)::text = 'Missouri'::text)
 Total runtime: 16.139 ms
(3 rows)

*/
 CREATE INDEX ON banks(state);
 EXPLAIN ANALYZE SELECT * FROM banks WHERE state = 'Missouri';
 /*Q2 Cont.
                                                      QUERY PLAN

----------------------------------------------------------------------------------------------------
-------------------------
 Bitmap Heap Scan on banks  (cost=23.97..598.42 rows=996 width=124) (actual time=0.405..3.236 rows=9
96 loops=1)
   Recheck Cond: ((state)::text = 'Missouri'::text)
   ->  Bitmap Index Scan on banks_state_idx  (cost=0.00..23.72 rows=996 width=0) (actual time=0.329.
.0.329 rows=996 loops=1)
         Index Cond: ((state)::text = 'Missouri'::text)
 Total runtime: 4.244 ms
(5 rows)
Time = 4.244ms - 16.139ms = 11.895ms faster or a 73.7035% improvement
 */
 /*Q3*/
SELECT * FROM banks ORDER BY name;
EXPLAIN ANALYZE SELECT name FROM banks ORDER BY name;
/* 													QUERY PLAN

----------------------------------------------------------------------------------------------------
-------------
 Sort  (cost=3523.15..3592.14 rows=27598 width=29) (actual time=335.918..402.064 rows=27598 loops=1)
   Sort Key: name
   Sort Method: external merge  Disk: 1064kB
   ->  Seq Scan on banks  (cost=0.00..825.98 rows=27598 width=29) (actual time=0.015..37.788 rows=27
598 loops=1)
 Total runtime: 429.056 ms
(5 rows)
*/
CREATE INDEX ON banks(name);
EXPLAIN ANALYZE SELECT name FROM lab7.banks ORDER BY name;
/*Q3Cont
                                                             QUERY PLAN

----------------------------------------------------------------------------------------------------
--------------------------------
 Index Scan using banks_name_idx on banks  (cost=0.00..3294.27 rows=27598 width=124) (actual time=0.
067..47.662 rows=27598 loops=1)
 Total runtime: 75.612 ms
(2 rows)
Time = 75.612ms - 429.056ms = 353.444ms or 82.3771% improvement
*/
/*Q4*/
CREATE INDEX ON banks(is_active);
/*Q5*/
SELECT * FROM banks WHERE is_active = TRUE;
EXPLAIN ANALYZE SELECT * FROM banks WHERE is_active = TRUE;
/*Q5Cont
                                                QUERY PLAN

----------------------------------------------------------------------------------------------------
------
 Seq Scan on banks  (cost=0.00..825.98 rows=6776 width=124) (actual time=0.024..13.036 rows=6776 loo
ps=1)
   Filter: is_active
 Total runtime: 19.543 ms
(3 rows)

*/
SELECT * FROM banks WHERE is_active = FALSE;
EXPLAIN ANALYZE SELECT * FROM banks WHERE is_active = FALSE;
/*Q5Cont
                                                 QUERY PLAN

----------------------------------------------------------------------------------------------------
--------
 Seq Scan on banks  (cost=0.00..825.98 rows=20822 width=124) (actual time=0.012..25.240 rows=20822 l
oops=1)
   Filter: (NOT is_active)
 Total runtime: 45.241 ms
(3 rows)


When is_active = true is run, an index is used during the query. This is true because it is more efficient to use an index on the smaller 
subset of values.
When the false query is ran, it makes more sense to use a sequential search because of the amount of overhead associated with running
the query for the size of the data set (the amount of banks that are not active > banks that are active).
*/
/*Q6*/
SELECT * FROM banks WHERE insured >= '2000-01-01';
EXPLAIN ANALYZE SELECT * FROM banks WHERE insured >= '2000-01-01'::date;
/*Q6Cont
                                           QUERY PLAN

----------------------------------------------------------------------------------------------------
-----
 Seq Scan on banks  (cost=0.00..894.98 rows=1450 width=124) (actual time=1.850..8.109 rows=1451 loop
s=1)
   Filter: (insured >= '2000-01-01'::date)
 Total runtime: 9.554 ms
(3 rows)
*/
CREATE INDEX ON banks(insured) WHERE insured != '1934-01-01'::date;
EXPLAIN ANALYZE SELECT * FROM banks WHERE insured >= '2000-01-01'::date;
/*Q6Cont
                                                            QUERY PLAN

----------------------------------------------------------------------------------------------------
-------------------------------
 Index Scan using banks_insured_idx on banks  (cost=0.00..573.89 rows=1450 width=124) (actual time=0
.051..2.215 rows=1451 loops=1)
   Index Cond: (insured >= '2000-01-01'::date)
 Total runtime: 3.653 ms
(3 rows)
Time= 3.653ms - 9.554ms = 5.901ms faster or 61.7647% improvement
*/
/*Q7*/
EXPLAIN ANALYZE SELECT id, name, city, state, assets, deposits FROM banks WHERE deposits != 0 AND (assets/deposits) < 0.5;
/*Q7Cont
															QUERY PLAN
----------------------------------------------------------------------------------------------------
-----------
 HashAggregate  (cost=1055.88..1147.54 rows=9166 width=63) (actual time=42.361..42.451 rows=46 loops
=1)
   ->  Seq Scan on banks  (cost=0.00..1032.97 rows=9166 width=63) (actual time=31.402..42.228 rows=4
6 loops=1)
         Filter: ((deposits <> 0::numeric) AND ((assets / deposits) < 0.5))
 Total runtime: 42.681 ms
(4 rows)
*/
/*Q7Cont*/
CREATE INDEX ON banks((assets/deposits)) WHERE deposits != 0;
EXPLAIN ANALYZE SELECT id, name, city, state, assets, deposits FROM banks WHERE deposits != 0 AND (assets/deposits) < 0.5;
/*Q7Cont
                                                          QUERY PLAN

----------------------------------------------------------------------------------------------------
--------------------
 HashAggregate  (cost=744.09..835.75 rows=9166 width=63) (actual time=0.260..0.364 rows=46 loops=1)
   ->  Bitmap Heap Scan on banks  (cost=10.77..721.18 rows=9166 width=63) (actual time=0.062..0.153
rows=46 loops=1)
         Recheck Cond: ((deposits <> 0::numeric) AND ((assets / deposits) < 0.5))
         ->  Bitmap Index Scan on ratio  (cost=0.00..8.48 rows=9166 width=0) (actual time=0.046..0.0
46 rows=46 loops=1)
 Total runtime: 0.519 ms
(5 rows)
Time = .519ms - 42.681ms = 42.162ms faster or 98.7840% improvement
*/