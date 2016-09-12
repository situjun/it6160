function checkSignUp(){
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var password2 = document.getElementById("password2").value;
    
    var firstName = document.getElementById("firstName").value;
    var lastName = document.getElementById("lastName").value;
    if(email == ''){
        alert('Input email please');
        return false;
    } else if(password == ''){
        alert('Input password please');
        return false;
    }else if(firstName == ''){
        alert('Input First Name please');
        return false;
    }else if(lastName == ''){
         alert('Input Last Name please');
        return false;
    }else if(password != password2){
        alert('Password entries must match.');
        return false;
    }
    
   
}
function checkUpdate(){
   
    var password = document.getElementById("passwordUpdate").value;
    var password2 = document.getElementById("passwordUpdate2").value;
    
    if(password.replace(/^\s+/g,"").replace(/\s+$/g,"") != ""){
        if(password != password2){
            alert('Password entries must match.');
            return false;
        }
    }
    
    
   
}