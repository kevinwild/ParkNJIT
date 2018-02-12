<?php

	
	
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$x = $_POST['start_time'];	
	$y = $_POST['end_time'];
	$z = $_POST['park'];	
	if(isset($_POST['semester'])){
		get_history($x, $y, $z);		
	}
	else {
		get_history($x, $y, $z);
	}
}


class history_data{
	public $monArray = array();
	public $tueArray = array();
	public $wedArray = array();
	public $thurArray = array();
	public $friArray = array();
	public $satArray = array();
	public $sunArray = array();
	public $weekly_avg= array();

	public function Monday($hour,$space){
		$this->monArray[$hour][] = $space;
	}
	public function Tuesday($hour,$space){
		$this->tueArray[$hour][] = $space;
	}
	public function Wednesday($hour,$space){
		$this->wedArray[$hour][] = $space;
	}
	public function Thursday($hour,$space){
		$this->thurArray[$hour][] = $space;
	}
	public function Friday($hour,$space){
		$this->friArray[$hour][] = $space;
	}
	public function Saturday($hour,$space){
		$this->satArray[$hour][] = $space;
	}
	public function Sunday($hour,$space){
		$this->sunArray[$hour][] = $space;
	}
	public function getAvg($data){
		//echo array_sum($data) .' /  ' . count($data). ' = '  .round(array_sum($data) / count($data)) . '   <br><br>   ';
		return round(array_sum($data) / count($data));
	}
	public function buildJson(){
		$arrayNames = array($this->monArray, $this->tueArray, $this->wedArray, $this->thurArray, $this->friArray, $this->satArray, $this->sunArray);
		$dayNames = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		$hs = '{"days": { ';
		$hour = 0;
		$dayCount = 0;
		foreach($arrayNames as $name){
			$hs .= '"'.$dayNames[$dayCount] .'" : {';
			foreach($name as $key=>$value){
				$tempAvg = $this->getAvg($name[$key]);
				if($hour == 23){
					$hs .= '"'.$key. '" : "' . $tempAvg . '" ';
				}else{
					$hs .= '"'.$key. '" : "' . $tempAvg . '", ';
				}
					$hour++;
			}
			$hs .= '';
			$dayCount++;
			$hour = 0;
			if($dayCount == 7){
				$hs .= ' }';
			}else{
				$hs .= ' },';
			}
		}
		$hs .= '}}';
		return $hs;	
	}
}




function get_history($start_time, $end_time, $park){
	$hr_avg = array();	
	
	//...... DB Connect
	$servername = "xxxxxxxxx";
	$username = "xxxxxxxxx";
	$password = "xxxxxxxxx";
	$dbname = "xxxxxxxxx";
	$conn = new mysqli($servername, $username, $password, $dbname);	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	else {
		$sql = "SELECT * FROM ".$park." LIMIT 50000;";
		try {
		  $result = $conn->query($sql);
		
		} catch(PDOException $e) {
		  echo 'Error: ' . $e->getMessage();
		}
		
		if ($result->num_rows > 0) {
			date_default_timezone_set('America/New_York');
			$history = new history_data();
			while($row = $result->fetch_assoc()) {
				$time_data = getdate($row['TimeID']);		
				if($time_data['yday'] >= 324 && $time_data['yday'] <=328){
					continue;
				}
				$history->$time_data['weekday']($time_data['hours'],$row['Occupied']);
				
				
					
			}//... end sql row loop
		}
		else {
			echo 'No Data';
		}//.. end if rows > 0 loop
		
	}//...... end success DB Connect - else
	
	echo $history->buildJson();
	
}//.. end get_history
	



















?>