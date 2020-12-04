:: md folder by years
:: author by pkcile
:: date by 2020.12.04
@echo off
SETLOCAL ENABLEDELAYEDEXPANSION
color a
echo please input the start year to end year that you want to create.
echo please input the start year:
set /p "start_year_nth=>"
echo please input the end year:
set /p "end_year_nth=>"
set /a change_year=%start_year_nth%
for /l %%i in (!start_year_nth!,1,!end_year_nth!) do (
   echo !change_year!
   md !change_year!
   set /a change_year+=1
)
pause