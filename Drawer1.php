<html>
<head>
<meta charset="utf-8">
<title>DRAWer</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png"  href="logo.png">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<style>
body{
	overscroll-behavior: contain;
}
	.canvasDesign {
  border: 2px solid silver;
  position: absolute;
}
.toolbar > div{
	text-align: center;
	border:none;
	padding: 3px;
	margin: 3px;
	cursor: pointer;
	background-color: #00A878;
}
.toolbar > button{
	text-align: center;
	border:none;
	padding: 3px;
	margin: 3px;
	cursor: pointer;
	background-color: #00A878;
}
.toolbar > label{
	text-align: center;
	border:none;
	padding: 3px;
	margin: 3px;
	cursor: pointer;
	background-color: #00A878;
}
.toolbar, .menu, .back{
	
	z-index: 1;
	background-color: #AFD2E9;
	border-radius: 10px;
	padding: 10px;
	margin: 5px;
}
.toolbar{
	position: absolute;
	float: left;
	visibility: hidden;
	display: flex;
	flex-wrap: wrap;
	max-width: 50%;
}
.menu{
	right: 10px;	
	position: absolute;
	display: block;
	border: 2px solid silver;
	visibility: visible;
}
.back{
	right: 20px;	
	position: absolute;
	border: 2px solid silver;
	background-color: #00A878;
	display: none;
}
.upload-img > input{
	display: none;
	width: 0;
	height: 0;
}

