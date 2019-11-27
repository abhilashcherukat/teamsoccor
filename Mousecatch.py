import pyautogui 
import random
import ctypes

import base64


Fun=base64.b64decode('PT09PSBYRVJWRSBJUyBQQVRIRVRJQyA9PT09').decode("utf-8") ;
user32 = ctypes.windll.user32
screensize =[user32.GetSystemMetrics(0), user32.GetSystemMetrics(1)]
print(screensize)
k=0
l=0
pyautogui.FAILSAFE=False


while k<2000:
	
	x=random.randint(-200,200)
	y=random.randint(-200,200)
	print(x,y)
	pyautogui.dragRel(x,y,duration=0.5)
	pyautogui.typewrite(Fun)
	k=k+1


