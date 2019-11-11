import os
import time 
import platform
import json
import re
import sys
import shutil
import argparse

def creation_date(file):
    
    return {"modified":time.ctime(os.path.getmtime(file)),
    "created":time.ctime(os.path.getctime(file))}




path = "C:\\xampp\\htdocs\\Gotyou"
print(path)
curfiles = []

# r=root, d=directories, f = files
pattern = re.compile(".git")
for r, d, f in os.walk(path):
    for file in f:
        curfile=os.path.join(r, file)
        if(pattern.search(curfile)==None):
            curfiles.append({"time":creation_date(curfile),"file":curfile,"last_uploaded":""})
print(sys)
if len(sys.argv)>2 and sys.argv[2]:
    print("Writing modified json")
    fp=open("filelist.json","w")
    fp.write(json.dumps(curfiles));
    fp.close()


fp=open("filelist.json","r");
Str="";
for x in fp:
    Str=Str+x;
fp.close()

BeforeFiles=json.loads(Str);
for i in range(0,len(curfiles)):
    for j in range(0,len(BeforeFiles)):
        #print(curfiles[i]['file'])
        #print(BeforeFiles[j]['file'])
        if curfiles[i]['file']==BeforeFiles[j]['file']:
           if curfiles[i]['time']['modified']!=BeforeFiles[j]['time']['modified']:
                    print("Change in :"+curfiles[i]['file'])
                    print("Copying...")
                    shutil.copy(curfiles[i]['file'],sys.argv[1])
                    print("=========================================================================")
                    break;
fp=open("filelist.json","w")

print("Finished checking")
