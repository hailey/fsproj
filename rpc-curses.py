#!/usr/bin/python

connectString = "http://freeswitch:fs@sarah.athnex.com:8080"

import curses
from xmlrpc.client import ServerProxy
import re
import time


mainscreen = curses.initscr()

pTotal = re.compile('\d+ total.')

server = ServerProxy(connectString)

x = 0
mainscreen.nodelay(1)
while True:
	
	ServerStatusLine 	= server.freeswitch.api("status","").split('\n')
	ShowRegistrations	= server.freeswitch.api("show","registrations").split("\n")
	ShowChannels		= server.freeswitch.api("show","channels").split("\n")
		
	mainscreen.clear()
	i = 0
	mainscreen.border(0)
	mainscreen.addstr(i + 1,2, ServerStatusLine[0])
	mainscreen.addstr(i + 2,2, ServerStatusLine[2])
	mainscreen.addstr(i + 3,2, ServerStatusLine[3])
	mainscreen.addstr(i + 4,2, ServerStatusLine[4])
	mainscreen.addstr(i + 5,2, ServerStatusLine[6])

	mainscreen.addstr(i+7,2, "Registrations ===")
	i += 8

	for regStr in ShowRegistrations:
		if regStr == '0 total.':
			mainscreen.addstr(i+2,2, "No Registered users.")
			break
		elif regStr == '' or regStr[0:8] == 'reg_user':
			continue
		elif pTotal.match(regStr):
			continue
		regLine = regStr.split(',')
		mainscreen.addstr(i,2, 
			"User: " + regLine[0] + "@" + regLine[1]  + " " + regLine[7] +
			" " + regLine[5] + ":" + regLine[6])
		i += 1
		
	mainscreen.addstr(i + 1,2, "Channel List ===")

	for chanStr in ShowChannels:
		
		if chanStr == '0 total.':
			mainscreen.addstr(i+2,2, "No Open Channels.")
			break
		elif chanStr == '' or chanStr[0:4] == 'uuid':
			continue
		elif pTotal.match(chanStr):
			continue
			
		chanLine = chanStr.split(',')
		mainscreen.addstr(i + 2,2,
			chanLine[2] + " UUID: " + chanLine[0] + " Direction: " +
			chanLine[1])
		mainscreen.addstr(i + 3,2,
			"	" + chanLine[6] + " ( " + chanLine[7] + " ) Src IP: " + 
			chanLine[8] + " >> Dest " + chanLine[9] + " [Codec " + 
			chanLine[17] + "]")
		mainscreen.addstr(i + 4,2,
			"	Application: " + chanLine[10] +
			" (" + chanLine[11] + ")")
		i += 4
	mainscreen.refresh()

	x = mainscreen.getch()
	if x == ord('q'):
		break
	else:
		time.sleep(1)


curses.endwin()
