import sys
import xml.dom.minidom as minidom

def parseFile(document):
    tempList = []
    for ul in document.getElementsByTagName("ul"):
        if(ul.hasAttribute("id")):
            for li in ul.getElementsByTagName("li"):
                for div in li.getElementsByTagName("div"):
                    tempD = {"date":"", "long_description":"", "short_description":"", "temperature":""}
                    for paragraph in div.getElementsByTagName("p"):
                        for node in paragraph.childNodes:
                            if(node.nodeType == node.TEXT_NODE):
                                if(paragraph.getAttribute("class") == "period-name"):
                                    tempD["date"] += node.nodeValue + " "
                                elif (paragraph.getAttribute("class") == "short-desc"):
                                    tempD["short_description"] += node.nodeValue + " " 
                                elif (paragraph.getAttribute("class") == "temp temp-high"):
                                    tempD["temperature"] = node.nodeValue       
                            elif(node.nodeType == node.ELEMENT_NODE):
                                if(node.tagName == "img"):
                                    tempD["long_description"] = node.getAttribute("alt")
                            else:
                                print("Unknown node type")
                    tempD['date'] = tempD['date'].strip()
                    tempD['short_description'] = tempD['short_description'].strip()
                    tempList.append(tempD)
    return tempList



def main():
    pData = parseFile(minidom.parse(sys.argv[1]))
    print("DATA FOR FILE: ",sys.argv[1])
    for data in pData:
        print(data['long_description'],"\n")


if __name__ == "__main__":
    main()