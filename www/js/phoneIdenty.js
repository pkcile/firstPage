function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
        "SymbianOS", "Windows Phone",
        "iPad", "iPod"
    ];
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}
console.log(IsPC());
// alert("phoneIdentify");
if(IsPC()==false) {
    // alert("you are using 非PC端口")
    var mobileHide = document.getElementsByClassName("mobilehide");
    for(let i = 0; i < mobileHide.length; i++) {
        mobileHide[i].style = "display: none";
    }
}
