	var helpSteps = 12;
	var helpStepHeight = 8;
	var helpDefault = '';

	var helpCounter = 0;
	var helpSpeed = 1;
	var helpLeft = 181;
	var helpOnScreen = false;
	var helpTimerID = null;

	function setHelp(item)
	{
		var helpContents = findObj("helpContents");

		if (helpOnScreen == true)
		{
			if (item != null && helpArray[item] != null)
				helpContents.innerHTML = unescape(helpArray[item]);
			else
				helpContents.innerHTML = helpDefault;			
		}
	}
	
	function toggleHelp()
	{
		if (helpOnScreen == false)
			displayHelp();
		else
			hideHelp();
	}
	
	function displayHelp()
	{
		var helpLayer = findObj("helpLayer");
		if (helpLayer.style) helpLayer = helpLayer.style;
		
		if (document.all) { 
			helpLayer.pixelWidth = document.body.clientWidth - helpLeft;
			helpLayer.pixelHeight = helpStepHeight;
			helpLayer.pixelLeft = helpLeft;
			helpLayer.pixelTop = document.body.clientHeight + document.body.scrollTop - helpStepHeight;
		} else 	{
			helpLayer.width = document.width - helpLeft;
			helpLayer.height = helpStepHeight;
			helpLayer.left = helpLeft;
			helpLayer.top = window.innerHeight + window.pageYOffset - helpStepHeight;
		}
		helpLayer.visibility = 'visible';

		helpCounter = 1;
		setTimeout('growHelp()', helpSpeed);
		
		var helpContents = findObj("helpContents");
		helpDefault = helpContents.innerHTML;
	}
	
	function growHelp()
	{
		helpCounter++;

		var helpLayer = findObj("helpLayer");
		if (helpLayer.style) helpLayer = helpLayer.style;

		if (document.all) {
			helpLayer.pixelHeight = helpCounter * helpStepHeight;
			helpLayer.pixelTop = document.body.clientHeight + document.body.scrollTop - (helpCounter * helpStepHeight);
		} else {
			helpLayer.height = helpCounter * helpStepHeight;
			helpLayer.top = window.innerHeight + window.pageYOffset - (helpCounter * helpStepHeight);
			if (helpTimerID == null) helpTimerID = setInterval('resizeHelp()', 100);
		}
		
		if (helpCounter < helpSteps)
			setTimeout('growHelp()', helpSpeed);
		else
			helpOnScreen = true;
	}
	
	function resizeHelp()
	{	
		if (helpOnScreen == true) 
		{
			var helpLayer = findObj("helpLayer");
			if (helpLayer.style) helpLayer = helpLayer.style;
	
			if (document.all) {
				helpLayer.pixelHeight = helpSteps * helpStepHeight;
				helpLayer.pixelWidth = document.body.clientWidth - helpLeft;
				helpLayer.pixelTop = document.body.clientHeight + document.body.scrollTop - (helpSteps * helpStepHeight);
			} else {
				helpLayer.height = helpSteps * helpStepHeight;
				helpLayer.width = document.width - helpLeft;
				helpLayer.top = window.innerHeight + window.pageYOffset - (helpSteps * helpStepHeight);
			}
		}
	}
	
	function hideHelp()
	{
		helpOnScreen = false;
		helpCounter = helpSteps;		
		setTimeout('helpShrink()', helpSpeed);
	}

	function helpShrink()
	{
		var helpLayer = findObj("helpLayer");
		if (helpLayer.style) helpLayer = helpLayer.style;

		helpCounter--;
		
		if (helpCounter >= 0) 
		{
			if (document.all) {
				helpLayer.pixelHeight = helpCounter * helpStepHeight;
				helpLayer.pixelTop = document.body.clientHeight + document.body.scrollTop - (helpCounter * helpStepHeight);
			} else {
				helpLayer.height = helpCounter * helpStepHeight;
				helpLayer.top = window.innerHeight + window.pageYOffset - (helpCounter * helpStepHeight);
			}
			setTimeout('helpShrink()', helpSpeed);
		} 
		else 
		{
			if (document.all) {
				helpLayer.pixelHeight = 1;
				helpLayer.pixelTop = document.body.clientHeight + document.body.scrollTop - 1;
			} else {
				helpLayer.height = 1;
				helpLayer.top = window.innerHeight + window.pageYOffset - 1;
			}
			helpLayer.visibility = 'hidden';
			
			var helpContents = findObj("helpContents");
			helpContents.innerHTML = helpDefault;
		}
	}