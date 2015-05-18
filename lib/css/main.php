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
			"V_Col_Background" => rgb(10,10,10),
			"V_Col_Header" => rgb(100,255,200),
			"V_Col_Sidebar" => "#acc",
			
			"V_Col_Beige" => rgb(254,232,157),
			"V_Col_Beige_Dark" => rgb(230,213,141),
			"V_Col_Aqua" => rgb(98,167,146),
			"V_Col_Gray" => rgb(29,39,51),
			"V_Col_Gray_Dark" => rgb(10,23,45),
			
			"V_Num_Header_Height" => "60px"
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
	background-color:V_Col_Background;
	padding:0px;
}


/*/////////////////////////////////////////////////////
//Header///////////////////////////////////////////////
/////////////////////////////////////////////////////*/

header{
	position:absolute;
	top:0px;
	left:0px;
	height:V_Num_Header_Height;
	width:100%;
	background-color:V_Col_Aqua;
	margin:0px;
	z-index:200;
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

/*/////////////////////////////////////////////////////
//Search Bar///////////////////////////////////////////
/////////////////////////////////////////////////////*/

div.container{
	position:absolute;
	width:100%;
	height:100%;
}
main{
	position: relative;
	top:V_Num_Header_Height;
	margin:-10px auto 0px auto;
	background-color:V_Col_Sidebar;
	width:800px;
	height:100%;
	z-index:100;
}

/*/////////////////////////////////////////////////////
//Search Bar///////////////////////////////////////////
/////////////////////////////////////////////////////*/

aside{
	position:fixed;
	top:0px;
	height:100%;
}

aside.hidden{
	left:-25px;
	width:50px;
	transition: left .2s ease-out;
}

aside.hidden:hover{
	left:0px;
	transition: left .2s ease-out;
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
	background-color:V_Col_Sidebar;
	width:300px;
	left:-300px;
	z-index:500;
	
	transition: left .4s ease-out;
	
}

aside#sidebar:target{
	left:0px;
	
	transition: left .4s ease-out;
}

aside#sidebar:target ~ .mask{
	display:block;
	
}

aside input#tb_search, aside div#div_search_contents{
	margin: 10px 20px;
}

aside input#tb_search, .search_result{
	width:250px;
	
}

.search_result{
	background-color:V_Col_Background;
	height:50px;
}

.search_result:hover{
	background-color:V_Col_Sidebar;
}

.search_result img{
	float:left;
	width:40px;
	height:40px;
	margin:5px;
}

.search_result .sr_title{
	float:left;
	position:relative;
	top: 50%;
	transform: translateY(-50%);
	left:10px;
}


<?php
	//Grabs contents of buffer
	$buffer = ob_get_contents();
	//Wipes buffer
	ob_end_clean();
	//Replaces variables in buffer then outputs
	echo replace_vars($buffer);
?>
