var can;
var ctx;
var canimg;
var x;
var y;
var z;
var xx;
var yy;
var zz;
var t=0;
var interval;
var inter;
var time_ms;
var startTime_ms = Date.now();
var allowOrientationChange = false;
time_ms = Date.now() - startTime_ms;
var arlength;
var arthick;
var scale;
//colors
var logo_yellow = "#E8FD4D";
var logo_green = "#4FB768";
var y_color = "#A4062C";
var x_color = "#005389";
var z_color = "#258600";
var text_color = "#C2C4D3";
var topic_color = "#671E2F";
// for managing screen sizes
var ww;
var hh;
var pixres;
var device;
var view;
var height;
var width;
var current_func=drawDisp;
var recControl;
var rec_array=[];
// for graph
var tpoint=0;
var ypoint_x;
var ypoint_y;
var ypoint_z;
var gcounter;
var draw_rec=false;
var drawval="xyz";
//font size
var dd;
var tg=10;
var dataRefId;
function launchFullScreen(element) {
    if (element.requestFullscreen)

    { element.requestFullscreen(); }

    else if (element.mozRequestFullScreen)

    { element.mozRequestFullScreen(); }

    else if (element.webkitRequestFullscreen)

    { element.webkitRequestFullscreen(); }

    else if (element.msRequestFullscreen)

    { element.msRequestFullscreen(); }
}
function cancelFullScreen() {
    if (document.exitFullscreen) {
    document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
    }
}
function sendmail(addr)
{
    if(addr.indexOf("@")<0)
    {
        alert("Please enter a valid Email address");
        return false;
    }
    $("#loader").show();
    $("#loader-img").show();
    $("#status").text("Sending Email...").css({"color":"silver"});
    localStorage.setItem("PL_Email", addr);
    var req={"email":addr,"data":rec_array,"id":dataRefId};
    $.ajax({
        type: 'POST',
        url: "test.php",
        contentType: "application/json; charset=UTF-8",
        data:JSON.stringify(req),
        success: function (data) {
            $("#loader-img").hide();
            $("#status").text(data).css({"color":"green"});
        },
        error: function (request, status, error) {
            $("#loader-img").hide();
            $("#status").text(request.responseText);
        }
    });
}
function blank()
{
    
}
function rnd_desktop()
{
    if(x==null)
    {
        current_func();
        setTimeout("rnd_desktop()",50);
    }else{
        clearTimeout(rnd_desktop);
    }
}
function coords()
{
    if (x==null) {
        xx = (Math.random()*21)-10;
        yy = (Math.random()*21)-10;
        zz = (Math.random()*5);
        t=t+(Math.random()*21)+10;
    }else{
        xx=x;
        yy=y;
        zz=z;
        t=time_ms;///1000;
    };
        xx=parseFloat(xx.toFixed(2));
        yy=parseFloat(yy.toFixed(2));
        zz=parseFloat(zz.toFixed(2));
        t=parseInt(t);
}

function cls()
{
    ctx.fillStyle="#000000";
    ctx.fillRect(0,0,width,height);
}

function startRecording()
{
    rec_array.push({"t":t,"x":xx,"y":yy,"z":zz});
    recControl=setTimeout("startRecording()",50);
    if(rec_array.length>500)
    {
        stopRecording();
        $("#rec_on").click();
    }    
}

function stopRecording()
{
    clearTimeout(recControl);
}

