function camposVaciosLogin(){
    if(document.frmLogin.matricula.value.length==0){
        document.getElementById("matricula").focus();
        return false;
    }
    if(document.frmLogin.contrasenia.value.length==0){
        document.getElementById("contrasenia").focus();
        return false;
    }
    frmLogin.submit();
}