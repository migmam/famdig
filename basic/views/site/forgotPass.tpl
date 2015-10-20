<form action="http://localhost/familiadigital/basic/web/index.php?r=site/changepass" method="post">
    
    
    <label for='email'>Email</label><input type="text" name="password">
    <label for="password">Contraseña</label><input type="password" name="password">
    <input type="submit" value='enviar'></input>
    <input type="hidden" name='token' id='token' value="{$smarty.get.token}">
    
    
</form> 