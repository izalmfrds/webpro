function formkosong(){
    var username=document.getElementById("username").value;
    var password=document.getElementById("password").value;

    if (username.value === '' || username.value == null || password === '' && password == null){
        confirm("Harap isi form");
    } else {
        confirm ("Login sukses")
    }
    
}
