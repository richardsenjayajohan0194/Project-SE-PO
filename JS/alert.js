function matchPassword() {  
    let pw1 = document.getElementById("password");  
    let pw2 = document.getElementById("cpassword");
    
    if(pw1.value == pw2.value) {   
        alert("Password created successfully");
        return false;
    } else {  
        alert("Wrong confirm password or username has been use");
        return false;
    }

    
}

function Visible(answer){
    if(answer.value == 'Business Partner'){
        document.getElementById('form-box1').style.display="none";
        document.getElementById('form-box2').style.display="block";
        document.getElementById('business_partner2').selected = "true";
    } else if (answer.value == 'User'){
        document.getElementById('form-box1').style.display="block";
        document.getElementById('form-box2').style.display="none";
        document.getElementById('user1').selected = "true";
    }
}

