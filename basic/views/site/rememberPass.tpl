
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<script>
   
{literal}

var jqueryFunction;


$().ready(function(){
    //jQuery function
    jqueryFunction = function( func,dato, func_back )
    {
       
        $.get("own_functions.php?func="+func+"&param="+dato, func_back); 
        
    }

})



function valida_email()
{
    var email = document.getElementById('email');
    var resultado = document.getElementById('result');
    resultado.innerHTML = "";
    
    if(!valida_email_format(email.value))
    {
        resultado.innerHTML = "Dirección email incorrecta";
        return false;
        
    }
    jqueryFunction('domain_exists',email.value,resultado_validacion);
    
        
    
        
    
}
function resultado_validacion(data,status)
{
    var resultado = document.getElementById('result');
    //alert("Data: " + data + "\nStatus: " + status);
    if(data==='ko')
    {
        resultado.innerHTML = "Dominio de dirección email no existe";
    }else{
        resultado.innerHTML = "Dirección de correo válida";
        document.remember_form.submit();
    }
        
        
}


function valida_email_format(email)
{
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
    
    
    
</script>
{/literal}


<form name='remember_form' action="http://localhost/familiadigital/basic/web/index.php?r=site/sendforgotpass" method="post">
    <div id='emaildata'>
    <label for='email'>Introduzca su Email</label><input type="text" name="email" id='email'>
    <input type="hidden" name="_csrf" value="NmxpOThpZDVlCgYJAFAgd24JIWpSBAYDQzpYQU8YAAR8OlpcfFAgWQ==">
    <input type="button" onclick="valida_email()" value="enviar"></input>
    </div>
    <div id='captchablock'>
        <img id="captcha" src="{$vendor_path}/securimage/securimage_show.php" alt="CAPTCHA Image" />
       <input type="text" name="captcha_code" size="10" maxlength="6" />
        <a href="#" onclick="document.getElementById('captcha').src = '{$vendor_path}/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a
    </div>
    <div id='result'></div>
</form> 