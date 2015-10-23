{if $motivo eq 'captcha'}
    El código de seguridad introducido no es válido.<br /><br />
    Por favor vuelve <a href='javascript:history.go(-1)'>a la página anterior</a> e itentalo de nuevo.
{elseif $motivo eq 'email'}
    Email no encontrado en nuestros registros.<br /><br />
    Por favor vuelve <a href='javascript:history.go(-1)'>a la página anterior</a> e itentalo de nuevo.
{elseif $motivo eq 'token'}
     Códido de seguridad no válido.<br /><br />
     Vuelva a requirir un nuevo código en la <a href='{$home}'>página principal</a>
{elseif $motivo eq 'email_server'}
     Error al intentar enviar el correo para el cambio de contraseña.<br /><br />
     Intenteló pasados unos minutos de nuevo a través de la <a href='{$home}'>página principal</a>
{else}
     La contraseña se ha cambiado correctamente.<br /><br />
     Puede entrar a través de la <a href='{$home}'>página principal</a>
{/if}




