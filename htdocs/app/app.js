var app = (function()
{
	// Application object.
	var app = {};

	// Dictionary of nearables.
	var nearablesDictionary = {};
	var nearablesInForm = {}

	// Timer that displays list of nearables.
	var updateTimer = null;

	app.initialize = function()
	{
		document.addEventListener(
			'deviceready',
			function() { evothings.scriptsLoaded(onDeviceReady) },
			false);
	};

	function onDeviceReady()
	{
		// Only start scanning for Nearables on iOS.
		if (evothings.os.isIOS())
		{
			loadFormDataFromStorage();

			// Start tracking nearables!
			startScan();

			// Display refresh timer.
			updateTimer = setInterval(displayNearableList, 1000);
			updateTimer2 = setInterval(displayUrlForm, 1000);
		}
	}

	function startScan()
	{
		function onNearablesRanged(nearables)
		{
			// console.log('onNearablesRanged: ' + JSON.stringify(nearables))
			for (var i in nearables)
			{
				// Insert nearable into table of found nearables.
				// Filter out nearables with invalid RSSI values.
				var nearable = nearables[i];
				if (nearable.rssi < 0)
				{
					nearable.timeStamp = Date.now();
					nearable.inUrlForm = false;
					var key = nearable.identifier;
					nearablesDictionary[key] = nearable;
				}
			}
		}

		function onError(errorMessage)
		{
			console.log('Ranging nearables did fail: ' + errorMessage);
		}

		// Start ranging nearables.
		estimote.nearables.startRangingForType(
			estimote.nearables.NearableTypeAll,
			onNearablesRanged,
			onError);
	}

	function loadFormDataFromStorage()
	{
		var storage = window.localStorage;
		var storedUrls = storage.getItem('formData');
		if(storedUrls != undefined) {
			nearablesInForm = JSON.parse(storedUrls);
			$.each(nearablesInForm, function(key, nearable){
				nearablesInForm[key].displayed = false;
			});
		}
		var appData = JSON.parse(storage.getItem('appData'));
		var username = appData.userName;
		$('#username').val(username);
		var token = appData.token;
		$('#token').val(token);
	}

	function displayUrlForm()
	{
		// $('#nearables-urls').empty();
		$.each(nearablesDictionary, function(key, nearable)
		{
			if(nearablesInForm[key]==undefined || !nearablesInForm[key].displayed)
			{
				var type = nearable.nameForType;
				var name = type.charAt(0).toUpperCase() + type.slice(1);
				var value = (nearablesInForm[key] != undefined && nearablesInForm[key].url != undefined) ? nearablesInForm[key].url : '';
				var element = $(
					'<div class="form-group">'
					+ '<label class="col-sm-2" id="lbl-' + nearable.identifier + '">' + name + '</label><input id="' + nearable.nameForType + '" type="url" value="' + value +'"/>'
					+ '</div>'
				);
				$('#nearables-urls').append(element);
				nearablesInForm[key] = nearable;
				nearablesInForm[key].url = value;
				nearablesInForm[key].displayed = true;
			}
		});
	}

	function updateScreen(url) {
		var data = {
			url: url,
			username: encodeURIComponent($('#username').val()),
			token: encodeURIComponent($('#token').val())
		}
		$.post( "../ajax.php", data);
	}

	function displayNearableList()
	{
		// Clear nearables list.
		$('#found-nearables').empty();

		// Update nearables list.
		var timeNow = Date.now();
		$.each(nearablesDictionary, function(key, nearable)
		{
			// Only show nearables that are updated during the last 60 seconds.
			if (nearable.timeStamp + 60000 > timeNow)
			{
				if(nearable.isMoving) {
					// console.log(nearable.nameForType + ' is moving.');
					if(nearablesInForm[key] != undefined) {
						updateScreen(nearablesInForm[key].url);
						$('#lbl-' + nearable.identifier).addClass('active');
						$('#last-sent-url').html(nearablesInForm[key].url);
					}
				}
				else {
					$('#lbl-' + nearable.identifier).removeClass('active');
				}
				// Create tag to display nearable data.
				//console.log(JSON.stringify(nearable));
				var element = $(
					'<li>'
					+	typeNameHTML(nearable)
					+	'Id: ' + nearable.identifier + '<br />'
					+	'Temperature: ' + nearable.temperature + '<br />'
					+   'x: ' + nearable.xAcceleration + '<br />'
					+   'y: ' + nearable.yAcceleration + '<br />'
					+   'z: ' + nearable.zAcceleration + '<br />'
					+	isMovingHTML(nearable)
					+   'Orientation:' + nearable.orientation + '<br />'
					+	zoneHTML(nearable)
					+	rssiHTML(nearable)
					+ '</li>'
				);

				$('#found-nearables').append(element);
			}
		});
	}

	function typeNameHTML(nearable)
	{
		var type = nearable.nameForType;
		var name = type.charAt(0).toUpperCase() + type.slice(1);
		return 'Type: ' + name + '<br />';
	}

	function isMovingHTML(nearable)
	{
		return 'Is moving: ' + (nearable.isMoving ? 'Yes' : 'No') + '<br />';
	}

	function zoneHTML(nearable)
	{
		var zone = nearable.zone;
		if (!zone) { return ''; }

		var zoneNames = [
			'Unknown',
			'Immediate',
			'Near',
			'Far'];

		return 'Zone: ' + zoneNames[zone] + '<br />';
	}

	function rssiHTML(nearable)
	{
		// Map the RSSI value to a width in percent for the indicator.
		var rssiWidth = 1; // Used when RSSI is zero or greater.
		if (nearable.rssi < -100)
		{
			rssiWidth = 100;
		}
		else if (nearable.rssi < 0)
		{
			rssiWidth = 100 + nearable.rssi;
		}
		// Scale values since they tend to be a bit low.
		rssiWidth *= 1.5;

		var html =
			'RSSI: ' + nearable.rssi + '<br />'
			+ '<div style="background:rgb(0,0,155);height:20px;width:'
			+ 		rssiWidth + '%;"></div>'

		return html;
	}

	$(document).ready(function(){
		$('#btnSend').click(function(){
			var storage = window.localStorage;
			$.each(nearablesInForm, function(key, nearable)
			{
				nearablesInForm[key].url = $('#' + nearable.nameForType).val();
			});
			storage.setItem('formData',JSON.stringify(nearablesInForm));
			alert('Saved!');
		});
		$('#btnSaveAppData').click(function(){
			var storage = window.localStorage;
			var appData = {
				userName: $('#username').val(),
				token: $('#token').val()
			}
			storage.setItem('appData', JSON.stringify(appData));
			updateScreen('welcome.php');
		});
	});

	return app;
})();

app.initialize();
