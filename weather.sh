#!/bin/bash
# Trap to remove all files if the user quites the program with CTRL+C
trap 'echo "REMOVING FILES IF ANY"; rm parsippany.* newark.* atlantic_city.* princeton.* salem.* >/dev/null 2>&1; exit' SIGINT

# while loop to run indefinitely
echo "BEGINNNING WHILE LOOP"
while :
do
    # Download the html files from the webstie
    echo "DOWNLOADING HTML FILES"
    wget -qO parsippany.html "https://forecast.weather.gov/MapClick.php?CityName=Parsippany&state=NJ"
    wget -qO newark.html "https://forecast.weather.gov/MapClick.php?CityName=Newark&state=NJ"
    wget -qO atlantic_city.html "https://forecast.weather.gov/MapClick.php?CityName=Atlantic+City&state=NJ"
    wget -qO princeton.html "https://forecast.weather.gov/MapClick.php?CityName=Princeton&state=NJ"
    wget -qO salem.html "https://forecast.weather.gov/MapClick.php?CityName=Salem&state=NJ"

    #Convert the html files to xml using tagsoup
    echo "CHECKING FOR TAGSOUP.jar"
    FILENAME="tagsoup-1.2.1.jar"
    if [ ! -f "$FILENAME" ]; then
        wget -qO tagsoup-1.2.1.jar "https://repo1.maven.org/maven2/org/ccil/cowan/tagsoup/tagsoup/1.2.1/tagsoup-1.2.1.jar"
    fi

    echo "CONVERTING HTML TO XML"
    java -jar tagsoup-1.2.1.jar --files parsippany.html newark.html atlantic_city.html princeton.html salem.html 
    
    #Use XML minidom with python script to parse data
    echo "PARSING XML FILES AND STORING TO MYSQL"
    #Change to python or leave as python3?
    python parser.py parsippany.xml
    python parser.py newark.xml
    python parser.py atlantic_city.xml
    python parser.py princeton.xml
    python parser.py salem.xml

    #Remove the files
    echo "REMOVING FILES"
    rm parsippany.* newark.* atlantic_city.* princeton.* salem.* >/dev/null 2>&1
    
    #Sleep for 6 hours to run again
    echo -e "SLEEPING FOR 6 HOURS\n"
    sleep 10s
done