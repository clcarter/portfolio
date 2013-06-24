ttest DV , by(IV) // t test dependent variable by the independent variable
prtest DV , by(IV) // probability test of dependent variable by the independent variable

ci variable // get confidence interval of variable
// coefficient is the slope and constant coef is the y intercept
//root mse is SER

twoway(scatter dependentVar independentVar)(lfit dependentVar independentVar)

* R-squared IV explains x amount of the variation in our DV
corr DV IV // find the correlation between the two variables, how much of IV is correlated to the DV
corr DV IV, cov // 

pwcorr tvhrs credits , sig 

predict yhat // creates variable of the error or the difference between observation and projected line

predict uhat, res // creates a variable of the residual
