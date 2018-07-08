var canvas = document.getElementById("canvas");

canvas.width = 1000;
canvas.height = 500;

var ctx = canvas.getContext("2d");

var shouldRotate = false;
var RotateButton = document.getElementById("RotateButton");

var wheel_width;
var wheel_height;
var wheel_img = new Image();
wheel_img.src = "images/wheel.png";

wheel_img.onload = function(){
    wheel_width =  300;
    wheel_height = wheel_img.height/wheel_img.width *300 ;
    console.log();
};

var degrees = 0;
var EndReward;


var speed =6;
var nagrada = null;

console.log(wheel_img.clientWidth);

RotateButton.addEventListener("click", RotateButton_script);
function RotateButton_script(){
    //da nemoze pak da go pritiskaat
    RotateButton.hidden = true;

    //so krug so 6 strani
    //agol za sekoja strana pr: 60
    var a = 360 / 6;
    EndReward = Math.random() * 360;

    nagrada = Math.ceil(EndReward / a);

    EndReward +=  Math.ceil((3-Math.random())) * 360;
    var b =  Math.round(EndReward / 360);

    
    console.log("EndReward=" + nagrada);

    shouldRotate = true;
}


function update(){
    ctx.clearRect(0,0,canvas.width,canvas.height);

    //rotate wheel
    ctx.save();   
    ctx.translate(canvas.width/2,canvas.height/2);
    ctx.rotate(degrees*Math.PI/180);
    var center_Xpos = canvas.width/2 - wheel_width/2;
    ctx.drawImage(wheel_img,-wheel_width/2,-wheel_height/2,wheel_width,wheel_height);
    ctx.restore();

    //draw triagnle
    ctx.beginPath();
    ctx.moveTo(canvas.width/2 -20, 5);
    ctx.lineTo(canvas.width/2 +20, 5);
    ctx.lineTo(canvas.width/2, 40);
    ctx.fill();

    if(shouldRotate === true){
        degrees+= speed;
        if(degrees > EndReward / 2){
            speed = 4;
        }
        if(degrees > EndReward / 1.5)speed = 2;
        if(degrees > EndReward / 1.2)speed = 1;

        if(degrees >= EndReward){
            shouldRotate = false;
            //Get Reward Here
            switch(nagrada){
                case 1 : alert("Nagrada : 1");break;
                case 2 : alert("Nagrada : 2");break;
                case 3 : alert("Nagrada : 3");break;
                case 4 : alert("Nagrada : 4");break;
                case 5 : alert("Nagrada : 5");break;
                case 6 : alert("Nagrada : 6");break;
            }
        }

    }
    requestAnimationFrame(update);
}
requestAnimationFrame(update);