function scrollCtx(sx)
{
    var img=ctx.getImageData(sx,0,width,height);
    cls();
    ctx.putImageData(img,0,0);
    tpoint=tpoint-sx;
}
var graph_func;
function drawGraph()
{
    if(draw_rec==true)
    {
        xx=rec_array[gcounter].x;
        yy=rec_array[gcounter].y;
        zz=rec_array[gcounter].z;
        t=rec_array[gcounter].t;
        gcounter=gcounter+1;
        if(gcounter>rec_array.length)
        {
            clearTimeout(graph_func);
            gcounter=0;
            //draw_rec=false;
        }
        graph_func=setTimeout("drawGraph()",50);
    }else{
        coords();
    }
    if ((tpoint+tg)>width)
    {
        scrollCtx(tg);
    };
    if (ypoint_x==null)
    {
        cls();
        ypoint_z=ypoint_y=ypoint_x=height/2;
    }
    if ((drawval != "xyz") && (drawval != "x")) {
        ctx.lineWidth = 2;
        tpoint=tpoint+tg;
        ypoint_x=(height/2)+(xx*arthick);
    };
    ctx.beginPath();
    ctx.strokeStyle=x_color;
    ctx.lineWidth = 2;
    ctx.moveTo(tpoint,ypoint_x);
    tpoint=tpoint+tg;
    ypoint_x=(height/2)+(xx*arthick);
    ctx.lineTo(tpoint,ypoint_x);
    ctx.stroke();

    ctx.beginPath();
    ctx.strokeStyle=y_color;
    tpoint=tpoint-tg;
    ctx.moveTo(tpoint,ypoint_y);
    tpoint=tpoint+tg;
    ypoint_y=(height/2)+(yy*arthick);
    ctx.lineTo(tpoint,ypoint_y);
    ctx.stroke();

    ctx.beginPath();
    ctx.strokeStyle=z_color;
    tpoint=tpoint-tg;
    ctx.moveTo(tpoint,ypoint_z);
    tpoint=tpoint+tg;
    ypoint_z=(height/2)+(zz*arthick);
    ctx.lineTo(tpoint,ypoint_z);
    ctx.stroke();    
}
function drawNum()
{
    coords();
    cls();
    if(xx!=null)
    {
        dd=height/12;
        ctx.font=dd+"px numberfont";
        // ctx.textBaseline="bottom";
        ctx.fillStyle=x_color;
        ctx.fillText("x:" + (xx>0?'+':'') + xx, (width/6),(height/2)-((dd*2)+10));
        ctx.fillStyle=y_color;
        ctx.fillText("y:" + (yy>0?'+':'') + yy, (width/6),(height/2)-(dd+10)); 
        ctx.fillStyle=z_color;
        ctx.fillText("z:" + (zz>0?'+':'') + zz, (width/6),(height/2)-10);
        ctx.fillStyle=text_color;
        ctx.fillText("t:" + t, (width/6),(height/2)+(dd*2));
    }
}
function drawDisp()
{
    coords();
    cls();
    // if(Math.abs(xx)>Math.abs(yy))
    // {
    //     y_color="#005389";
    //     x_color ="#A4062C";
    // }else{
    //     y_color="#A4062C";
    //     x_color = "#005389";
    // }
    ctx.fillStyle=x_color;
    ctx.fillRect((width/2),(height/2)-(arthick/2),(xx*arlength),arthick);
    ctx.strokeStyle="#666666";
    ctx.strokeRect((width/2),(height/2)-(arthick/2),(xx*arlength),arthick);
    ctx.fillStyle=y_color;
    ctx.fillRect((width/2)-arthick/2,(height/2), arthick,(yy*arlength)); 
    ctx.strokeRect((width/2)-arthick/2,(height/2), arthick,(yy*arlength));
    if(zz<=0)
    {
        zz=0;
    }
    ctx.beginPath();
    ctx.arc((width/2),(height/2),(zz*arlength),0,2*Math.PI);
    ctx.lineWidth = 3;
    ctx.strokeStyle=z_color;
    ctx.stroke();    
}
function fillCircle()
{
    coords();
    ctx.fillStyle="#000000";
    ctx.fillRect(0,0,width,height);

    ctx.beginPath();
    ctx.moveTo((width/2),(height/2));
    // ctx.arc((width/2),(height/2),width/2.1,0,0.5*Math.PI);
    ctx.arc((width/2),(height/2),width/2.1,0,2*Math.PI);
    ctx.fillStyle="yellow";
    ctx.fill();
    ctx.closePath();

    // ctx.beginPath();
    // ctx.moveTo((width/2),(height/2));
    // ctx.arc((width/2),(height/2),width/2.1,0.5*Math.PI,1*Math.PI);
    // ctx.fillStyle="maroon";
    // ctx.fill();
    // ctx.closePath();

    // ctx.beginPath();
    // ctx.moveTo((width/2),(height/2));
    // ctx.arc((width/2),(height/2),width/2.1,1*Math.PI,1.5*Math.PI);
    // ctx.fillStyle="yellow";
    // ctx.fill();
    // ctx.closePath


    // ctx.beginPath();
    // ctx.moveTo((width/2),(height/2));
    // ctx.arc((width/2),(height/2),width/2.1,1.5*Math.PI,2*Math.PI);
    // ctx.fillStyle="maroon";
    // ctx.fill();
    // ctx.closePath();

    current_func=fillCircle;
}

var Base64 = {
 
    // private property
    _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
 
    // public method for encoding
    encode : function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;
 
        input = Base64._utf8_encode(input);
 
        while (i < input.length) {
 
            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);
 
            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;
 
            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }
 
            output = output +
            this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
            this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
 
        }
 
        return output;
    },
 
    // public method for decoding
    decode : function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;
 
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
 
        while (i < input.length) {
 
            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));
 
            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;
 
            output = output + String.fromCharCode(chr1);
 
            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }
 
        }
 
        output = Base64._utf8_decode(output);
 
        return output;
 
    },
 
    // private method for UTF-8 encoding
    _utf8_encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
 
        for (var n = 0; n < string.length; n++) {
 
            var c = string.charCodeAt(n);
 
            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }
 
        }
 
        return utftext;
    },
 
    // private method for UTF-8 decoding
    _utf8_decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;
 
        while ( i < utftext.length ) {
 
            c = utftext.charCodeAt(i);
 
            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }
 
        }
 
        return string;
    }
 
}