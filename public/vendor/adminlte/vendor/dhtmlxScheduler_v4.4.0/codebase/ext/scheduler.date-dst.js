scheduler.date.add = function(date,inc,mode){
	var ndate=new Date(date.valueOf());
	switch(mode){
		case "day":
			ndate = scheduler.date._add_days(ndate, inc);
			break;
		case "week":
			ndate = scheduler.date._add_days(ndate, inc * 7);
			break;
		case "month": ndate.setMonth(ndate.getMonth()+inc); break;
		case "year": ndate.setYear(ndate.getFullYear()+inc); break;
		case "hour":
			ndate.setTime(ndate.getTime()+inc * 60 * 60 * 1000);
			break;
		case "minute":
			ndate.setTime(ndate.getTime() + inc * 60 * 1000);
			break;
		default:
			return scheduler.date["add_"+mode](date,inc,mode);
	}
	return ndate;
};
scheduler.date._add_days = function(date, inc){
    var ndate = new Date(date.valueOf());

    ndate.setDate(ndate.getDate() + inc);

    if(inc == Math.round(inc) && inc > 0){
        var datesDiff = +ndate - +date,
            rest = datesDiff % (24*60*60*1000);
        if(rest != 0 && date.getTimezoneOffset() == ndate.getTimezoneOffset()){
            var hours = rest / (60* 60 * 1000);
            ndate.setTime(ndate.getTime() + (24 - hours) * 60 * 60 * 1000);
        }
    }

    if (inc >= 0 && (!date.getHours() && ndate.getHours()) &&//shift to yesterday on dst
        (ndate.getDate() < date.getDate() || ndate.getMonth() < date.getMonth() || ndate.getFullYear() < date.getFullYear()) )
        ndate.setTime(ndate.getTime() + 60 * 60 * 1000 * (24 - ndate.getHours()));
    return ndate;
};