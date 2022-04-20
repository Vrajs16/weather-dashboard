import sys
import xml.dom.minidom as minidom 
import mysql.connector as mysql

def addToSQL(data):
    # print(data,'\n\n')
    pass



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
                    tempList.append(tempD)
    
    return tempList

def main():
    pData = parseFile(minidom.parse(sys.argv[1]))
    print("READ DATA FOR FILE:",sys.argv[1])
    print("STORING DATA IN DATABASE")
    for data in pData:
        addToSQL(data)

if __name__ == "__main__":
    main()