<?php

if(isset($_GET["func"]))
{
    $_GET["func"]($_GET["param"],'ajax');
    
}
//valida si existe un dominio de una dirección de email
function domain_exists($email, $via = 'script'){
        $record = 'MX';
	list($user, $domain) = split('@', $email);
        $resultado =checkdnsrr($domain, $record);
        
        if($via == "ajax")
        {
            if($resultado)
                echo "ok";
            else 
                echo "ko";
            
        }
        
        return $resultado;
        
}

