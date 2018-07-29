let pageWidth = window.innerWidth || document.body.clientWidth;
let treshold = Math.max(1,Math.floor(0.01 * (pageWidth)));
let touchstartX = 0;
let touchstartY = 0;
let touchendX = 0;
let touchendY = 0;

const limit = Math.tan(45 * 1.5 / 180 * Math.PI);
const gestureZone1 = document.getElementsByClassName('sidebar-swipe')[0];
const gestureZone2 = document.getElementsByClassName('sidebar')[0];
const gestureZone3 = document.getElementsByClassName('chat-swipe')[0];
const gestureZone4 = document.getElementsByClassName('chat')[0];

gestureZone1.addEventListener('touchstart', function(event) {
    touchstartX = event.changedTouches[0].screenX;
    touchstartY = event.changedTouches[0].screenY;
}, false);

gestureZone1.addEventListener('touchend', function(event) {
    touchendX = event.changedTouches[0].screenX;
    touchendY = event.changedTouches[0].screenY;
     if (handleGesture(event)=="right"){
      sidebarAnimateIn();
     }
}, false);
gestureZone2.addEventListener('touchstart', function(event) {
    touchstartX = event.changedTouches[0].screenX;
    touchstartY = event.changedTouches[0].screenY;
}, false);

gestureZone2.addEventListener('touchend', function(event) {
    touchendX = event.changedTouches[0].screenX;
    touchendY = event.changedTouches[0].screenY;
     if (handleGesture(event)=="left"){
      sidebarAnimateOut();
     }
}, false);
gestureZone3.addEventListener('touchstart', function(event) {
    touchstartX = event.changedTouches[0].screenX;
    touchstartY = event.changedTouches[0].screenY;
}, false);

gestureZone3.addEventListener('touchend', function(event) {
    touchendX = event.changedTouches[0].screenX;
    touchendY = event.changedTouches[0].screenY;
    if (handleGesture(event)=="left"){
     chatAnimateIn();
    }
}, false);
gestureZone4.addEventListener('touchstart', function(event) {
    touchstartX = event.changedTouches[0].screenX;
    touchstartY = event.changedTouches[0].screenY;
}, false);

gestureZone4.addEventListener('touchend', function(event) {
    touchendX = event.changedTouches[0].screenX;
    touchendY = event.changedTouches[0].screenY;
     if (handleGesture(event)=="right"){
      chatAnimateOut();
     }
}, false);
function handleGesture(e) {
    let x = touchendX - touchstartX;
    let y = touchendY - touchstartY;
    let xy = Math.abs(x / y);
    let yx = Math.abs(y / x);
    if (Math.abs(x) > treshold || Math.abs(y) > treshold) {
        if (yx <= limit) {
            if (x < 0) {
                return "left";
            } else {
                return"right";
            }
        }
        if (xy <= limit) {
            if (y < 0) {
                return"top";
            } else {
                return"bottom";
            }
        }
    } else {
        return"tap";
    }
}
