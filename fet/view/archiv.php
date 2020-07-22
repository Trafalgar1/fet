<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<div id="home">
    <div class="home_item">
        <img class="tut_links" id="tut1" src="./Picture/pin.PNG" alt="tut1">
        <div class="home_beschreibung">
            <div class="home_beschreibung_title">Give us a date and time </div>
            <p>We will search all flights between the two times there might be some restrictions</p>
            <label>
                <p>Starttime</p>
                <input type="datetime-local" name="startTime" id="startTime">
            </label>
            <label>
                <p>Endtime</p>
                <input type="datetime-local" name="endTime" id="endTime">
            </label>
            <button onclick="setTime()">berechnen</button>
        </div>
    </div>

    <div class="home_item">
        <div class="home_beschreibung">
            <div class="home_beschreibung_title">Your searched Flights</div>
            Von: <span id="timeStart">2020-06-10T10:39</span> Bis:
            <span id="timeEnd">2020-06-10T11:39</span><br>In dieser Zeit flogen:<br>
            <div id="anzFlug"></div><br>
            In der Tabelle rechts befinden sich alle Flugzeuge die zu dieser Zeit in der Luft waren und bei denen wir genügend Werte sammeln konnten um den CO2 Ausstoss zu berechnen.




        </div>
        <div id='archivTable' >
            <table id="aTable">
                <thead>
                <tr>
                    <th>icao24</th>
                    <th>Plane Manufacturer</th>
                    <th>Plane Model</th>
                    <th>Flight Distance</th>
                    <th>CO2 in KG p.p.</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>
</div>
<script>
    //nimmt die eingegebene Zeit und übergibt dies an die Api ruft mit der Response als Argument addToTable auf
    async function setTime(){
        var a=document.getElementById("startTime").value;
        var b=document.getElementById("endTime").value;
        document.getElementById("timeStart").innerHTML=a;
        document.getElementById("timeEnd").innerHTML=b;
        b=new Date(b)/1000;
        a=new Date(a)/1000;
        if(a<b) {
            var targetUrl = "http://fet.local/APITime.php?timeStart=" + a + "&timeEnd=" + b;
            var response = await fetch(targetUrl)
                .then(response => response.text())

            response = JSON.parse(response);
            await addToTable(response);

            document.getElementById("anzFlug").innerHTML = response.length+" Flugzeuge ";
        }
        else{
            console.log("error starttime > endtime")
        }

    }
    //Nimmt die Response der API entgegen macht anfragen an die Datenbank mit den Werten der Response und fügt dann die bekommenen Werte in die Tabelle ein
    async function addToTable(oldResponse) {
        deleteFromTable();
        var table = document.getElementById("aTable").getElementsByTagName('tbody')[0];
        for (data in oldResponse) {
            if(oldResponse[data]["icao24"]!=null) {
                var icao=oldResponse[data]["icao24"];
                var targetUrl = "http://fet.local/toDatabaseICAO.php?icao="+icao;
                var horiArr=oldResponse[data]["estArrivalAirportHorizDistance"]
                var vertArr=oldResponse[data]["estArrivalAirportVertDistance"];
                var horiDep=oldResponse[data]["estDepartureAirportHorizDistance"];
                var vertDep=oldResponse[data]["estDepartureAirportVertDistance"];
                var response = await fetch(targetUrl)
                    .then(response => response.text())
                response=response.split(",")

                if(response[0]!=null && response[1]!=null && response[2]!=null && horiArr!=null && horiDep!=null && vertArr!=0 && vertDep!=0) {
                    var co2=response[2];
                    var distance=calculateDistance(horiArr,horiDep,vertArr,vertDep);
                    var row = table.insertRow(0);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);
                    cell1.innerHTML = icao;
                    cell2.innerHTML = response[0];
                    cell3.innerHTML = response[1];
                    cell4.innerHTML= Math.round(distance)+"m";
                    //Gerechnet mit 7.14 kg/100km https://jmion.github.io/aviation-co2-impact/
                    cell5.innerHTML= Math.round((distance*co2)/10000000*100)/100+"kg";
                }
            }
        }
    }
    //löscht die vorherigen Einträge wird beim erstellen von neuen Einträgen aufgerufen
    function deleteFromTable(){
        var table = document.getElementById("aTable").getElementsByTagName('tbody')[0];
        var new_tbody = document.createElement('tbody');
        table.parentNode.replaceChild(new_tbody,table);
    }
    //berechnet die Distanz vom Ankunfts und Start Flughafen und returned die Zusammengerechneten Werte(Leider nur mit Pythagoras und nicht mit Kugelgeometrie)
    function calculateDistance(horiArr,horiDep,vertArr,vertDep){
        var distArr = Math.sqrt(Math.pow(horiArr,2) + Math.pow(vertArr,2));
        var distDep =Math.sqrt(Math.pow(horiDep,2) + Math.pow(vertDep,2));
        var totalDist=distArr+distDep;
        return totalDist;
    }

</script>