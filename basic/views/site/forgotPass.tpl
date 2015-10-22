<script>
    function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    var botonEnviar = document.getElementById("botonEnviar");
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1.value === pass2.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Contraseñas ok!";

        botonEnviar.style.visibility = "visible";
        
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Contraseñas no coinciden!"
      
        botonEnviar.style.visibility = "hidden";
    }
}
</script>
<form action="http://localhost/familiadigital/basic/web/index.php?r=site/changepass" method="post">
<div>
    <form>
        <label for='email'>Email</label><input type="text" name="email" id="email" value="{$smarty.get.email}" readonly>
        <div class="fieldWrapper">
            <label for="pass1">Password:</label>
            <input type="password" name="pass1" id="pass1">
        </div>
        <div class="fieldWrapper">
            <label for="pass2">Confirm Password:</label>
            <input type="password" name="pass2" id="pass2" onkeyup="checkPass(); return false;">
            <span id="confirmMessage" class="confirmMessage"></span>
        </div>
        <input type="hidden" name='token' id='token' value="{$smarty.get.token}">
        <input type="hidden" name="_csrf" value="NmxpOThpZDVlCgYJAFAgd24JIWpSBAYDQzpYQU8YAAR8OlpcfFAgWQ==">
        <input id="botonEnviar" type="submit" value='enviar' style="visibility: hidden"></input>
    </form>
</div>


    
    

   
    
    
</form> 