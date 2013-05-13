<?php
class ItemInfo {
	public static $itemTypes;
	public static $maxStats;
	public $type;
	public $generalType;
	public $dps;
	public $statsString = "";
	public $stats = array();
	public $statsDict = array();
	public $starsRating = 0;

	function __construct($statsString, $type, $dps)
	{
		$this->dps = $dps;
		$this->type = $type;
		$this->generalType = $type;
		if (in_array($type, self::$itemTypes["Weapon"]))
			$this->generalType = "Weapon";
		elseif (in_array($type, self::$itemTypes["Two-handed"]))
			$this->generalType = "Two-handed";
		elseif (in_array($type, self::$itemTypes["Off-Hand"]))
			$this->generalType = "Off-Hand";
    $this->statsString = $statsString;
    $this->CalculateMaxStatsProgress();
    $this->CalculateStarsRating();
	}

	function CalculateMaxStatsProgress(){
		$this->statsString = str_replace(", ", ",", $this->statsString);
		$statStrings = explode(",", $this->statsString);
		foreach ($statStrings as $statString) {
			if (!strstr($statString, " ")) continue;
			$statString = explode(" ", $statString);
			$stat = new stdClass();
			$stat->name = $statString[1];
			$stat->value = $statString[0];
			if (!is_numeric($stat->value))
				continue;
			$stat->max = 0;
			foreach (self::$maxStats as $maxStat) {
				if ($maxStat[0] == $this->generalType && strtolower($maxStat[1]) == strtolower($stat->name)){
					$stat->max = $maxStat[2];
				}
			}
			$stat->progress = 0;
			if ($stat->max > 0)
				$stat->progress = round(min($stat->value / $stat->max, 1) * 100);
			$this->statsDict[strtolower($stat->name)] = $stat;
			$this->stats[] = $stat;
		}
	}

	function CalculateStarsRating(){
		$starWeights = json_decode(file_get_contents("data/json/star_weights.json"));
		$total = 0;
		$n = 0;

		$mVit = $this->m("vit");
		$vVit = $this->v("vit");
		$vStr = $this->v("str");
		$vDex = $this->v("dex");
		$vInt = $this->v("int");
		if (in_array("str", array_keys($this->statsDict)) && $vStr >= $vDex && $vStr >= $vInt)
			$n = $this->d($vStr + $vVit, $this->m("str") + $mVit);
		else if (in_array("dex", array_keys($this->statsDict)) && $vDex >= $vStr && $vDex >= $vInt)
			$n = $this->d($vDex + $vVit, $this->m("dex") + $mVit);
		else if (in_array("int", array_keys($this->statsDict)) && $vInt >= $vDex && $vInt >= $vStr)
			$n = $this->d($vInt + $vVit, $this->m("int") + $mVit);
		$n = $n * $n * $starWeights->primary;
    $total += $n;
    $weights = get_object_vars($starWeights);
    foreach ($weights as $name => $weight) {
    	$n = $this->d($this->v($name), $this->m($name));
    	$n = min($n, 1);
        $total += $n*$n*$weight;
    }
    if ($this->dps > 0) {
    	$n = 0;
    	if ($this->generalType == "Weapon"){
    		$n = $this->dps / 1400;
    	}else if ($this->generalType == "Two-handed"){
    		$n = $this->dps/1800;
    	}
      if ($n > 1)
      	$n = 1;
      if ($n > 0.60)
          $total += $n * $n * $starWeights->dps;
    }
    $this->starsRating = round(min($total, 10));
	}

	function d($a, $b){
		if ($b == 0)
			return 0;
		if ($a > $b)
			return 1;
		return $a / $b;
	}

	function v($name) {
		if (!in_array(strtolower($name), array_keys($this->statsDict)))
			return 0;
		return $this->statsDict[strtolower($name)]->value;
	}

	function m($name) {
		$name = strtolower($name);
		if (in_array($name, array_keys($this->statsDict)))
			return $this->statsDict[$name]->max;
		foreach (self::$maxStats as $maxStat) {
			if ($maxStat[0] == $this->generalType){
				if (strtolower($maxStat[1]) == $name){
					return $maxStat[2];
				}
				if (in_array($name, array("fired", "holyd", "ltnd", "arcd", "coldd", "poisond")) && strtolower($maxStat[1]) == "ed") {
					return $maxStat[2];
				}
			}
		}
		return 0;
	}

}
ItemInfo::$itemTypes = get_object_vars(json_decode(file_get_contents("data/json/itemtypes.json")));
ItemInfo::$maxStats = json_decode(file_get_contents("data/json/maxstats.json"));
?>