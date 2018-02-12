<?php 
//-------------->>>>>> TEST 222

//Display Format:: echo $data['decks'][1]['Description'];
//$data = get_data('http://mobile.njit.edu/parking/data.php'); 

date_default_timezone_set('America/New_York');
$todayDate = date("l");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.1.1/Chart.min.js"></script> 

<script src="scripts.js"></script>

    <link rel="stylesheet" type="text/css" href="styles.css">

	<title>NJIT Parking</title>
</head>

<body id="decks">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
      
            <div class="navbar-header">
              <a class="navbar-brand" href="#"><!--<img src="LOGO.png" width="inherit" height="45px" alt="NJIT Parking">--> Park NJIT</a>
            </div>  
        </div>  
        <div id="top_menu" style="text-align:center;" class="row"> 
            <div class="col-xs-6" style="border-bottom: thick solid #4885ed;">   
            	<a id="decks_nav" href="index.php"> Decks </a>
            </div>
           <div class="col-xs-6">   

                <a id="street_nav" href="street_parking.php"> Street </a>
			</div>
                          
		</div>  
    </nav>

<div class="container">
<div class="alert alert-warning" style="text-align:center; display:none;">
  <strong>Warning: </strong> The parking lots seem pretty full check out <a href="https://www.google.com/maps?q=27+Lock+Street,+Newark,+NJ+07103" target="_blank">Lot 12</a>.
</div>


    <div class="row">
        <div class="col-sm-3">   
        	<div class="panel panel-primary shadow_me">
            	<div class="panel-heading panel-primary"><p class="dark-text">Parking Deck</p></div>
      			<div class="panel-body">
                	<table>
                    <tr><td>
                     <div class="canvas-container" id="pie-1-container">
              		  <canvas id="pie-1" width="100px" height="100px"></canvas> 
                     </div>
                     <a href="#getDetails" data-toggle="modal" data-target="#getDetails" onClick="getDetails('PARK','parking-deck');">Details</a> 
                     <a href="" id="parking-deck-nav" target="_blank">Navigate</a>
                   </td><td class="center">
                         <div class="counter fancy-font parking-deck" data-count="" id="pdeck_count">0</div>  Parking Spots <br> Available 
                   </td></tr>
                   </table> 
              </div>
    		</div>
       </div>
       <div class="col-sm-3">   
        	<div class="panel panel-primary shadow_me">
            	<div class="panel-heading panel-primary"><p class="dark-text">Science & Technology Garage</p></div>
      			<div class="panel-body">
                    <table>
                    <tr><td>
                    <div class="canvas-container" id="pie-2-container">
              		  <canvas id="pie-2" width="100px" height="100px"></canvas> 
                     </div>
                     <a href="#getDetails" data-toggle="modal" data-target="#getDetails" onClick="getDetails('`Science & Tech Garage`','sci-tech-garage')">Details</a> <a href="" id="sci-tech-nav" target="_blank">Navigate</a>
                   </td><td class="center">
                     <div class="counter fancy-font sci-tech-garage" data-count="" id="stg_count">0</div>  Parking Spots <br> Available 
    
                   </td></tr>
                   </table> 
                </div>
    		</div>
       </div>
       <div class="col-sm-3">   
        	<div class="panel panel-primary shadow_me">
            	<div class="panel-heading panel-primary"><p class="dark-text">Parking Lot #10</p></div>
      			<div class="panel-body">
                   <table>
                    <tr><td>
                    <div class="canvas-container" id="pie-3-container">
              		  <canvas id="pie-3" width="100px" height="100px"></canvas> 
                     </div>
                      <a href="#getDetails" data-toggle="modal" data-target="#getDetails" onClick="getDetails('`Lot 10`','Lot-10')">Details</a>
                      <a href="" id="lot-10-nav" target="_blank">Navigate</a>
                   </td><td class="center">
                        <div class="counter fancy-font Lot-10" data-count="" id="p10_count">0</div> Parking Spots <br> Available 

                   </td></tr>
                   </table> 
                
                </div>
    		</div>
       </div>
        <div class="col-sm-3">   
        	<div class="panel panel-primary shadow_me">
            	<div class="panel-heading panel-primary"><p class="dark-text">Fenster Level 2</p></div>
      			<div class="panel-body">
                	<table>
                    <tr><td>
                    <div class="canvas-container" id="pie-4-container">
              		  <canvas id="pie-4" width="100px" height="100px"></canvas> 
                   </div>
                     <a href="#getDetails" data-toggle="modal" data-target="#getDetails" onClick="getDetails('FENS2', 'FENS2')">Details</a> <a href="" id="FENS2-nav" target="_blank">Navigate</a>
                   </td><td class="center">
                        <div class="counter fancy-font FENS2" data-count="" id="fen_count">0</div>  Parking Spots <br> Available 
                       
                   </td></tr>
                   </table> 
              </div>
    		</div>
       </div>
    </div><!-- .. end row -->
    
    <div id="dynamic-parking">
    </div>

    
