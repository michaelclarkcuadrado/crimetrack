
<HTML>
<HEAD>
<TITLE>Map</TITLE>
<SCRIPT LANGUAGE="JavaScript">

// this function swaps images for the first example
function change_image(image_name) {
	document.map.src = "../static/img/" + image_name;
}

// this function resets the images as the original picture
// after the mouse is moved away
function reset_image() {
	document.map.src = "../static/img/Chicago_Neighborhoods.jpg";
}

</SCRIPT>
</HEAD>

<!-- table with images and a form-->
<BODY bgcolor="#FFFFFF"> 
    <FORM name="the_form">
		<img src="../static/img/Chicago_Neighborhoods.jpg"
			 usemap="#map1" name="map" border="0" width=400>
	</FORM>

<!-- image map information; first map-->
	<map name="map1"> 
		<AREA SHAPE="rect" coords="158,123,202,149" 
			href="#" 
			alt="Belmont Cragin"	title="Belmont Cragin" target="_blank"
			onMouseOver="change_image('Belmont_Cragin.jpg')"
			onMouseOut = "reset_image()">

			<AREA SHAPE="rect" coords="227,284,257,304" 
			href="#" 
			alt="Gage Park"	title="Gage Park" target="_blank"
			onMouseOver="change_image('Gage_Park.jpg')"
			onMouseOut = "reset_image()">

			<AREA SHAPE="rect" coords="250,183,294,215" 
			href="#" 
			alt="Near West Side"	title="Near West Side" target="_blank"
			onMouseOver="change_image('Near_West_Side.jpg')"
			onMouseOut = "reset_image()">

			<AREA SHAPE="rect" coords="344, 444,377, 382" 
			href="#" 
			alt="South Deering"	title="South Deering" target="_blank"
			onMouseOver="change_image('South_Deering.jpg')"
			onMouseOut = "reset_image()">

			<AREA SHAPE="rect" coords="322, 261, 304, 285" 
			href="#" 
			alt="Grand Boulevard"	title="Grand Boulevard" target="_blank"
			onMouseOver="change_image('Grand_Boulevard.jpg')"
			onMouseOut = "reset_image()">
	</map>
	
</BODY>
</HTML>