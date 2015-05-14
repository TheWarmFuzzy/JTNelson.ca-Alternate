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
			"V_A" => "#fff",
			"V_SIDBAR" => "#ccc"
			);
		
		///////////////////////////////////////////////////////
		//End Variables////////////////////////////////////////
		///////////////////////////////////////////////////////

		//Finds and lists variable names
		preg_match_all('/V_[A-Za-z0-9_]*/', $buffer, $matches);

		//Loops through found variables
		foreach ($matches[0] as $value){
			echo $value;
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
	background-color:V_A;
}

aside{
	background-color:V_SIDBAR;
	width:100px;
	height:100%;
}

<?php
	//Grabs contents of buffer
	$buffer = ob_get_contents();
	//Wipes buffer
	ob_end_clean();
	//Replaces variables in buffer then outputs
	echo replace_vars($buffer);
?>
