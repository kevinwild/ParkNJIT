<?php
// Report all PHP errors
error_reporting(-1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	
	
}






function get_history($start_time, $end_time){
	$day = $_POST['day'];
	$current_hour = NULL; // keeps track of each hour 00-23 for military conversion
	$loop_count = 0; // .... Keeps track of how many records are contained within an hr
	$hour_avg = array();
	$history_data = array();
	$history_string = '{';
	$data_string = '';
	$temp_avg = 0; // .... This holds the average of.. temp_avg = sum(hour_avg)/count(hour_avg)
	$hour_sec = 60;
	$day_sec = 1400;
	$week_sec = 10080;
	$month_sec = 2628000;
	$cur_sec = time();
	$checkSet = false;
	
	
	
	
	$servername = "xxxxxxxxx";
	$username = "xxxxxxxxx";
	$password = "xxxxxxxxx";
	$dbname = "xxxxxxxxx";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} else{
				$sql = "SELECT * FROM PARK Limit 5259492;";
				
		
		try {
		  $result = $conn->query($sql);
		
		} catch(PDOException $e) {
		  echo 'Error: ' . $e->getMessage();
		}
				   //echo "ID: " . $row["TimeID"]. " - Occupied: " . $row["Occupied"]. " - Total" . $row["Total"]. "<br>";
				//echo $time_data['weekday'] .' = '. $day . '<br>';	
				//echo( $time_data['weekday']  ."  " .$time_data['hours']. '<br>');
	
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				//print_r(getdate($row['TimeID'])); echo '<br>';  //........ Table loop test
				$time_data = getdate($row['TimeID']);				//........ Time data test
				if($time_data['weekday'] ==  $day){	
					array_push($hour_avg,$row["Occupied"]); 
				
					if($time_data['hours'] == 0   && $time_data['minutes'] == 59 ){
						$current_date = ' '. $time_data['weekday'] .' '. $time_data['month'].' '. $time_data['mday'] .' '. $time_data['year'];		
						$current_hour = $time_data['hours'];	
						$temp_avg = round(array_sum($hour_avg) / count($hour_avg));
						//echo array_sum($hour_avg) .' / '. count($hour_avg) .' = '.$temp_avg . '<br>'; // Test... temp_avg calculation
						$data_string .= ' "'.$time_data['hours']. '"  :  "' . $temp_avg . '",' ;
						$history_string = $current_date . ' { ' . $data_string  ;

					}
					else if($time_data['hours'] == 23 && $time_data['minutes'] == 59  ){
						$temp_avg = round(array_sum($hour_avg) / count($hour_avg));
						$data_string .= ' "'.$time_data['hours']. '"  :  "' . $temp_avg . '",' ;
						$hour_avg = array(); $temp_avg = 0;

					}
			
					else {
						if($current_hour != $time_data['hours'] || $time_data['minutes' == 59]){
							$data_string .= ' "'.$time_data['hours']. '"  :  "' . $temp_avg . '",' ;

							$current_hour = $time_data['hours'];
							array_push($history_data,$time_data['hours']);	
							
						}
					
							
					
						
	
					}

						

				}
				// Every second record but post day
				else {
					/*
					if($current_hour != NULL){
						$history_string .= ' "' . $current_date .'": { ' . $data_string . ' } ';
					}
					$current_hour = NULL;*/
					}
		
			}
		}
			 
		else {
			echo "0 results";
		}
		$conn->close();
		$history_string .= '}';
		echo $history_string;//json_encode($history_string,JSON_UNESCAPED_SLASHES); 

	}	

}//.. end db fail connection
get_history($start_time, $end_time);
?>
