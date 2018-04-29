
<HTML>
<HEAD>
<TITLE>Rushmore Image Map</TITLE>
<SCRIPT LANGUAGE="JavaScript">


// this function swaps images for the first example
function change_image1(image_name) {
	document.rushmore1.src = "../api/skyline.jpg/" + image_name;
}

// this function swaps images for the second example
function change_image2(image_name) {
	document.rushmore2.src = "../images/" + image_name; //this one will be the shaded version
}


// this function resets the images as the original picture
// after the mouse is moved away
function reset_image() {
	document.rushmore1.src = "../images/rushmore.jpg";
	document.rushmore2.src = "../images/rushmore.jpg";
}


// this function resets the textbox 
function resetBox(){
	document.the_form.the_text.value = "Move the mouse over an area of the map.";
}

// this function writes in the textbox
function writeInForm(text_to_write){
	document.the_form.the_text.value = text_to_write;
}


</SCRIPT>
</HEAD>

<!-- table with images and a form-->
<BODY bgcolor="#FFFFFF">
<TABLE width="100%" border="0">
  <TR>
    <TD>
		<CENTER>
        <B>Example 1<BR>
        Simple JavaScript image map example<BR>
        </B><BR>
        <<img src="../static/img/Chicago_Neighborhoods.jpg"
		 usemap="#rushmore_map1" name="rushmore1" border="0"></A> 
      </CENTER>
	</TD>
    <TD>
        <FORM name="the_form">
		<BR>
		<CENTER>
         
		</CENTER>
        </FORM>
	</TD>
  </TR>
</TABLE>
<BR>
<CENTER>
Select <b>View --> Source</b> from the menu bar
<br>to see the source code for this program
</CENTER>
<!-- image map information; first map-->
	 <map name="rushmore_map1"> 
		<AREA SHAPE="poly" coords="16,67,5,42,5,18,13,3,46,3,66,38,61,57,42,67" 
			href="http://www.whitehouse.gov/history/presidents/gw1.html" 
			alt="George Washington"	title="George Washington" target="_blank"
			onMouseOver="change_image1('washington.jpg')"
			onMouseOut = "reset_image()">
		<AREA SHAPE="poly" coords="97,86,110,68,103,34,86,26,71,25,65,51,71,75" 
			href="http://www.whitehouse.gov/history/presidents/tj3.html"
			alt="Thomas Jefferson"	title="Thomas Jefferson" target="_blank"
			onMouseOver="change_image1('jefferson.jpg')"
			onMouseOut = "reset_image()">
		<AREA SHAPE="poly" coords="117,88,117,111,143,113,149,96,154,68,137,54,116,52" 
			href="http://www.whitehouse.gov/history/presidents/tr26.html"
			alt="Theodore Roosevelt" title="Theodore Roosevelt" target="_blank" 
			onMouseOver="change_image1('roosevelt.jpg')"
			onMouseOut = "reset_image()">
		<AREA SHAPE="rect" coords="166,43,216,115" 
			href="http://www.whitehouse.gov/history/presidents/al16.html"
			alt="Abraham Lincoln" title="Abraham Lincoln" target="_blank"
			onMouseOver="change_image1('lincoln.jpg')"
			onMouseOut = "reset_image()"> 
	</map>
<!-- image map information; second map -->
	<map name="rushmore_map2"> 
		<Area shape="poly" coords="16,67,5,42,5,18,13,3,46,3,66,38,61,57,42,67" 
			href="http://www.whitehouse.gov/history/presidents/gw1.html" alt="George Washington" 
			title="George Washington" target="_blank"
			onMouseOver="change_image2('washington.jpg');
			writeInForm('The 1st President')"
			onMouseOut = "reset_image();resetBox()">
		<Area shape="poly" coords="97,86,110,68,103,34,86,26,71,25,65,51,71,75" 
			href="http://www.whitehouse.gov/history/presidents/tj3.html"
			alt="Thomas Jefferson" title="Thomas Jefferson" target="_blank"
			onMouseOver="change_image2('jefferson.jpg');
			writeInForm('The 3rd President')"
			onMouseOut = "reset_image();resetBox()">
		<Area shape="poly" coords="117,87,117,110,143,112,149,95,154,67,137,53,116,51" 
			href="http://www.whitehouse.gov/history/presidents/tr26.html"
			alt="Theodore Roosevelt" title="Theodore Roosevelt" target="_blank" 
			onMouseOver="change_image2('roosevelt.jpg');
			writeInForm('The 26th President')"
			onMouseOut = "reset_image();resetBox()">
		<Area shape="rect" coords="166,43,216,115" 
			href="http://www.whitehouse.gov/history/presidents/al16.html"
			alt="Abraham Lincoln" title="Abraham Lincoln" target="_blank"
			onMouseOver="change_image2('lincoln.jpg');writeInForm('The 16th President')"
			onMouseOut = "reset_image();resetBox()">
	</map> 
</BODY>
</HTML>