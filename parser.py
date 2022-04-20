import sys
import xml.dom.minidom as minidom 
import mysql.connector
from datetime import datetime

LIGHT_GREEN='\033[1;32m'
YELLOW='\033[1;33m'
LIGHT_RED='\033[1;31m'
NC='\033[0m'

def delete(data,cursor):
    query = "DELETE FROM weather_data WHERE city=%s"
    cursor.execute(query, (data['city'],))

def addToSQL(data,cursor):
    t = data['last_update'].split()
    last_forecast_update = datetime.strptime(f"{t[3]} {t[4]} {t[5]} {t[0]}{t[1]}", "%b %d, %Y %I:%M%p")
    query = "INSERT INTO weather_data (day_id, city, state, day, day_or_night, temperature_text, temperature, short_description, long_description, last_forecast_update) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    cursor.execute(query, (data['day_id'], data['city'], data['state'], data['day'], data['day_or_night'], data['temperature_text'], data['temperature'], data['short_description'], data['long_description'], last_forecast_update))


def getCityAndDate(document):
    city = ""
    last_update = ""
    state= ""
    count = 0
    for div in document.getElementsByTagName("div"):
        if (div.getAttribute("class") == "fullRow" and count < 2):
            for div2 in div.getElementsByTagName('div'):
                if (div2.getAttribute("class") == "right"):
                    if(count == 0):
                        temp = div2.childNodes[0].nodeValue.rsplit(" ", 1)
                        city = temp[0]
                        state = temp[1]
                    elif (count == 1):
                        last_update = div2.childNodes[0].nodeValue
            count += 1
    return (city,state,last_update)

def parseFile(document):
    tempList = []
    day_id = 1
    for ul in document.getElementsByTagName("ul"):
        if(ul.hasAttribute("id")):
            for li in ul.getElementsByTagName("li"):
                for div in li.getElementsByTagName("div"):
                    tempD = {"day":"", "day_or_night":0, "long_description":"", "short_description":"", "temperature":0, "temperature_text":""}
                    for paragraph in div.getElementsByTagName("p"):
                        for node in paragraph.childNodes:
                            if(node.nodeType == node.TEXT_NODE):
                                if(paragraph.getAttribute("class") == "period-name"):
                                    tempD["day"] += node.nodeValue + " "
                                    if('night' in tempD['day'].lower()):
                                        tempD['day_or_night'] = 1
                                elif (paragraph.getAttribute("class") == "short-desc"):
                                    tempD["short_description"] += node.nodeValue + " " 
                                elif (paragraph.getAttribute("class") in ["temp temp-high", "temp temp-low"]):
                                    tempD["temperature_text"] = node.nodeValue
                                    tempD["temperature"] = int(node.nodeValue.split()[1])   
                            elif(node.nodeType == node.ELEMENT_NODE):
                                if(node.tagName == "img"):
                                    tempD["long_description"] = node.getAttribute("alt")
                            else:
                                print("Unknown node type")
                    tempD['day'] = tempD['day'].strip()
                    tempD['short_description'] = tempD['short_description'].strip()
                    tempD['city'], tempD['state'], tempD['last_update'] = getCityAndDate(document)
                    tempD['day_id'] = day_id
                    tempList.append(tempD)
                    day_id += 1
    return tempList

def main():
    pData = parseFile(minidom.parse(sys.argv[1]))
    print(f"READ DATA FOR FILE:{YELLOW}",sys.argv[1],f"{NC}")
    print("STORING DATA IN DATABASE")
    try:
        cnx = mysql.connector.connect(host="localhost", user='root', password='testing', database='weather')
        cursor = cnx.cursor()
        delete(pData[0],cursor)
        for data in pData:
            addToSQL(data, cursor)
        cnx.commit()
        cursor.close()
        print(f"{LIGHT_GREEN}DATA STORED SUCCESSFULLY{NC}\n")
    except mysql.connector.Error as err:
        print(f"{LIGHT_RED}",err,f"{NC}\n",sep="")
        cnx.rollback()
    finally:
        try:
            cnx
        except NameError:
            pass
        else:
            cnx.close()


if __name__ == "__main__":
    main()