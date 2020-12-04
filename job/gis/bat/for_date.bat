@echo off
SETLOCAL ENABLEDELAYEDEXPANSION
color a
echo please input the year you want to create
set /a month_nth=1
set /p "year_nth=>"
for /l %%i in (1,1,12) do (
    if !month_nth! LSS 10 (
        @REM echo yes
        echo !year_nth!-0!month_nth!
        md !year_nth!-0!month_nth!
    ) else (
        echo !year_nth!-!month_nth!
        md !year_nth!-!month_nth!
    )   
    set /a month_nth+=1
)
pause