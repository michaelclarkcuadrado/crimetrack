
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
	</map>
</BODY>
</HTML>