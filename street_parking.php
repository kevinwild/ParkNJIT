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

    <link rel="stylesheet" type="text/css" href="styles.css">

	<title>NJIT Parking</title>
</head>

<body id="decks">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
      
            <div class="navbar-header">
              <a class="navbar-brand" href="#">NJIT Parking</a>
            </div>  
        </div>  
        <div id="top_menu" style="text-align:center;" class="row"> 
            <div class="col-xs-6">   
            	<a id="decks_nav" href="index.php"> Decks </a>
            </div>
           <div class="col-xs-6"  style="border-bottom: thick solid #4885ed;">   

                <a id="street_nav" href="street_parking.php"> Street </a>
			</div>
                          
		</div>  
    </nav>

<div class="container">
    <div class="row">
        <div class="col-sm-12">   
        	<div class="panel panel-primary shadow_me">
            <iframe src="https://www.google.com/maps/d/embed?mid=18OYaTlGo9vijxsNLpijiOriELpg" width="100%" height="500">
            
            </iframe>

            </div>

       </div>
    </div><!-- .. end row -->
    
    <div id="dynamic-parking">
    </div>
    
    
</div><!-- end container -->
<div class="navbar footer" style="text-align:center;">
	<a href="http://mobile.njit.edu/parking/legal.php" target="_blank">Terms of Use</a>
</div>

	<script>

function parkit(){
	$.ajax({
			url: "config.php",
			type: "get",
			dataType:"json",
			success: function (response) {
				parking = response;
				
				$.each(parking.decks, function(index, element) {
					if(element.SiteName == 'PARK'){
						$(".parking-deck").attr("data-count", element.Available);
						$("#parking-deck-nav").attr("href", element.AddressURL);

						draw_pie('#pie-1', element.Occupied, element.Total);

					}
					else if(element.SiteName == 'Science & Tech Garage'){
						$(".sci-tech-garage").attr("data-count", element.Available);
						$("#sci-tech-nav").attr("href", element.AddressURL);
						draw_pie('#pie-2', element.Occupied, element.Total);


					}
	
					else if(element.SiteName == 'Lot 10'){
						$(".Lot-10").attr("data-count", element.Available);
						$("#lot-10-nav").attr("href", element.AddressURL);
						draw_pie('#pie-3', element.Occupied, element.Total);

					}
					else if(element.SiteName == 'FENS2'){
						$(".FENS2").attr("data-count", element.Available);
						$("#FENS2-nav").attr("href", element.AddressURL);
						draw_pie('#pie-4', element.Occupied, element.Total);

					}
					else if(element.SiteName == 'FENS1'){
						//$(".FENS1").attr("data-count", element.Available);
						//draw_pie('#pie-3', element.Available, element.Occupied);

					}
					
				});
				//alert(parking.decks[0].SiteName);
				count_up();
			
			
			
			
			
			},
			error: function(jqXHR, textStatus, errorThrown) {
			  // console.log(textStatus, errorThrown);
			}
			
	
		});

}
parkit();// inital load
time=setInterval(function(){
	parkit();

},8000);
</script>
        <script src="scripts.js"></script>


</body>
</html>



<body>
</body>
</html>