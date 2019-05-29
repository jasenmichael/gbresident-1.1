
<div class="bs-example">
    <ol class="breadcrumb">



<?php 
	$path = $_SERVER["PHP_SELF"];
	$parts = explode('/',$path);
	if (count($parts) < 2)
	{
	echo("home");
	}
	else
	{
	//echo ("<a href=\"/\">home</a> &raquo; ");
	for ($i = 1; $i < count($parts); $i++)
    	{
    	if (!strstr($parts[$i],"."))
        	{
        	echo("<li class=\"breadcrumb-item\" ><a href=\"");
        	for ($j = 0; $j <= $i; $j++) {echo $parts[$j]."/";};
        	echo("\"><span style=\"font-size: 1.5em;\">". str_replace('-', ' ', $parts[$i])."</span></a></li>");



        	}
    	else
        	{
       	 	$str = $parts[$i];
        	$pos = strrpos($str,".");
        	$parts[$i] = substr($str, 0, $pos);
        	//echo str_replace('-', ' ', $parts[$i]);
        	};
    	};
	};  
?>

    </ol>
</div>

