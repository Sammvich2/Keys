from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.common.exceptions import NoSuchElementException
import time
import sqlite3

#Startup, scan the QR code and then press any button
driver = webdriver.Firefox(executable_path='D:/Programs/gecko/geckodriver.exe')
driver.get("https://web.whatsapp.com/")
input("Press anything after QR scan")
time.sleep(5)


def reply(MessageContent):
    textBox = driver.find_element_by_xpath("/html/body/div/div[1]/div[1]/div[4]/div[1]/footer/div[1]/div[2]/div/div[2]")
    textBox.clear()
    textBox.send_keys(MessageContent)
    textBox.send_keys(Keys.RETURN)
    clearChat()

def clearChat():
    settingsButton = driver.find_element_by_xpath("/html/body/div/div[1]/div[1]/div[4]/div[1]/header/div[3]/div/div[2]/div/div/span")
    settingsButton.click()
    clearChatButton = driver.find_element_by_xpath("/html/body/div/div[1]/span[4]/div/ul/div/div/li[4]/div[1]")
    clearChatButton.click()
    confirmButton = driver.find_element_by_xpath("/html/body/div/div[1]/span[2]/div[1]/div/div/div/div/div/div[2]/div[2]/div/div")
    confirmButton.click()
    time.sleep(30)


# messages
helloMsg = "Hello"

looper = True
while looper:
    try:
        newMessageCheck = driver.find_element_by_xpath("/html/body/div/div[1]/div[1]/div[3]/div/div[2]/div[1]/div/div/div/div/div/div/div[2]/div[1]/div[1]")
        newMessageCheck.click()
        msg_got = driver.find_elements_by_xpath("/html/body/div/div[1]/div[1]/div[4]/div[1]/div[3]/div/div/div[2]/div[4]/div/div/div/div[1]/div/span[1]/span")
        msg = [message.text for message in msg_got]
        try:
            print(msg[0])
            conn = sqlite3.connect('keys.db')
            c = conn.cursor()
            c.execute("SELECT * FROM keys WHERE id_number = " + msg[0])
            searchResult = c.fetchone()
            print(searchResult)
            conn.commit()
            conn.close()
            if searchResult == False:
                reply("SearchFailed")
            else:
                replyMessage = str("Key ID: " + searchResult[0] + "   Address: " + searchResult[1] + "   Location: " + searchResult[2] + "   Sign Out Date: " + searchResult[3])
                reply(replyMessage)

        except IndexError:
            print("No Message Found or")
            time.sleep(30)
            continue

    except NoSuchElementException:
        time.sleep(30)
        continue







'''
    if msg[-1] == "Help":
        reply = driver.find_element_by_xpath("/html/body/div/div[1]/div[1]/div[4]/div[1]/footer/div[1]/div[2]/div/div[2]")
        reply.clear()
        reply.send_keys("Here is list of commands")
        reply.send_keys(Keys.RETURN)
    '''
