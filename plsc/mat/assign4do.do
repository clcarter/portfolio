* start log
log using C:\users\clcarter\WSTATA\assign4windFarm.log

* import excel spreadsheet, use sheet WM1 and make first row variable names
import excel C:\Users\clcarter\WSTATA\wm1.xls, sheet("WM1") firstrow

/*	Format Date 
	This process allows STATA to use the date as a 
	variable while still making it human readable
*/
* change first 2 slashes with dashes
replace Date = subinstr(Date,"/", "-" , 2 )

* replace remaining slash with space
replace Date=subinstr(Date , "/" ," ",.)

* add ":00" to hour (at end of value)
replace Date=Date+":00"

* generate a new variable in clock format using formatted Date variabe and in "YMDhm" format
gen double realTime= clock(Date, "YMDhm" )

* format the clock type to human readable time
format realTime %tcDD_mon_CCYY_HH

twoway(scatter RSpd realTime)(lfit RSpd realTime)

twoway(scatter CSpd realTime)(lfit CSpd realTime)

twoway(scatter RSpd CSpd)(lfit RSpd CSpd)
twoway(scatter CSpd RSpd)(lfit CSpd RSpd)

reg CSpd RSpd
predict CSpdyhat
predict CSpduhat, res
reg RSpd CSpd
predict RSpdyhat
predict RSpduhat, res
reg RSpd realTime
predict RSpdrealTimeyhat
predict RSpdrealTimeuhat, res
reg CSpd realTime
predict CSpdrealTimeyhat
predict CSpdrealTimeuhat, res

pwcorr CSpd realTime, sig
pwcorr RSpd realTime, sig
pwcorr CSpd RSpd, sig
pwcorr RSpd CSpd, sig

corr CSpd realTime
corr RSpd realTime
corr CSpd RSpd
corr RSpd CSpd

corr CSpd realTime, cov
corr RSpd realTime, cov
corr CSpd RSpd, cov
corr RSpd CSpd, cov

log close




