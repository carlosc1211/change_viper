

<div class="transparentCover"></div>
<div class="loading"></div>
<div class="taskmensaje">
	<div class="taskmensajetext" style="display:none"></div>
</div>

<script src="../js/bootstrap.min.js"></script>

<!-- chart js -->
<script src="../js/chartjs/chart.min.js"></script>
<!-- bootstrap progress js -->
<script src="../js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="../js/nicescroll/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="../js/icheck/icheck.min.js"></script>
<script src="../../lib/jquery.selectboxes.js" type="text/javascript"></script>
<script src="../../lib/jquery.selectboxes.min.js" type="text/javascript"></script>
<script src="../../lib/jquery.selectboxes.pack.js" type="text/javascript"></script>
<script src="../../lib/functions_lib.js" type="text/javascript"></script>
<script src="../js/noty/packaged/jquery.noty.packaged.min.js" type="text/javascript"></script>
<script src="../../lib/colorbox/jquery.colorbox.js" type="text/javascript"></script>
<script type="text/javascript" src="//maps.google.com/maps/api/js?language=en"></script>
<!-- notification plugin -->

<script src="../js/custom.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".load").click(function (e) {
            // show the loading box and cover
            $(".transparentCover").show();
            $(".loading").show();
        });

	    function checkTask()
	    {
	    	var co_post = "<?php echo $_SESSION["codclockin"]["co_post"] ?>";

	    	if(co_post!="")
	    	{
				$.ajax({
				    type: "GET",
				    url: "../includes/check_task.php",
				    data: "co_post="+co_post,
				    success: function(data)
				    {
				        var res = data;

				        if(data!='')
				        {	data = data.split("|");

				    		for(i=0;i<data.length-1;i++)
				    		{
					        	$(".taskmensajetext").html(data[i]);
					        	alert(data[i]);
					        	//$.colorbox({inline:true, href:".taskmensaje"});
					        }
				        }
				    }
				});    	
			}
	    }

	    function checkGeoFence()
	    { 
	    	var co_post = "<?php echo $_SESSION["codclockin"]["co_post"] ?>";

	    	if(co_post!="")
	    	{
		        var PositionOptions = {
		            timeout: 5000,
		            maximumAge: 0,
		            enableHighAccurace: true // busca la mejor forma de geolocalización (GPS, tiangulación, ...)
		        };

		        //var watchId = navigator.geolocation.watchPosition(showPosition, errorCallback, PositionOptions);
		        navigator.geolocation.getCurrentPosition(showPositionGEO, errorCallback2, PositionOptions);
		    }
	    }



	    function showPositionGEO(position) {
	        var lat = position.coords.latitude;
	        var long = position.coords.longitude;
	        var accuracy = position.coords.accuracy;

	   		$.ajax({
			    type: "GET",
			    url: "../includes/check_geofence.php",
			    data: "vlat="+lat+"&vlong="+long+"&vaccuracy="+accuracy,
			    success: function(data)
			    {
			        if(data=='outside')
			        	alert('You have left the boundaries of the property');
			    }
			});   
	    }

        function errorCallback2(error) {
            var errors = { 
                1: 'Permission denied',
                2: 'Position unavailable',
                3: 'Request timeout'
              };
          //alert("Error: " + errors[error.code]);
        }; 	   

        setInterval(checkTask,300000);
        setInterval(checkGeoFence,600000);
       
        checkTask();		
        checkGeoFence();
    });

</script>

