from urllib.request import urlopen as ureq
from bs4 import BeautifulSoup as soup
import sys
import re
print ('Fetching IDs');
baseurl="https://xerve.in/leads"
uclient = ureq(baseurl)
tags=[]
page_html = uclient.read()
page_soup = soup(page_html, "html.parser")
try:
    #Finding all a tag which contain the enquiry ID
    tags = page_soup.find_all("a",{"class":"btexp"})
except:
    print("Oops!",sys.exc_info()[0],"occured.")


ids=[]
for tag in tags:
    #Extracting the enquiry ID from the tags and saving in array
    ids.append(re.search('<a class="btexp" href="/leads/(.+?)" target="_blank">View Details</a>', str(tag)).group(1))
    
print ('Fetched IDs');
with open('Id.txt', 'w') as f1:
    for item in ids:
        f1.write("%s\n" % item)
print ('Fetching Numbers');

numbertags=[]
nametags=[]
for dt in ids: 
    #Generating each lead URL
    try:
        my_url = 'https://xerve.in/leads/'+dt
        
        print(my_url)
        uclient = ureq(my_url)
        page_html = uclient.read()
        page_soup = soup(page_html, "html.parser")
        
        #Finding the input item which have the id view_buyer_contact
        pn = page_soup.find("input",{"id":"view_buyer_contact"})

        nm = page_soup.find("input",{"id":"buyername"})
           
        if pn:
            #Saving
            with open('values.txt', 'a+') as f2:
                 f2.write(nm['value']+" : "+pn['value']+"\n")   
            
    except:
        print("Oops 2!",sys.exc_info()[0],"occured.")



print("Done Scrapping");