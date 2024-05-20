echo -------------------------
echo mysql backup
echo -------------------------
set year=%date:~0,4%
set month=%date:~5,2%
set day=%date:~8,2%
set peizi_bak_path=peizi_%year%%month%%day%.sql
rem 这里是注释部分 
cd "C:\BtSoft\mysql\MySQL5.5\bin"
mysqldump -uroot -p2kGuNgk8pjUjJ8oi peizi_xiniuhy >c:\bat\%peizi_bak_path%
@echo off 
rem pause 