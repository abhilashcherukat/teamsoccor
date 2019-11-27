import os
import re
import random

path = "./"
mp3files = []
orig=[]
pattern = re.compile(".py")
for r, d, f in os.walk(path):
    for file in f:
        curfile=os.path.join(r, file)
        if(pattern.search(curfile)==None):
        	mp3files.append(curfile)
for f in mp3files:
	orig.append(f)

random.shuffle(mp3files)

for i in range(0,len(orig)):
	print orig[i],mp3files[i]
	os.rename(orig[i],mp3files[i].replace(".mp3","T.mp3"))

for i in range(0,len(orig)):
	os.rename(orig[i].replace(".mp3","T.mp3"),orig[i].replace("T.mp3",".mp3"))