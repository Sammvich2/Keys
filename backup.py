from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.common.exceptions import NoSuchElementException
import time
import sqlite3

driver = webdriver.Firefox(executable_path='D:/Programs/gecko/geckodriver.exe')
driver.get("https://www.dakeys.net/db/keys.db")