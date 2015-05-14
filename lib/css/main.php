<?php namespace jtn_css;

	//Headers
	header("Content-type: text/css; charset: UTF-8");
	header("Cache-Control: must-revalidate");
	header("Expires:". gmdate("D, d M Y H:i:s", time() + 3600));
	
	//Useful Functions
	//Converts a number to hex
	function hex(){ 
		//Hex dictionary
		$hcc = array(0=>"0", 1=>"1", 2=>"2", 3=>"3", 4=>"4", 5=>"5", 6=>"6", 7=>"7", 8=>"8", 9=>"9", 10=>"a", 11=>"b", 12=>"c", 13=>"d", 14=>"e", 15=>"f");
		//Converts to a hex string (<256)
		return $hcc[intval((func_get_arg(0)%256)/16)] . $hcc[func_get_arg(0)%16];
	};
	
	//Converts an rgb value to hex
	function rgb($r,$g,$b){
		return "#" . hex($r) . hex($g) . hex($b);
	};
	
	//Replaces variables in a string
	function replace_vars($buffer){
	
		///////////////////////////////////////////////////////
		//Variables Go Here////////////////////////////////////
		///////////////////////////////////////////////////////
		
		$my_vars = array(
			"V_Background" => "#fff",
			"V_Sidebar" => "#acc"
			);
		
		///////////////////////////////////////////////////////
		//End Variables////////////////////////////////////////
		///////////////////////////////////////////////////////

		//Finds and lists variable names
		preg_match_all('/V_[A-Za-z0-9_]*/', $buffer, $matches);

		//Loops through found variables
		foreach ($matches[0] as $value){

			//Initializes replace_val
			$replace_val = "";
			
			//Checks if variable is set
			if(isset($my_vars[$value])){
			
				//Sets replace_val to correct variable
				$replace_val = $my_vars[$value];
			}
			
			//Replaces variables in the buffer with the corresponding one in php
			$buffer = str_replace($value, $replace_val, $buffer);
		}
		
		return $buffer;
	}
	
	//Starts output buffer
	ob_start();
?>
/*Welcome*/

body{
	background-color:V_Background;
	padding:0px;
}

header{
	position:absolute;
	top:0px;
	left:0px;
	height:60px;
	width:100%;
	background-color:V_Sidebar;
	margin:0px;
}

header div#inner_header{
	height:100%;
	width:800px;
	margin:0px auto;
}

div#inner_header h1{
	float:left;
	margin:10px 0px 0px 100px;
}

nav{
	float:right;
	margin:5px 100px 0px 0px;
}

nav ul li{
	display:inline-block;
	padding: 0px 10px 0px 10px;
	

}
aside{
	position:fixed;
	top:0px;
	height:100%;
}

aside.hidden{
	left:-25px;
	width:50px;
}

aside.hidden:hover{
	left:0px;
}

svg#arrow{
	position: relative;
	top: 50%;
	transform: translateY(-50%);
}
.mask{
	display:none;
	position:fixed;
	top:0;
    left:0;
	width:100%;
    height:100%;
	opacity:0.0;
	z-index:250;
}

aside#sidebar{
	background-color:V_Sidebar;
	width:300px;
	left:-300px;
	z-index:500;
	
}

aside#sidebar:target{
	left:0px;
}

aside#sidebar:target ~ .mask{
	display:block;
	
}



<?php
	//Grabs contents of buffer
	$buffer = ob_get_contents();
	//Wipes buffer
	ob_end_clean();
	//Replaces variables in buffer then outputs
	echo replace_vars($buffer);
?>
