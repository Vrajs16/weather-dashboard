#!/bin/bash
# Trap to remove all files if the user quites the program with CTRL+C
trap 'echo -e "${LIGHT_RED}\nYOU PRESSED CTRL+C${NC}\n${LIGHT_CYAN}REMOVING ALL .html or .xhtml FILES FROM DIR${NC}"; rm parsippany.* newark.* atlantic_city.* princeton.* salem.* >/dev/null 2>&1; exit' SIGINT
GREEN='\033[0;32m'
LIGHT_CYAN='\033[1;36m'
YELLOW='\033[1;33m'
LIGHT_RED='\033[1;31m'
LIGHT_PURPLE='\033[1;35m'
NC='\033[0m'
# while loop to run indefinitely
while :
do
    # Download the html files from the webstie
    echo -e "${GREEN}DOWNLOADING HTML FILES${NC}"
    wget -qO parsippany.html "https://forecast.weather.gov/MapClick.php?CityName=Parsippany&state=NJ"
    wget -qO newark.html "https://forecast.weather.gov/MapClick.php?CityName=Newark&state=NJ"
    wget -qO atlantic_city.html "https://forecast.weather.gov/MapClick.php?CityName=Atlantic+City&state=NJ"
    wget -qO princeton.html "https://forecast.weather.gov/MapClick.php?CityName=Princeton&state=NJ"
    wget -qO salem.html "https://forecast.weather.gov/MapClick.php?CityName=Salem&state=NJ"

    #Convert the html files to xhtml using tagsoup
    echo -e "${GREEN}CHECKING FOR TAGSOUP.jar${NC}"
    FILENAME="tagsoup-1.2.1.jar"
    if [ ! -f "$FILENAME" ]; then
        echo -e "${LIGHT_RED}YOU DON'T HAVE TAG SOUP - DOWNLOADING IT!${NC}"    
        wget -qO tagsoup-1.2.1.jar "https://repo1.maven.org/maven2/org/ccil/cowan/tagsoup/tagsoup/1.2.1/tagsoup-1.2.1.jar"
    fi

    echo -e "${GREEN}CONVERTING HTML TO XHTML${NC}"
    java -jar tagsoup-1.2.1.jar --files parsippany.html newark.html atlantic_city.html princeton.html salem.html 
    
    #Use xhtml minidom with python script to parse data
    echo -e "${YELLOW}PARSING XML FILES AND STORING TO MYSQL${NC}"
    #Change to python or leave as python3?
    python3 parser.py parsippany.xhtml
    python3 parser.py newark.xhtml
    python3 parser.py atlantic_city.xhtml
    python3 parser.py princeton.xhtml
    python3 parser.py salem.xhtml

    #Remove the files
    echo -e "${LIGHT_RED}REMOVING FILES${NC}"
    rm parsippany.* newark.* atlantic_city.* princeton.* salem.* >/dev/null 2>&1
    
    #Sleep for 6 hours to run again
    echo -e "${LIGHT_PURPLE}SLEEPING FOR 6 HOURS\n${NC}"
    sleep 6hours
done