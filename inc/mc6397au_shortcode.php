<?php

// FUNCTION RUNS WHEN THE SHORTCODE IS CALLED

function mc6397au_shortcode() { 

ob_start();

$mc6397code = " <body onload='counter()'> <span id='mc6397au_Counter'>Calculating ...</span> </body> ";
echo $mc6397code;

$output = ob_get_clean();
return $output;

}

// register shortcode
add_shortcode('mcau_annual_upcounter', 'mc6397au_shortcode'); 

ob_get_contents();
