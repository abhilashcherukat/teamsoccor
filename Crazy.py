import pyautogui 
import random
import ctypes
user32 = ctypes.windll.user32
screensize =[user32.GetSystemMetrics(0), user32.GetSystemMetrics(1)]
print(screensize)
k=0
l=0
pyautogui.FAILSAFE=False
posx=[]
posy=[]
for i in range(10,screensize[0],10):
	posx.append(i)
	posx.append(i*-1)
print (posx)

for j in range(10,screensize[1],10):
	posy.append(j)
	posy.append(j*-1)
print (posy)

while k<200:
	
	x=int((random.random()*1000)%(len(posx)-2))
	y=int((random.random()*1000)%(len(posy)-2))
	print(posx[x],posy[y])
	pyautogui.drag(posx[x],posy[y],duration=1)
	
	k=k+1


