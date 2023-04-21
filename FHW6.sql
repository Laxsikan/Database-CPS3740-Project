

drop function if exists CPS3740_2023S.fHW_8_manoranl;

delimiter //
create function CPS3740_2023S.fHW_8_manoranl(year int, sid int) returns varchar(1023)
begin

    declare res varchar(1023);
    declare count int;
    declare creditamt int;
    set creditamt = 100;
    declare price int;
    select count(*) into count from dreamhome.Students s, dreamhome.Students_Courses sc where s.sid = sid and sc.year = year;

    if (year is null or year is empty) then
        select "Please input a valid year" into res;
    else if (sid is null or sid is empty) then
        select "Please input a valid student id" into res;
    else if "*" not in sid and "*" not in year then
        select creditamt * sum(c.credits) as price into price from dreamhome.Students s, dreamhome.Students_Courses sc, dreamhome.Courses c where s.sid = sc.sid and sc.cid = c.cid and s.sid = sid and sc.year = year;
        select concat("Total payment amount for student ID ", sid, " in year ", year, " is ", price) into res;
    else if "*" in sid then
        select creditamt * sum(c.credits) as price into price from dreamhome.Students s, dreamhome.Students_Courses sc, dreamhome.Courses c where s.sid = sc.sid and sc.cid = c.cid and sc.year = year;
        select concat("Total payment amount for all students in year ", year, " is ", price) into res;
    else if "*" in year then
        select creditamt * sum(c.credits) as price into price from dreamhome.Students s, dreamhome.Students_Courses sc, dreamhome.Courses c where s.sid = sc.sid and sc.cid = c.cid and s.sid = sid;
        select concat("Total payment amount for student ID ", sid, " in all years is ", price) into res;
    else if (count < 1) then
        select concat("No record found for student id: ", sid " at year: ", year) into res;
    end if;

end
// delimiter ;
select CPS3740_2023S.fHW_8_manoranl('', 1002) as output;
select CPS3740_2023S.fHW_8_manoranl(2017, '') as output;
 select CPS3740_2023S.fHW_8_manoranl(2000,1001) as output;
 SELECT CPS3740_2023S.fHW_8_manoranl(2020, 1);
 
 DESC dreamhome.Students;
DESC dreamhome.Courses;
DESC dreamhome.Students_Courses;

 select * FROM dreamhome.Students_Courses;
 select * FROM dreamhome.Courses;
 