var RegisterForm = document.getElementById("SignUp");
var LoginForm = document.getElementById("Login");



function registerOpenBttn(){
    RegisterForm.style.display = "block";
    LoginForm.style.display = "none";

}
function LoginOpenBttn(){
    RegisterForm.style.display = "none";
    LoginForm.style.display = "block";
}