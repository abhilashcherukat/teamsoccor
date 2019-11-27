from bs4 import BeautifulSoup
import requests

url = 'https://www.xerve.in/solr_q_log/create_prices_sitemap_air_conditioner.php'
ext = 'txt'

def listFD(url, ext=''):
	print "printing page:"+url
	page = requests.get(url).text
	print page
	print "-=============-"
	soup = BeautifulSoup(page, 'html.parser')
	return [url + '/' + node.get('href') for node in soup.find_all('a') if node.get('href').endswith(ext)]

for file in listFD(url, ext):
    print file