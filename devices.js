
function setDevice() {
	 if(ww == 320 && hh == 548){
      device =  "ipodtouch 7.1.2";
      view = "Safari";
      pixres = 3;
      }else if(ww == 768 && hh == 1004){
	  device =  "Ipad2 ";
	  view = "Safari";
      pixres = 1.4
      }else if(ww == 768 && hh == 1004){
	  device =  "Iphone ";
	  view = "Safari";
      pixres = 2;
     }else if(ww == 720 && hh == 1280){
	  device =  "Sumsung S3" ;
	  view = "native";
      pixres = 1.5;
     }else if(ww == 2400 && hh == 3840){
      device =  "Acer A700 ";
      view = "native";
     }else if(ww == 1200 && hh == 1920){
	  device =  "Acer Iconia A700";
	  view = "native";
      pixres = 0.8;
     }else if(ww == 768 && hh == 1024){
	  device =  "Acer Iconia A1-830";
	  view = "native";
      pixres = 1.3;
     }else if(ww == 768 && hh == 976){
	  device =  "Acer Iconia A1-810";
	  view = "native";
      pixres = 1.3;
     }else {
      device =  "PC?";
      view = "native";
      pixres = 1;
     }
}