</div><!-- end container -->
<div class="navbar footer" style="text-align:center;">
	<a href="http://mobile.njit.edu/parking/legal.php" target="_blank">Terms of Use</a>
</div>

	
        
   <!-- Details Modal -->
  <div class="modal fade" id="getDetails" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="historyTitle"></h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 text-center" id="modalImage">
                    
                </div>
            </div><!-- END.. row -->
            <div style="padding-top:15px;">
                <div>
                    <img src="imgs/Clock_icon.svg" onerror="this.onerror=null; this.src='image.png'"> Open 24 Hours 
                </div>
                <div style="margin-top:10px;">
                	<img src="imgs/LIVE.png" width="38px" height="inherit" alt="live data"> <span id="avail_parking"></span> parking spots available 
                </div>
                <div style="margin-top:10px; margin-bottom:15px;">
                	Popular Times: <select id="weekDays" onChange="changeDay()">
                    					<option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                    					<option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                    					<option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                  </select>	
                      <img src="imgs/filter.png" width="25" id="filterSemester" height="25" alt="Filter Semester" style="float:right;">
                <div style="clear:both;"></div>

               </div>
               
				
            </div><!-- end row -->
            <!-- Historical Chart -->
            <div class="row" id="chartHistory_container" align="center">
                <canvas id="chartHistory" width="300" height="225"></canvas>
    		</div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div> 
  </div>      
    
    
    

   
    
    
    
        
<script>
var historyObj;
var historyData;
var deckImg;
var deckName;
var availSpots;
var steps;
var maxValue;

$("#weekDays").val("<?php echo $todayDate; ?>");

function getDetails(garage, idName){

		$('#chartHistory').remove(); // this is my <canvas> element
  		$('#chartHistory_container').append('<canvas id="chartHistory" width="300" height="225"><canvas>');	
		

		
	if(idName == 'parking-deck'){
		 deckImg = 'parking-deck1.jpg';
		 deckName = "Parking Deck";
		 availSpots = $("#pdeck_count").text();
		 stepValue = 169;
		 steps = 10;
		
	}
	else if(idName == 'sci-tech-garage'){
		deckImg = 'new_deck.png';
		deckName = "Science Tech Garage";
		availSpots = $("#stg_count").text();
	    stepValue = 93;
		steps = 10;

	}
	else if(idName == 'Lot-10'){
		deckImg = 'lot_10.png';
		deckName = "Lot 10";
		availSpots = $("#p10_count").text();
		stepValue = 5;
		steps = 10;


	}
	else if(idName == 'FENS2'){
		deckImg = 'fenster.png';
		deckName = "Fenster";
		availSpots = $("#fen_count").text();
		stepValue = 4;
		steps = 10;

	}
	else {
		deckImg= '#';
		availSpots = 0;
		deckName = 'There was an error';
		stepValue = 0;
		steps = 0;
	}
	$("#historyTitle").html(deckName + " "); // Change pop up title
	$('#modalImage').html('<img src="imgs/'+deckImg+'" width="100%" height="inherit">'); // Change pop up image 
	$('#avail_parking').text(availSpots);
	
	historyDraw(garage, stepValue, steps);


}

parkit();// inital load
time=setInterval(function(){
	parkit();
	checkCapacity();

},5000);


$(document).ready(function () {
  $("#filterSemester").click(function () {
   		alert("Currently gathering data for this feature.");
  });
});

</script>







</body>
</html>
