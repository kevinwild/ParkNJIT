	// JavaScript Document
var call_count = 0; //.. Only animate on load


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

}//.. END Parkit


function count_up(){
	
	$('.counter').each(function() {
	  var $this = $(this),
		  countTo = $this.attr('data-count');
	  
	  $({ countNum: $this.text()}).animate({
		countNum: countTo
	  },
	
	  {
	
		duration: 1000,
		easing:'linear',
		step: function() {
		  $this.text(Math.floor(this.countNum));
		},
		complete: function() {
		  $this.text(this.countNum);
		  //alert('finished');
		}
	
	  });  
	  
	
	
	});


}


function draw_pie(name, taken, total){
			
			if(taken <= 0){taken = 0;}
			var pie_options;
			var available = total-taken;
			if(available < 0){
				available = 0;
			}
			var percent_filled;
			percent_filled = Math.floor((taken/total) * 100);
			if(percent_filled < 0) {
				percent_filled = 0;
			}
 			percent_filled = percent_filled + "% Full";
	
			
			
			
			
			$(name).remove();
			 $(name+'-container').append('<canvas id="'+name.substring(1)+'" width="100px" height="100px"><canvas>');
			
			var ctx = $(name).get(0).getContext("2d");
		//.................DRAW TEXT INSIDE DOUGHNUT.....................	
		Chart.types.Doughnut.extend({
        name: "DoughnutTextInside",
        showTooltip: function() {
            this.chart.ctx.save();
            Chart.types.Doughnut.prototype.showTooltip.apply(this, arguments);
            this.chart.ctx.restore();
        },
		
		
		draw: function() {
				Chart.types.Doughnut.prototype.draw.apply(this, arguments);
	
				var width = this.chart.width,
					height = this.chart.height;
	
				var fontSize = (height / 100).toFixed(2);
				this.chart.ctx.font = fontSize + "em Verdana";
				this.chart.ctx.textBaseline = "middle";
				
	
				var text = percent_filled,
					textX = Math.round((width - this.chart.ctx.measureText(text).width) / 2),
					textY = height / 2;
	
				this.chart.ctx.fillText(text, textX, textY);
			}
		});
		//...................END DOUGHNUT TEXT...................	
			var data = [
				{
					value: taken,
					color: " #db3236",
					highlight: " #6c1315",
					label: "Occupied"	
				},
				{
					value: available,
					color: "#fbe9ea",
					highlight: "#e6f2ff",
					label: "Available",
				},
				{
					value: 0,
					color: "black",
					highlight: "black",
				}
			];
			if(call_count > 3){
				pie_options = {animation : false, responsive: true, maintainAspectRatio: false, percentageInnerCutout: 80}
			}
			else {
				pie_options = {animation : false, responsive: true, maintainAspectRatio: false, percentageInnerCutout: 80}
			}
			var piechart = new Chart(ctx).DoughnutTextInside(data,pie_options);
			
			
				call_count ++; // used for animation				
}

function checkCapacity(){

	if(($("#pdeck_count").text() < 50) && ($("#stg_count").text() < 50)){
		if($(".alert-warning").is(':visible')){
			//pass	
		}
		else {
			$(".alert-warning").fadeIn();
		}
	}
	else {
		if($(".alert-warning").is(':visible')){
			$(".alert-warning").fadeOut();
		}
		else {
			// pass
		}
	}

}



//___ GET History Details 


function changeDay(){
	var hoursOccupied = [];
	$('#chartHistory').remove(); // this is my <canvas> element
  	$('#chartHistory_container').append('<canvas id="chartHistory"><canvas>');	
	$.each(historyData.days, function(index, element){
				if(index == $('#weekDays').val()){
					$.each(element, function(hour,occupied){
						if(hour >= 6 && hour <=21){
							hoursOccupied.push(occupied);
						}
					});
				}
				
			});
			var barChartData = {
				labels : ["6a","|","|","9a","|","|","12","|","|","3p","|","|","6p" ,"|","|","9p"],
				datasets : [
					{
						fillColor : "rgb(46, 81, 181)",
						strokeColor : "rgb(255, 255, 255)",
						highlightFill: "rgb(164, 28, 31)",
						highlightStroke: "rgba(220,220,220,1)",
						data : hoursOccupied,
						scaleShowLabels: false,
						
					}
				]        
				}
		 var ctx = document.getElementById("chartHistory").getContext("2d");
		

			window.myBar = new Chart(ctx).Bar(barChartData, {
				responsive : true,
				scaleShowLabels : false,
				scaleOverride:true,
							scaleSteps: steps,
							scaleStartValue: 0,
							scaleStepWidth: stepValue,
				 tooltips: {
						 enabled: false
				}

			});


			
        
}



function historyDraw(garage, stepValue, steps){
	var hoursOccupied = [];
	
	$.post("history/getit.php",
        {
          park: garage,
        },
        function(data,status){
			var parsed_data = JSON.parse(data);

			historyData = parsed_data;
			$.each(parsed_data.days, function(index, element){

				if(index == $('#weekDays').val()){
					$.each(element, function(hour,occupied){
						if(hour >= 6 && hour <=21){
							hoursOccupied.push(occupied);
						}
					});
				}
				
			});
			var barChartData = {
				labels : ["6a","|","|","9a","|","|","12","|","|","3p","|","|","6p" ,"|","|","9p"],
				
				datasets : [
					{
						fillColor : "rgb(46, 81, 181)",
						strokeColor : "rgb(255, 255, 255)",
						highlightFill: "rgb(164, 28, 31)",
						highlightStroke: "rgba(220,220,220,1)",
						data : hoursOccupied,

					}
				]        
				}

		
		
		 var ctx = document.getElementById("chartHistory").getContext("2d");
		 

	
	
			if(window.myBar != undefined){
				window.myBar.destroy();
			}
			window.myBar = new Chart(ctx).Bar(barChartData, {
				responsive : true,
				scaleShowLabels : false,
				scaleOverride:true,
					scaleSteps: steps,
					scaleStartValue: 0,
					scaleStepWidth: stepValue
				
			});

			
        });		
}
