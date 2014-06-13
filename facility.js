function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
  alert ("Browser does not support HTTP Request");
  return null;
}



function showUser(str)
{
    var xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null){return;}
    var url="faccontact.php";
    url=url+"?q="+encodeURIComponent(str);
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4)
    {

    var contact = new String();
    contact = xmlhttp.responseText.split('~');
    
    if(contact[0] == undefined) contact[0] ='';
    if(contact[1] == undefined) contact[1] ='';
    
    document.getElementById("faccontact").value=contact[0]; 
    document.getElementById("faccontactfax").value=contact[1];
    }};

    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}





function showDr(str)
{
    var xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null){return;}
    var url="orddrcontact.php";
    url=url+"?q="+encodeURIComponent(str);
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4)
    {
    var contact = new String();
    contact = xmlhttp.responseText.split('~');
    
    if(contact[0] == undefined) contact[0] ='';
    if(contact[1] == undefined) contact[1] ='';

    document.getElementById("ordering_dr_phone").value=contact[0];
    document.getElementById("ordering_dr_fax").value=contact[1];
    }};
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}



function showAddress(str)
{
    var xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null){return;}
    var url="locationfacilityaddress.php";
    url=url+"?q="+encodeURIComponent(str);
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4)
    {
        var contact = new String();
        contact = xmlhttp.responseText.split('~');
        
        if(contact[0] == undefined) contact[0] ='';
        if(contact[1] == undefined) contact[1] ='';
        if(contact[2] == undefined) contact[2] ='';
        if(contact[3] == undefined) contact[3] ='';
        if(contact[4] == undefined) contact[4] ='';

        document.getElementById("privatestreetaddress1").value=contact[0];
        document.getElementById("privatestreetaddress2").value=contact[1];
        document.getElementById("privatecity").value=contact[2];

        var state = document.getElementById('privatestate');
        for(var i = 0; i < state.options.length; i++){
            if(state.options[i].value === contact[3]){
                state.selectedIndex = i;
                break;
            }
        }

        document.getElementById("privatezipcode").value=contact[4];
    }};
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}



function showStations(str)
{
    var xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null){return;}
    var url="locationfacilitystations.php";
    url=url+"?q="+encodeURIComponent(str);
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4)
    {
        var stationlist = new String();
        stationlist = xmlhttp.responseText.split('~');
        var station = document.getElementById('station');
        station.options.length = 0;
        var opt = document.createElement("option");
        station.options.add(opt);
        opt.text = 'Select';
        opt.value = '';
        for(var i = 0; i<stationlist.length;i++){

            // Create an Option object        
            var opt = document.createElement("option");

            // Add an Option object to Drop Down/List Box
            station.options.add(opt);

            // Assign text and value to Option object
            opt.text = stationlist[i];
            opt.value = stationlist[i];            
        }

    }};
    
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}




function showProcedure(str)
{
    var xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null){return;}
    var url="listprocedurefordd.php";
    url=url+"?q="+encodeURIComponent(str);
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4)
    {
        var proclist = new String();
        proclist = xmlhttp.responseText.split('~');

        for(j = 1; j< 11; j++){

            var dd = document.getElementById('procedure'+j);
            dd.options.length=0;
            var opt = document.createElement("option");
            dd.options.add(opt);
            opt.text = 'Select';
            opt.value = '';

            for(var i = 0; i<proclist.length;i++){

                // Create an Option object        
                var opt = document.createElement("option");

                // Add an Option object to Drop Down/List Box
                dd.options.add(opt);

                // Assign text and value to Option object
                opt.text = proclist[i];
                opt.value = proclist[i];            
            }

        }
        

    }};
    
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}

function showStationData(str)
{
    var xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null){return;}
    
    var facility = document.getElementById('facility');
    if (! facility ){
        facility = document.getElementById('locfacility');
    }
    var facname = facility.value;
    
    if (str == '' ){
       showUser(facname); 
       return;
    }
    var url="liststationdata.php";
    url=url+"?q="+encodeURIComponent(str)+"&facname="+encodeURIComponent(facname);
    url=url+"&sid="+Math.random();
    
    
    xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4)
    {
        var contact = new String();
        contact = xmlhttp.responseText.split('~');

        if(contact[0] == undefined) contact[0] ='';
        if(contact[1] == undefined) contact[1] ='';

        if(contact[0]) document.getElementById("faccontact").value=contact[0]; 
        if(contact[1]) document.getElementById("faccontactfax").value=contact[1];

    }};
    
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}
