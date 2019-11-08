import os
import time 
import platform
import json

def creation_date(file):
    
    return {"modified":time.ctime(os.path.getmtime(file)),
    "created":time.ctime(os.path.getctime(file))}

path = "C:\\xampp\\htdocs\\Gotyou"

curfiles = []

# r=root, d=directories, f = files
for r, d, f in os.walk(path):
    for file in f:
        curfile=os.path.join(r, file)
        curfiles.append({"time":creation_date(curfile),"file":curfile})

print(json.dumps(curfiles))
fp=open("filelist.json","r");
Str="";
for x in fp:
    Str=Str+x;

BeforeFiles=json.loads(Str);
print(BeforeFiles[0]['time']);
for i in range(0,len(curfiles)):
    for j in range(0,len(BeforeFiles)):
        if curfiles[i]['file']==BeforeFiles[j]['file']:
            if curfiles[i]['time']['modified']!=BeforeFiles[j]['time']['modified']:
                    print("Change in :"+curfiles[i]['file'])
                    print(curfiles[i]['time']['modified']+" - "+BeforeFiles[j]['time']['modified'])
                    print("=========================================================================")
                    break;
print("Finished checking")