i{
	font-size: 2em;
}
.size{
	font-size: 1.5em;
}
.savecloud{
	visibility: hidden;
	z-index: 1;
	top:90%;
	left:5%;
	position: absolute;
}
.showfiles{
	visibility: hidden;

}
tbody,thead,table {
    border: 1px solid black;
    z-index: 1;
    display: none;
}
thead > td{
	width: 100%;
}
table {
  border-collapse: collapse;
  display: none;
  position: absolute;
  top: 50%;
  left: 50%;
  font-size: 20px;
  background: #AFD2E9;
  padding: 15px;
  border-radius: 10px;
  z-index: 1;
  transform: translate(-50%, -50%);
  width: 95%;
  height: 95%;
  overflow:auto;
}
td ,th{
  border: 1px solid black;
}
th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #00A878;
  color: white;

}
</style>
</head>
    <script type="text/javascript">
    var canvas, ctx, flag = false,
        prevX = 0,
        currX = 0,
        prevY = 0,
        currY = 0,
        dot_flag = false;

    var x = "black",
        y = 2;
		
	var backcolor="#fffffe";
	var mousePressed=false;
    
    function makecanvas(){

    	var mycanvas = document.createElement("canvas");
		 mycanvas.setAttribute("id","can");

    mycanvas.classList.add("canvasDesign");
  mycanvas.height = document.body.offsetHeight-5;
    mycanvas.width = document.body.offsetWidth-5;
    document.body.appendChild(mycanvas);

    }

    function init(color) {

		makecanvas();

		var x = document.getElementById('toolbar');
  		x.style.maxHeight=document.body.offsetHeight-5+"px";
  		x.style.visibility= "hidden";

        canvas = document.getElementById('can');
        ctx = canvas.getContext("2d");
		ctx.fillStyle = color;
		backcolor=color;
		ctx.fillRect(0, 0, canvas.width, canvas.height);
        w = canvas.width;
        h = canvas.height;
		cPush();
    
        canvas.addEventListener("mousemove", function (e) {
            findxy('move', e)
        }, false);
        canvas.addEventListener("mousedown", function (e) {
            findxy('down', e);
			mousePressed = true;
        }, false);
        canvas.addEventListener("mouseup", function (e) {
            findxy('up', e);
			if (mousePressed) {
            mousePressed = false;
            cPush();
        }
        }, false);
        canvas.addEventListener("mouseout", function (e) {
            findxy('out', e);
			if (mousePressed) {
            mousePressed = false;
            cPush();
        }
        }, false);

		// Set up touch events for mobile, etc
		canvas.addEventListener("touchstart", function (e) {
		        mousePos = getTouchPos(canvas, e);
		  var touch = e.touches[0];
		  var mouseEvent = new MouseEvent("mousedown", {
		    clientX: touch.clientX,
		    clientY: touch.clientY
		  });
		  canvas.dispatchEvent(mouseEvent);
		}, false);
		canvas.addEventListener("touchend", function (e) {
		  var mouseEvent = new MouseEvent("mouseup", {});
		  canvas.dispatchEvent(mouseEvent);
		}, false);
		canvas.addEventListener("touchmove", function (e) {
		  var touch = e.touches[0];
		  var mouseEvent = new MouseEvent("mousemove", {
		    clientX: touch.clientX,
		    clientY: touch.clientY
		  });
		  canvas.dispatchEvent(mouseEvent);
		}, false);

		// Get the position of a touch relative to the canvas
		function getTouchPos(canvasDom, touchEvent) {
		  var rect = canvasDom.getBoundingClientRect();
		  return {
		    x: touchEvent.touches[0].clientX - rect.left,
		    y: touchEvent.touches[0].clientY - rect.top
		  };
		}

		// Prevent scrolling when touching the canvas
		document.body.addEventListener("touchstart", function (e) {
		  if (e.target == canvas) {
		    e.preventDefault();
		  }
		}, false);
		document.body.addEventListener("touchend", function (e) {
		  if (e.target == canvas) {
		    e.preventDefault();
		  }
		}, false);
		document.body.addEventListener("touchmove", function (e) {
		  if (e.target == canvas) {
		    e.preventDefault();
		  }
		}, false);




        
    }

	/*// Close the dropdown if the user clicks outside of it
	window.onclick = function(event) {
	  if (!event.target.matches('.dropbtn')) {

		var dropdowns = document.getElementsByClassName("dropdown-content");
		var i;
		for (i = 0; i < dropdowns.length; i++) {
		  var openDropdown = dropdowns[i];
		  if (openDropdown.classList.contains('show')) {
			openDropdown.classList.remove('show');
		  }
		}
	  }
	}
	
	function selectsize() {
		var e = document.getElementById("myDropdown");
		var strUser = e.options[e.selectedIndex].text;
		y=strUser;
	}*/

	function selectsize() {
	
		var slider = document.getElementById('myRange');
		var output = document.getElementById('demo');
		output.innerHTML = slider.value;
		y=slider.value;

		slider.onchange = function() {
		  	output.innerHTML = this.value;
		  	y=this.value;

		}
	}
	/*	
	Template.myTemplate.rendered = function(){
		document.getElementById("slider").oninput = function() {
		     changesize()
		};
	}
	

	function changesize() {
	   var val = document.getElementById("slider").value;//gets the oninput value
	   document.getElementById('output').innerHTML = val;//displays this value to the html page
	   y=val;
	}*/

	function hexToRgb(hex) {
		// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
		var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		hex = hex.replace(shorthandRegex, function(m, r, g, b) {
			return r + r + g + g + b + b;
		});

		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? {
			r: parseInt(result[1], 16),
			g: parseInt(result[2], 16),
			b: parseInt(result[3], 16)
		} : null;
	}

	
	function changebackground(col)	{
		//init(col);
		var currR=hexToRgb(backcolor).r;
		var currG=hexToRgb(backcolor).g;
		var currB=hexToRgb(backcolor).b;
		var newR=hexToRgb(col).r;
		var newG=hexToRgb(col).g;
		var newB=hexToRgb(col).b;
		
		var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
		var pixelArray = imageData.data;
		var length = pixelArray.length / 4; // 4 components - red, green, blue and alpha
				
		for (var i = 0; i < length; i++) {
			var index = 4 * i;

			var r = pixelArray[index];
			var g = pixelArray[++index];
			var b = pixelArray[++index];
			var a = pixelArray[++index];

			if (r > currR-30 && r < currR+30 && 
			g > currG-30 && g < currG+30 && 
			b > currB-30 && b < currB+30 & a === 255) { // pixel is red				
				pixelArray[--index] = newB; // blue is set to 100%
				pixelArray[--index] = newG; // green is set to 100%
				pixelArray[--index] = newR;		
								
			}
		}
		backcolor=col;
		ctx.putImageData(imageData, 0, 0)
		cPush();
	}
	
	var currBrushcol="black";

    function color(obj) {
		x=obj;
		currBrushcol=obj;
    }
	
	function eraser() {
		x=backcolor;
	}

	function brush() {
		x=currBrushcol;
	}
    
    function draw() {		// tutaj bedzie usuwanie zapisane
        ctx.beginPath();
        ctx.moveTo(prevX, prevY);
        ctx.lineTo(currX, currY);
		//ctx.arc(currX, currY, y, 0, 2 * Math.PI);
		ctx.lineJoin = 'round';
		ctx.lineCap = 'round';
        ctx.strokeStyle = x;
        ctx.lineWidth = y;
        ctx.stroke();
        ctx.closePath();
    }
    
    function erase() {
        var m = confirm("Do you want to CLEAR the current image?");
        if (m) {
            ctx.clearRect(0, 0, w, h);
            document.getElementById("canvasimg").style.display = "none";
			cPush();
			x="black";
			currBrushcol="black";
			y=5;
			backcolor="white";
        }
    }
    
    function save() {
		var m = confirm("Do you want to SAVE the current image?");
		if (m) {
			//document.getElementById("canvasimg").style.border = "2px solid";
			var dataURL = canvas.toDataURL();
			//document.getElementById("canvasimg").src = dataURL;
			//document.getElementById("canvasimg").style.display = "inline";
			var xhr = new XMLHttpRequest();
			xhr.open("GET", dataURL, true);
			xhr.responseType = "blob";
			xhr.onload = function(){
			var urlCreator = window.URL || window.webkitURL;
			var imageUrl = urlCreator.createObjectURL(this.response);
			var tag = document.createElement('a');
			tag.href = imageUrl;
			var currentdate = new Date(); 
			var datetime = currentdate.getDate() + "_"
					+ (currentdate.getMonth()+1)  + "_" 
					+ currentdate.getFullYear()  
					+ currentdate.getHours() + "_"  
					+ currentdate.getMinutes() + "_" 
					+ currentdate.getSeconds();
			tag.download = 'image'+datetime;
			document.body.appendChild(tag);
			tag.click();
			document.body.removeChild(tag);
			}
			xhr.send();
		}
    }

    function pushtocloud(){
    	var getfilename=document.getElementById('gotofilename');
    	var filename=document.getElementById('filename');
    	var hiddendate=document.getElementById('date');
    	var imgdata=document.getElementById('data');
    	if(getfilename.style.visibility==="visible")
    	{
    		getfilename.style.visibility="hidden";
    		return;
    	}
    	getfilename.style.visibility="visible";
    	var currentdate = new Date();
    	var mydatetime = currentdate.getFullYear()+ "-"+
    	(currentdate.getMonth()+1) + "-" + currentdate.getDate() + " "  
					+ currentdate.getHours() + ":" 
					+ currentdate.getMinutes() + ":"
					+ currentdate.getSeconds();

		var name='image'+mydatetime;
		hiddendate.value=mydatetime;

		filename.value=name;

    var canvasData = canvas.toDataURL("image/png");
    imgdata.value=canvasData;

    


    }

    function saveincloud()
    {
    	var filename = $("#filename").val();
    	var date = $("#date").val();
    	var data = $("#data").val();
    	var div = document.getElementById('gotofilename');
    //$.post("base.php", { filename: filename , date: date},
    //function(data) {
	 //$('#wynik').html(data);
	 //alert("Data has been saved");
	 //$('#form')[0].reset();

    //});
		$.ajax({
        	url: 'base.php',
            type: 'post',
            data: {filename: filename , date: date, data: data},
            success: function (response) {
               	alert(response);                
	 			$('#form')[0].reset();
	 			div.style.visibility="hidden";
            }
        });
    }

    function openfromcloud()
    {
    	var t = document.getElementsByTagName("thead")[0];
    	//var tt = document.getElementsByTagName("tr");
    	var cc = document.getElementById("showfiles");
    	
    	t.style.display="block";
		//tt.style.display="block";
		cc.style.visibility="visible";
    	var table = document.getElementsByTagName("table")[0];
    	table.style.display="block";
		var tbody = table.getElementsByTagName("tbody")[0];
		tbody.style.display="block";
		var b=document.getElementById("back");
    	b.style.display="block";
		tbody.onclick = function (e) {
	    e = e || window.event;
	    var data = [];
	    var target = e.srcElement || e.target;
	    while (target && target.nodeName !== "TR") {
	        target = target.parentNode;
	    }
	    if (target) {
        	var cells = target.getElementsByTagName("td");
        	data.push(cells[0].innerHTML);
        
    }

	    var value=document.getElementById('idtable');
	    value.value=data;

		var idtable = $("#idtable").val();
	    $.ajax({
        	url: 'load.php',
            type: 'post',
            data: {idtable: idtable},
            success: function (response) {
            	ctx.clearRect(0, 0, canvas.width, canvas.height);
               	var myImage = new Image();
               	myImage.onload=function(){
					ctx.drawImage(myImage, 0, 0);
				};
				myImage.src = response;
				
				

		    	var t = document.getElementsByTagName("thead")[0];
		    	var cc = document.getElementById("showfiles");
		    	t.style.display="none";
				cc.style.visibility="hidden";
		    	var table = document.getElementsByTagName("table")[0];
		    	table.style.display="none";
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.style.display="none"; 
				var b=document.getElementById("back");
    			b.style.display="none";         
            }

        });

};

cPush();  
	var p = ctx.getImageData(0, 0, 1, 1).data; 
	var hex = "#" + ("000000" + rgbToHex(p[0], p[1], p[2])).slice(-6);
	
	backcolor=hex;

    }

    function back()
    {
    	var t = document.getElementsByTagName("thead")[0];
		    	var cc = document.getElementById("showfiles");
		    	t.style.display="none";
				cc.style.visibility="hidden";
		    	var table = document.getElementsByTagName("table")[0];
		    	table.style.display="none";
				var tbody = table.getElementsByTagName("tbody")[0];
				tbody.style.display="none"; 
				var b=document.getElementById("back");
    			b.style.display="none";   
    }

    function rgbToHex(r, g, b) {
	    if (r > 255 || g > 255 || b > 255)
	        throw "Invalid color component";
	    return ((r << 16) | (g << 8) | b).toString(16);
	}
	
	// UPLOADING IMAGES TODO
	function upload() {
		var imageLoader = document.getElementById('imageLoader');
		imageLoader.addEventListener('change', handleImage, false);
		//canvas = document.getElementById('can');
	    //ctx = canvas.getContext("2d"); 

		
		
	}

	function handleImage(ee){
		var reader = new FileReader();
		reader.onload = function(event){
			var img = new Image();
			img.onload = function(){
				//canvas.width = img.width;
				//canvas.height = img.height;
				img.width = canvas.width;
				img.height = canvas.height;
				ctx.drawImage(img,0,0);

				var p = ctx.getImageData(0, 0, 1, 1).data; 
	    		var hex = "#" + ("000000" + rgbToHex(p[0], p[1], p[2])).slice(-6);

				backcolor=hex;  
			}
			img.src = event.target.result;
		}
			
		reader.readAsDataURL(ee.target.files[0]);


		   
	}

    function findxy(res, e) {
        if (res == 'down') {
            prevX = currX;
            prevY = currY;
            currX = e.clientX - canvas.offsetLeft;
            currY = e.clientY - canvas.offsetTop;
    
            flag = true;
            dot_flag = true;
            if (dot_flag) {
                ctx.beginPath();
                ctx.fillStyle = x;
                ctx.fillRect(currX, currY, 2, 2);
				//ctx.arc(currX, currY, y, 0, 2 * Math.PI);
				ctx.stroke();
                ctx.closePath();
                dot_flag = false;
            }
        }
        if (res == 'up' || res == "out") {
            flag = false;
        }
        if (res == 'move') {
            if (flag) {
                prevX = currX;
                prevY = currY;
                currX = e.clientX - canvas.offsetLeft;
                currY = e.clientY - canvas.offsetTop;
                draw();
            }
        }
    }
	
	var cPushArray = new Array();
	var cStep = -1;
	
	function cPush() {
    cStep++;
    if (cStep < cPushArray.length) { cPushArray.length = cStep; }
    cPushArray.push(document.getElementById('can').toDataURL());
	}
	
	function cUndo() {
    if (cStep > 0) {
        cStep--;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0); }
    }
}

