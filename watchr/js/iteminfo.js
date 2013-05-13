function ItemInfo(statsString, type, dps) {
	this.dps = isNumber(dps) ? parseFloat(dps) : 0;
	this.type = type;
	this.generalType = type;
	if ($.inArray(type, ItemInfo.itemTypes.Weapon) >= 0)
		this.generalType = "Weapon";
	else if ($.inArray(type, ItemInfo.itemTypes["Two-handed"]) >= 0)
		this.generalType = "Two-handed";
	else if ($.inArray(type, ItemInfo.itemTypes["Off-Hand"]) >= 0)
		this.generalType = "Off-Hand";
	this.statsString = statsString;
	this.stats = [];
	this.statsDict = [];
	this.starsRating = 0;

	this.CalculateMaxStatsProgress = function(){
		this.statsString = this.statsString.replace(/, /g, ",");
		var statStrings = this.statsString.split(",").map($.trim);
		for (var i in statStrings) {
			var statString = statStrings[i];
			if (statString.indexOf(" ") == -1)
				continue;
			var parts = statString.split(" ");
			var stat = { name: parts[1], value: parts[0], max: 0, progress: 0 };
			if (!isNumber(stat.value))
				continue;
			stat.value = parseFloat(stat.value);
			for (var j in ItemInfo.maxStats) {
				var maxStat = ItemInfo.maxStats[j];
				if (maxStat[0] == this.generalType && maxStat[1].toLowerCase() == stat.name.toLowerCase()){
					stat.max = maxStat[2];
				}
			}
			if (stat.max > 0)
				stat.progress = Math.round(Math.min(stat.value / stat.max, 1) * 100);
			this.stats.push(stat);
			this.statsDict[stat.name.toLowerCase()] = stat;
		}
	}

	this.CalculateStarsRating = function(){
		var total = 0;
		var n = 0;

		var mVit = this.m("vit");
		var vVit = this.v("vit");
		var vStr = this.v("str");
		var vDex = this.v("dex");
		var vInt = this.v("int");
		if ($.inArray("str", Object.keys(this.statsDict)) >= 0 && vStr >= vDex && vStr >= vInt)
			n = this.d(vStr + vVit, this.m("str") + mVit);
		else if ($.inArray("dex", Object.keys(this.statsDict)) >= 0 && vDex >= vStr && vDex >= vInt)
			n = this.d(vDex + vVit, this.m("dex") + mVit);
		else if ($.inArray("int", Object.keys(this.statsDict)) >= 0 && vInt >= vDex && vInt >= vStr)
			n = this.d(vInt + vVit, this.m("int") + mVit);
		n = n * n * ItemInfo.starWeights.primary;
    total += n;
    for (var name in ItemInfo.starWeights) {
    	var weight = ItemInfo.starWeights[name];
    	n = this.d(this.v(name), this.m(name));
    	n = Math.min(n, 1);
        total += n*n*weight;
    }
    if (this.dps > 0) {
    	n = 0;
    	if (this.generalType == "Weapon"){
    		n = this.dps / 1400;
    	}else if (this.generalType == "Two-handed"){
    		n = this.dps / 1800;
    	}
      if (n > 1)
      	n = 1;
      if (n > 0.60)
          total += n * n * ItemInfo.starWeights.dps;
    }
    this.starsRating = Math.round(Math.min(total, 10));
	}

	this.d = function(a, b) {
		if (b == 0)
			return 0;
		if (a > b)
			return 1;
		return a / b;
	}

	this.v = function(name){
		if ($.inArray(name.toLowerCase(), Object.keys(this.statsDict)) == -1)
			return 0;
		return this.statsDict[name.toLowerCase()].value;
	}

	this.m = function(name){
		name = name.toLowerCase();
		if ($.inArray(name, Object.keys(this.statsDict)) >= 0)
			return this.statsDict[name].max;
		for (var j in ItemInfo.maxStats) {
			var maxStat = ItemInfo.maxStats[j];
			if (maxStat[0] == this.generalType && maxStat[1].toLowerCase() == name)
				return maxStat[2];
		}
		return 0;
	}

	this.CalculateMaxStatsProgress();
	this.CalculateStarsRating();

	//Misc
	function isNumber(n) {
	  return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
}

//Static methods
ItemInfo.Initialize = function(callback){
	$.get("/data/json/itemtypes."+(new Date()).getTime()+".json", function(itemTypes){
		ItemInfo.itemTypes = itemTypes;
		$.get("/data/json/maxstats."+(new Date()).getTime()+".json", function(maxStats){
			ItemInfo.maxStats = maxStats;
			$.get("/data/json/star_weights."+(new Date()).getTime()+".json", function(starWeights){
				ItemInfo.starWeights = starWeights;
				if (typeof callback == "function")
					callback();
			}, "json");
		}, "json");
	}, "json");
}

