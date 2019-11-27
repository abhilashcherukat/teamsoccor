from urllib.request import urlopen as ureq
from bs4 import BeautifulSoup as soup
import sys
import re
print ('Fetching IDs');
try:
	baseurl="https://www.myntra.com/web/offers/1917349"
	uclient = ureq(baseurl)
	tags=[]
	page_html = uclient.read()
	page_soup = soup(page_html, "html.parser")
	#Finding all a tag which contain the enquiry ID
	print(page_soup)
	tags = page_soup.find_all("span",{"class":"actual-price"})
	ids=[]
	for tag in tags:
		#Extracting the enquiry ID from the tags and saving in array
		ids.append(re.search('<span itemprop="price" content="2099" class="actual-price">(.+?)</span>', str(tag)).group(1))
	print (tags)
except:
	print("Oops!",sys.exc_info()[0],"occured.")