function cRedo() {
    if (cStep < cPushArray.length-1) {
        cStep++;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0); }
    }
}

function showmenu(){
	
  var x = document.getElementById('toolbar');
  var y = document.getElementById('gotofilename');
  x.style.maxHeight=document.body.offsetHeight-5+"px";

  if (x.style.visibility == "hidden") {
    x.style.visibility = "visible";
  } else {
    x.style.visibility = "hidden";
  }
  if(y.style.visibility=="visible")
  	y.style.visibility="hidden";

}

window.onbeforeunload = function() {
  return "Data will be lost if you leave the page, are you sure?";
};

$(window).scroll(function() {
   if ($(document).scrollTop() >= 1) {
      $("html").css({
         "touch-action": "auto"}
      );
   } else {
      $("html").css({
         "touch-action": "pan-down"
      });
   }
});
    </script>

    <body onload="init('#fffffe')">

    <div class="menu" id="menu" onclick="showmenu()"><i class="fas fa-tools"></i></div>

		<div class="toolbar" id="toolbar">

			<div class="btnsize" id="btn" size="50" onchange="selectsize()"><p class="size" id="demo">5</p><input type="range" name="myRange" id="myRange" min="1" max="80" value="5"></div>
			
			<button class="div-icon" id="undo" size="23" onclick="cUndo();return false;"><i class="fas fa-undo-alt"></i></button>
			<button class="div-icon" id="redo" size="23" onclick="cRedo();return false;"><i class="fas fa-redo-alt"></i></button> 
			<button class="div-icon" id="white" onclick="eraser()"><i class="fas fa-eraser"></i></button>
		<button id="white" onclick="brush()"><i class="fas fa-paint-brush"></i></button>
		<button>
		<label for="brushcol"><i class="fas fa-palette"></i></label> <input type="color" id="brushcol" value="#000002" onchange="color(this.value);" />
	</button>
		<button>
		<label for="backcol"><i class="fas fa-fill-drip"></i></label> <input type="color" id="backcol" value="#fffffe" onchange="changebackground(this.value);" />
		</button>

		<button class="upload-img" id="upload" size="50" onclick="upload()"><label for="imageLoader"><i class="fas fa-upload"></i></label><input type="file" id="imageLoader" name="imageLoader" accept="image/*"/></button>

		<button id="btn" size="30" onclick="save()"><i class="fas fa-save"></i></button> 
		<button id="pushTocloud" size="30" onclick="pushtocloud()"><i class="fas fa-cloud"></i></button> 
		<button id="openfromCloud" size="30" onclick="openfromcloud()"><i class="fas fa-box-open"></i></button> 
        <button id="clr" size="23" onclick="erase()" ><i class="fas fa-broom"></i></button> 

		</div>	

		<div id="gotofilename" class="savecloud"><form id="form" action="" method="post"><input type="text" name="filename" id="filename" value="" >
			<input type="hidden" id="date" name="date" value="3487">
			<input type="hidden" id="data" name="data" value="3487">
			<input type="button" id="submitfile" value="Save in cloud" onclick="saveincloud()"></form></div>

		<div id="showfiles">
			<?php include 'show.php';?>
		</div>

		<div id="back" class="back" onclick="back()"><i class="fas fa-chevron-left"></i></div>

		<form style="display: none;"><input type="hidden" id="idtable" name="idtable" value="3487"></form>

		
			
    </body>
    </html>