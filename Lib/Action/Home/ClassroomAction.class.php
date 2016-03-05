<?php

class ClassroomAction extends BaseAction {
	
	// 顺序很重要，个位数楼号放在最后
	private $building = array("1049" => "10楼", "0020" => "11楼", "0026" => "12楼", "1047" => "14楼",
			"0024" => "15楼", "1054" => "16楼", "1071" => "17楼", "0018" => "18楼",
			"0032" => "19楼", "0021" => "20楼", "0038" => "21楼", "0015" => "23楼",
			"1042" => "24楼", "1089" => "25楼A", "1050" => "25楼B", "1090" => "25楼C",
			"1084" => "26楼A", "1085" => "26楼B", "1086" => "26楼C", "1087" => "26楼D",
			"1088" => "26楼E", "1080" => "科学", "1082" => "船海", "1060" => "大活",
			"0040" => "东阶", "1083" => "港口", "1074" => "化工", "1058" => "科图",
			"1092" => "南开", "1081" => "内燃机", "1072" => "实习", "1079" => "水利",
			"1078" => "体育", "1075" => "土建", "1091" => "网架", "0028" => "西阶",
			"1077" => "影视", "1070" => "综合", "1073" => "1楼", "0036" => "3楼", "0022" => "4楼",
			"1048" => "5楼", "0030" => "6楼", "0031" => "7楼", "0045" => "8楼");
			
	private $timePerStr;
	private $msg;
	
	function shouldHandle($recvObj){
		parent::shouldHandle($recvObj);
		$this->msg = trim($recvObj->content);
		$str1 = mb_substr ( $this->msg, 0, 2, "UTF-8" );//截取前两个字
		if (stripos($this->msg, "自习") !== false && $str1 != '翻译')
			return true;
		return false;
	}
	
	function handle(){
		$buildings = array();
		while (list($key, $val) = each($this->building))
		{
			if (stristr($this->msg, $val) != false){
				$buildings[$key] = $val;
				$this->msg = str_replace($val, "", $this->msg);
				break;
			}
		}
		$termDay = $this->getTermDay();
		$period = $this->getPeriod();

		$result = $this->timePerStr;
		foreach ($buildings as $k=>$v) {
			$result = $result . $this->getSchedule($termDay[week], $termDay[weekday], $period, $k, $v);
		}
		
		return parent::getTextXml($result);
	}
	
	/*
 	 * 返回当前的校历时间: 第几周，星期几.
	 * 注意:
	 * startTerm值为学期起始时间。要在下学期重新设置，以保证时间的正确。
	 */
	function getTermDay() {
		$now = getdate();
		$startTerm = getdate(getTimeStamp("2014,08,31"));

		$year = $now[year] - $startTerm[year];
		//假设每学期开始都设置正确，不会出现跨多年的情况
		$day = $now[yday] - $startTerm[yday] + $year * ($startTerm[year] % 4 == 0 ? 366 : 365);
		$week = ceil($day / 7);
		$weekday = $day % 7;
		if ($weekday == 0) $weekday = 7;

		return array("week" => $week, "weekday" => $weekday);
	}
	
	/*
	 * 确定当前时间的课程段.
	 */
	function getPeriod() {
		$timePer = array("上午第1节" => 1, "上午第一节" => 1, "上午第2节" => 2, "上午第二节" => 2, "下午第1节" => 3, "下午第一节" => 3, "下午第2节" => 4, "下午第二节" => 4, "晚上第1节" => 5, "晚上第一节" => 5, "晚第1节" => 5, "晚第一节" => 5, "晚上第2节" => 6, "晚上第二节" => 6, "晚第2节" => 6, "晚第二节" => 6);
		
		foreach ($timePer as $k=>$v)
			if (stripos($this->msg, $k) !== false){
				$this->timePerStr = $k;
				return $v;
			}
		
		/* 课程时间(分钟):
		 * 480:  即08:00, 1-2节;  9:35结束,  575
		 * 595:  即09:55, 3-4节;  11:30结束, 690
		 * 840:  即14:00, 5-6节;  15:35结束, 935
		 * 955:  即15:55, 7-8节;  17:30结束, 1050
		 * 1140: 即19:00, 9-10节; 20:35结束, 1235
		 * 1255: 即20:55, 11-12节;22:30结束, 1350
		 */
		$periods = array(480, 575, 595, 690, 840, 935, 955, 1050, 1140, 1235, 1255, 1350);
		$now = getdate();
		$nowMinute = $now[hours] * 60 + $now[minutes];
		$p = 6;

		/* 根据查询时间，确定课程时间段:
		 * 更改: 分为'课上查询'和'课间查询'
		 * i为偶数，说明查询时间为课间, 还没有上课。故查询下节课可用自习室。
		 * i为奇数，说明查询时间为课上，已经上课了。故查询该节课可用自习室。 
		 */
		foreach ($periods as $k=>$v) {
			if ($nowMinute < $v) {
				$p = ($k % 2 == 0 ? $k/2 : ($k-1)/2) + 1;
				break;
			}
		}
		
		foreach ($timePer as $k=>$v)
			if ($p == $v){
				$this->timePerStr = "当前时间：" . $k;
				break;
			}

		return $p;
	}
	
	function getSchedule($week, $weekday, $period, $building, $buildingName) {
		$postData = 'todo=displayWeekBuilding&week=' . $week . '&building_no=' . $building;
		$action = "e.tju.edu.cn/Education/toModule.do?prefix=/Education&page=/schedule.do?todo=displayWeekBuilding&schekind=6";

		$data = sendPost($action, $postData);
		$data = mb_convert_encoding($data, "utf-8", "gbk");
		$data = preg_replace("/\s/", "", $data);

		$rooms = array();
		$mchs = array();

		preg_match_all("/<tr><tdbgcolor=\"#336699\"align=\"center\"><strong><fontcolor=\"White\">([^<]*)<\/font><\/strong><\/td>(.*?)<\/tr>/", $data, $mchs);
		
		foreach ($mchs[2] as $k=>$v) {
			$roomName = $mchs[1][$k];
			$subMchs = array();
			
			preg_match_all("/<tdalign=\"center\"bgcolor=\"([^\"]*)\"><fontcolor=\"([^\"]*)\">●<\/font><\/td>/", $v, $subMchs);
			if ($subMchs == false || count($subMchs) < 3) 
				continue;

			$color = $subMchs[2][($weekday - 1) * 6 + ($period - 1)];

			if ($color == "#00dd00"){
				array_push($rooms, str_replace($buildingName, "", $roomName));
			}
		}

		return "\r\n" . $buildingName . " : " . join(" ", $rooms);
	}
}

?>