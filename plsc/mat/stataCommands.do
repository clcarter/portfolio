/* 
*	Multi
*	Line
*	Comment
*/

* Single line comment -- only works at start of line
// single line comment

*  Remember that stata is whitespace sensitive. This means that when you have a single entity such as a varable name or a path or when you are changing the description of a variable, if you need to insert a space you must encapsulate the entity in quotes.

* *****
*  Basic Commands
*

help command // shows help file for command
clear // clear data set
exit // exit stata (only works when dataset is clear)
do C:\path\file.do // execute do file file.do at specified location
* (use "" around path -- "C:\my path\my file.do" -- if there are spaces in the path or else stata will think the path is 'C:\my' and that 'path\my' is the next argument)

doedit // open do editor to create a do file
edit // open table of current dataset as read writable
browse // open table of current dataset as read only



* ***** 
* Logging stata commands
*

log using C:\path\file.log // create a log with name file.log at the specified location
log using C:\path\file.log, name(newlog) // create log and give it a name for stata to reference (this allows you to use multiple logs if you want to)
log close // close log
log close newlog // close named log



* *****
* Importing Data
*

sysuse auto // use system provided data set
use data.dta // import the dataset data.dta
import excel using C:\path\file.xls // import dataset from the excel file file.xls make no changes to the sheet
import excel C:\Users\clcarter\WSTATA\wm1.xls, sheet("WM1") firstrow // import the sheet named WM1 in the excel file with the first row as the variable names



* *****
* Common data types
*
* This is useful if you want to change the type of variable (like a string to a number or date etc)

*                     Minimum              Maximum
* byte                   -127                  100  for small whole numbers
* int                 -32,767               32,740  for whole number sets between this min max range
* long         -2,147,483,647        2,147,483,620  for whole numbers that are to big to fit in the int range
* float  -1.70141173319*10^38  1.70141173319*10^38  for numbers with decimals
* double -8.9884656743*10^307  8.9884656743*10^307  for numbers with decimals that are too big for the float range (date and time variable are good to set as doubles

* Strings	Max length
* str1              1
* str2              2
* ..                .
* ..                .
* str244          244



* *****
* Data manipulation
*

gen varName=1 // generate new variable called varName with all values set to 1
gen varName=varName2 // generate new variable varName with all values set to values of varName2
gen varName=varName2 if ... // generate new variable varName with all values set to values of varName2 conditional on specifications of if statement
gen double varName=1.89 // generate variable varName as a double and set all values to 1.89 (without specifying double here the data type would be set to float be default

replace varname=1 // replace all values of varname to value of 1
replace varname=1 if... // replace values of varname conditional to the specifications of the if statement

rename varName newName // rename variable price to newName use "" around newName for a new variable name with a space in it

label variable varName "new label" // change the label (description) of the variable varName



* *****
* Analyze data
*

describe // or
desc	// describes the data set
desc variableName // describe specific variable within data set

count // # of observations

summarize // or
sum // Summarizes the data set giving observations, means, std. devs, min, and max
sum price // summarizes variable price
sum varName, detail // similar to describe variable
sum varName1 varName2

* Conditional commands examples (the if statement)

sum price if mpg == 8 // is equalTo -- one equals tries to set mpg to 8
sum price if mpg <= 8 // greaterThanOrEqualTo
sum price if mpg >= 8 // lessThanOrEqualTo
sum price if mpg > 8	// lessThan
sum price if mpg < 8	// greaterThan

tabulate
tab varName // Tabulates the variable

/* ***Simple Trick ***
After you type a command (many have abbreviated versions
i.e. describe/desc) start typing the variable and then hit the tab button
to complete the variable name
*/

histogram price
hist price // creates a histogram of variable price
hist price, freq // creates a histogram of variable price and uses frequency instead of density 

graph box variable

ttest DV , by(IV) // t test dependent variable by the independent variable
prtest DV , by(IV) // probability test of dependent variable by the independent variable



* *****
* Regressions and related commands
*

reg DV IV // regress the independent variable against the dependent variable
* R-squared IV explains x amount of the variation in our DV
// coefficient is the slope and constant coef is the y intercept
// root mse is SER

ci variable // get confidence interval of variable


twoway ( scatter dependentVar independentVar )( lfit dependentVar independentVar ) // show graph with regression line plotted against actual data points


corr DV IV // find the correlation between the two variables, how much of IV is correlated to the DV
corr DV IV, cov // 

pwcorr tvhrs credits , sig 

predict yhat // creates variable of the error or the difference between observation and projected line

predict uhat, res // creates a variable of the residual

hettest // test if regression is heteroskedastic. if p value < .05 then yes. Cannot run this after robust regression

reg DV IV, r // regress using robust errors option

rvfplot // use after regression and after predicting residual

margins , at(varName = 1 ) // show confidence interval for regression when varName equals 1

* show confidence interval for regression for range starting at 1, incrementing by 2, ending at 7
margins , at(varName = ( 1 ( 2 ) 7 ) )


* plot margins, superimpose regression line, superimpose confidence interval and shade the area (rarea), super impose scatter plot of the DV and IV
* can only be used after margins command
marginsplot , recast(line) recastci(rarea) addplot ( scatterplot Dv Iv )

adjust // another command to measure the confidence interval of the regression



* ** Here are a couple of advanced commands ** *

encode stringVar, gen(encodedVar) // encodes a string variable (be careful with this. even though it is encoded so stata can use it it may not be the exact values you expected)
encode stringVar, gen(encodedVar) nolabel // allows you to see the values your string variable was encoded as

replace varName = subinstr(varName ,"/", "-" , 2 ) // replace first two slashes with a dash
replace varName = subinstr(varName ,"/", "-" , . ) // replace all slashes with dashes
replace varName = subinstr(varName2 ,"/", " " , 2 ) // replace all values of varname with the values of varName2 after first two slashes are changed to spaces

gen double realTime= clock(Date, "YMDhm" ) // generate realTime and populate it with date time values from Date(str13) which is in the year, month, day, hour, minute format (yyyy-mm-dd hh:mm). 

* If you only want the date then you can use the date() method instead. the format in quotes should match the format that the Date variable is in, not the format you want the new variable to be in. The new variable will actually be in milliseconds since January 1, 1960
gen double realTime= date(Date, "YMDhm" )

format realTime %tcDD_mon_CCYY_HH // format the variable realTime (which is in milliseconds) to display in a way we can understand it
