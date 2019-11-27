import pyautogui
import time
pyautogui.hotkey('win','r')
time.sleep(2)
pyautogui.typewrite('cmd')
pyautogui.press('enter')
time.sleep(2)
pyautogui.typewrite('shutdown -s')
pyautogui.press('enter')

