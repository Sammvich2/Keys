# Dont use this lol


from tkinter import *
import sqlite3
from datetime import datetime
import tkinter.font as tkFont


# set up the GPIO
# the actual control is done at the function "door control"
# import RPi.GPIO as GPIO
# GPIO.setmode(GPIO.BCM)
# GPIO.setup(18, GPIO.OUT)
# GPIO.setup(23, GPIO.OUT)


# setup the tkinter window and fonts
root = Tk()
root.title("APlus Fire Key System")
# root.iconbitmap('icon.ico')
root.configure(bg="#1e2022")
customFont = tkFont.Font(family="Courier New CE", size=12, weight="bold")
titleFont = tkFont.Font(family="Courier New CE", size=18, weight="bold")

# when working on desktop set the geometry to "800x480" for scale, when deployed put in fullscreen
# root.attributes('-fullscreen', True)
root.geometry("800x480")


# this logs when the program starts and handles logs further on
def logger(input):

    writeLog = open("logbook.txt", "a")
    writeLog.write("\n" + input + " at " + datetime.now().strftime("%d:%m:%Y-%H:%M:%S"))
    writeLog.close()


logger("system running")



# Create database, this is how the data base was created (NOT ANYMORE)
'''
conn = sqlite3.connect('keys.db')
c = conn.cursor()

c.execute("""CREATE TABLE keys (
            id_number text,
            site_address text,
            key_holder text,
            date_of_issue text
            )""")

conn.commit()
conn.close()
'''

# these functions show the requested tkinter frame and hides the previous
def showUsersFrame():
    usersFrame.pack()
    passwordFrame.pack_forget()
    adminPassFrame.pack_forget()
    adminFrame.pack_forget()
    keysFrame.pack_forget()


def showPasswordFrame(user):
    passwordFrame.pack()
    usersFrame.pack_forget()
    passwordEntry.delete(0, END)
    #selectedUser is used to set the key_holder, for logging, and for the abysmal password system
    global selectedUser
    selectedUser = str(user)

    welcomeLabel = Label(passwordFrame, text="Welcome, " + user + ". Please enter your password:", fg="white",
                         bg="#1e2022", font=titleFont)

    welcomeLabel.grid(row=0, column=0, pady=45)


def showAdminPassFrame():
    adminPassFrame.pack()
    usersFrame.pack_forget()
    passwordEntry.delete(0, END)


def showKeysFrame():
    passwordFrame.pack_forget()
    keysInFrame.pack_forget()
    keysOutFrame.pack_forget()
    keysInConfirmedFrame.pack_forget()
    keysFrame.pack()


def showKeysInFrame():
    keysFrame.pack_forget()
    keysInConfirmedFrame.pack_forget()
    keysInFrame.pack()
    print("Opening Door")


def showKeysInConfirmedFrame():
    keysInFrame.pack_forget()
    keysInConfirmedFrame.pack()


def showKeysOutFrame():
    keysFrame.pack_forget()
    keysOutFrame.pack()
    keysOutBarcodeEntry.delete(0, END)

'''
def showGrabKeysFrame():
    keysFrame.pack_forget()
    grabKeysFrame.pack()
'''

def showAdminFrame():
    adminFrame.pack()
    adminPassFrame.pack_forget()
    adminPasswordEntry.delete(0, END)


# these functions handle the "password" "protection"
# its also a fucken mess and could be way simpler for how unsecure it is
def passwordInput(passVar):
    global passwordVar
    passwordVar = passVar


def loginClick():
    passField = passwordEntry.get()
    if passField == passwordVar:
        showKeysFrame()
        logger(selectedUser + " logged in")
    else:
        incorrectLabel.grid(row=3, column=0)


def adminPass(adminPassVar):
    global adminPassword
    adminPassword = adminPassVar


def adminLoginClick():
    adminPassField = adminPasswordEntry.get()
    if adminPassField == adminPassword:
        showAdminFrame()
        logger("admin logged in ")
    else:
        adminIncorrectLabel.grid(row=3, column=0)


# these functions handle the database

# this adds new keys to the database
def newKeyEntry():
    keyholder = str("New Key")

    conn = sqlite3.connect('keys.db')
    c = conn.cursor()

    c.execute("INSERT INTO keys VALUES (:newID, :newAdd, :keyholder, :time)",
              {
                  'newID': idEntry.get(),
                  'newAdd': addressEntry.get(),
                  'keyholder': keyholder,
                  'time': datetime.now().strftime("%d:%m:%Y-%H:%M:%S")
              })

    conn.commit()
    conn.close()


# this shows the entire database on the admin screen
def showData():
    conn = sqlite3.connect('keys.db')
    c = conn.cursor()

    c.execute("SELECT *, oid FROM keys")
    data = c.fetchall()
    printData = ""
    for records in data:
        printData += str(records) + "\n"

    dataLabel = Label(adminFrame, text=printData, bg="#1e2022", fg="white", font=customFont)
    dataLabel.grid(row=4, column=1, columnspan=2)

    conn.commit()
    conn.close()


# search function for keys inbound
def keyInSearch():
    conn = sqlite3.connect('keys.db')
    c = conn.cursor()
    format_data = ""
    global keyInSearchVar
    keyInSearchVar = keysBarcodeEntry.get()

    if not keyInSearchVar:
        searchFailedLabel.grid(row=4, column=1)
    else:
        c.execute("SELECT * FROM keys WHERE id_number = " + keysBarcodeEntry.get())
        keys_in_data = c.fetchone()
        # format_data = str(keys_in_data).replace("'", "")
        format_data = keys_in_data[0] + " - " + keys_in_data[1] + " - " + keys_in_data[2]
        global keyInDataLabel
        keyInDataLabel = Label(keysInFrame, text=format_data, bg="#1e2022", fg="white", font=customFont)
        keyInDataLabel.grid(row=4, column=1, columnspan=2)

        if keys_in_data:
            keys_found_label = Label(keysInFrame, text="Keys Found: ", bg="#1e2022", fg="white", font=customFont)
            keys_found_label.grid(row=4, column=0)
            searchFailedLabel.grid_forget()
            confirmKeyInButton.grid(row=5, column=1)
        else:
            searchFailedLabel.grid(row=4, column=1)

    conn.commit()
    conn.close()


# sets the keys as signed into the box after search is done
def signKeysIn():
    conn = sqlite3.connect('keys.db')
    c = conn.cursor()
    print(keyInSearchVar)
    c.execute("UPDATE keys SET date_of_issue =?, key_holder =? WHERE id_number =?", (datetime.now().strftime("%d:%m:%Y-%H:%M:%S"), "KeyBox", keyInSearchVar))
    logger(selectedUser + " Has signed IN keyset " + keyInSearchVar)
    conn.commit()
    conn.close()
    showKeysInConfirmedFrame()


# search function for keys outbound
def keysOutSearch():
    conn = sqlite3.connect('keys.db')
    c = conn.cursor()
    global keysOutSearchVar
    keysOutSearchVar = keysOutBarcodeEntry.get()

    if not keysOutSearchVar:
        searchOutFailedLabel.grid(row=4, column=1)
    else:
        c.execute("SELECT * FROM keys WHERE id_number = " + keysOutSearchVar)
        keys_out_data = c.fetchone()
        print(c.fetchall())
        format_data = keys_out_data[0] + " - " + keys_out_data[1] + " - " + keys_out_data[2]
        global keyOutDataLabel
        keyOutDataLabel = Label(keysOutFrame, text="Keys Found: " + format_data, bg="#1e2022", fg="white", font=customFont)


        if keys_out_data:
#           keys_found_label = Label(keysOutFrame, text="Keys Found: ", bg="#1e2022", fg="white", font=customFont)
#            keys_found_label.grid(row=4, column=0)
            searchOutFailedLabel.grid_forget()
            confirmKeyOutButton.grid(row=5, column=1)
            keyOutDataLabel.grid(row=4, column=1, columnspan=2)
        else:
            searchOutFailedLabel.grid(row=4, column=1)

    conn.commit()
    conn.close()


# sets the keys as signed out after search
def signKeysOut():
    conn = sqlite3.connect('keys.db')
    c = conn.cursor()

    print(keysOutSearchVar)
    print(selectedUser)
    c.execute("UPDATE keys SET date_of_issue =?, key_holder =? WHERE id_number =?", (datetime.now().strftime("%d:%m:%Y-%H:%M:%S"), selectedUser, keysOutSearchVar))
    logger(selectedUser + " Has signed OUT keyset " + keysOutSearchVar)

    conn.commit()
    conn.close()

'''
# this function controls the door, but was scrapped cause i decided it was not needed
def doorControl(action):
    if action == "open":
        print("opening door")
        logger("The door was opened")
        gpio("open")
    if action == "close":
        print("Closing door")
        logger("The door was closed")
        gpio("close")


def gpio(input):
    if input == "open":
        GPIO.output(18, GPIO.HIGH)
        time.sleep(5)
        GPIO.output(18, GPIO.LOW)
    if input == "close":
        GPIO.output(23, GPIO.HIGH)
        time.sleep(5)
        GPIO.output(23, GPIO.LOW)
    GPIO.cleanup()
'''


# User select frame
# The Passwords are set here, change the text between quotation marks in the variable "passwordInput"
# This is not secure at all, this is just to keep the honest people out, if you wanted to steal keys you would just use a hammer

usersFrame = LabelFrame(root, padx=0, pady=120, bg="#1e2022", relief="flat")
titleLabel = Label(usersFrame, text="A Plus Fire Key System", bg="#1e2022", fg="white", font=titleFont)
samLogin = Button(usersFrame, text="Sam", command=lambda: [passwordInput("SamPass"), showPasswordFrame("Sam")], bg="#eb1d22", fg="white", font=customFont)
rhysLogin = Button(usersFrame, text="Rhys", command=lambda: [passwordInput("RhysPass"), showPasswordFrame("Rhys")], bg="#eb1d22", fg="white", font=customFont)
michelLogin = Button(usersFrame, text="Michel", command=lambda: [passwordInput("MichelPass"), showPasswordFrame("Michel")], bg="#eb1d22", fg="white", font=customFont)
scottLogin = Button(usersFrame, text="Scott", command=lambda: [passwordInput("ScottPass"), showPasswordFrame("Scott")], bg="#eb1d22", fg="white", font=customFont)
ducLogin = Button(usersFrame, text="Duc", command=lambda: [passwordInput("DucPass"), showPasswordFrame("Duc")], bg="#eb1d22", fg="white", font=customFont)
nickLogin = Button(usersFrame, text="Nicholas", command=lambda: [passwordInput("NickPass"), showPasswordFrame("Nicholas")], bg="#eb1d22", fg="white", font=customFont)
theoLogin = Button(usersFrame, text="Theodore", command=lambda: [passwordInput("TheoPass"), showPasswordFrame("Theodore")], bg="#eb1d22", fg="white", font=customFont)
primeLogin = Button(usersFrame, text="MechMan", command=lambda: [passwordInput("Mech Man Pat"), showPasswordFrame("MechMan")], bg="#eb1d22", fg="white", font=customFont)
davidLogin = Button(usersFrame, text="David", command=lambda: [passwordInput("DavidPass"), showPasswordFrame("David")], bg="#eb1d22", fg="white", font=customFont)
adrianLogin = Button(usersFrame, text="Adrian", command=lambda: [passwordInput("AdrianPass"), showPasswordFrame("Adrian")], bg="#eb1d22", fg="white", font=customFont)
guestLogin = Button(usersFrame, text="Guest", command=lambda: [passwordInput("GuestPass"), showPasswordFrame("Guest")], bg="#eb1d22", fg="white", font=customFont)
adminLogin = Button(usersFrame, text="Admin", command=lambda: [showAdminPassFrame(), adminPass("AdminPass")], bg="#eb1d22", fg="white", font=customFont)

titleLabel.grid(row=0, column=0, columnspan=3, pady=20)

adrianLogin.grid(row=1, column=0, pady=2, ipadx=27, sticky="w")
davidLogin.grid(row=1, column=1, pady=2, padx=3, ipadx=27, sticky="w")
ducLogin.grid(row=1, column=2, pady=2, ipadx=34, sticky="w")

michelLogin.grid(row=2, column=0, pady=2, ipadx=27, sticky="w")
nickLogin.grid(row=2, column=1, pady=2, padx=2, ipadx=16, sticky="w")
samLogin.grid(row=2, column=2, pady=2, ipadx=32, sticky="w")

rhysLogin.grid(row=3, column=0, pady=2, ipadx=31, sticky="w")
scottLogin.grid(row=3, column=1, pady=2, padx=2, ipadx=29, sticky="w")
theoLogin.grid(row=3, column=2, pady=2, ipadx=12, sticky="w")

primeLogin.grid(row=4, column=0, pady=2, ipadx=15, sticky="w")
guestLogin.grid(row=4, column=1, pady=2, padx=2, ipadx=27, sticky="w")
adminLogin.grid(row=4, column=2, pady=2, ipadx=24, sticky="w")


# Password entry Frame

passwordFrame = LabelFrame(root, padx=0, pady=50, bg="#1e2022", relief="flat")
passwordEntry = Entry(passwordFrame, width=10, bg="white", fg="black", font=customFont)
loginButton = Button(passwordFrame, text="Login", command=loginClick, bg="#eb1d22", fg="white", font=customFont)
backButton = Button(passwordFrame, text="Back To Users", command=showUsersFrame, bg="#eb1d22", fg="white", font=customFont)
incorrectLabel = Label(passwordFrame, text="Incorrect Password", fg="white", bg="#1e2022", font=customFont)

passwordEntry.grid(row=1, column=0)
loginButton.grid(row=2, column=0, pady=5)
backButton.grid(row=4, column=0, pady=15)


# Admin login screen frame

adminPassFrame = LabelFrame(root, padx=0, pady=175, bg="#1e2022", relief="flat")
adminPasswordEntry = Entry(adminPassFrame, width=10, bg="white", fg="black", font=customFont)
adminLoginButton = Button(adminPassFrame, text="Login", command=adminLoginClick, bg="#eb1d22", fg="white", font=customFont)
adminBackButton = Button(adminPassFrame, text="Back To Users", command=showUsersFrame, bg="#eb1d22", fg="white", font=customFont)
adminIncorrectLabel = Label(adminPassFrame, text="Incorrect Password", fg="white", bg="#1e2022", font=customFont)

adminPasswordEntry.grid(row=1, column=0)
adminLoginButton.grid(row=2, column=0, pady=5)
adminBackButton.grid(row=4, column=0, pady=10)


# Admin Page
adminFrame = LabelFrame(root, padx=0, pady=150, bg="#1e2022", relief="flat")
idLabel = Label(adminFrame, text="ID Number of new keyset", bg="#1e2022", fg="white", font=customFont)
addressLabel = Label(adminFrame, text="Address for new keyset", bg="#1e2022", fg="white", font=customFont)
idEntry = Entry(adminFrame, width=50, font=customFont)
addressEntry = Entry(adminFrame, width=50, font=customFont)
newKeyButton = Button(adminFrame, text="Enter New Key Details To Database", command=newKeyEntry, bg="#eb1d22", fg="white", font=customFont)
showEntries = Button(adminFrame, text="Show DataBase", command=showData, bg="#eb1d22", fg="white", font=customFont)
adminExitButton = Button(adminFrame, text="Exit to login screen", bg="#eb1d22", fg="white", command=showUsersFrame, font=customFont)
adminPageHeading = Label(adminFrame, text="Enter new keys into system, and view database below", bg="#1e2022", fg="white", font=customFont)

idLabel.grid(row=1, column=0, sticky="w")
addressLabel.grid(row=2, column=0, sticky="w")
idEntry.grid(row=1, column=1)
addressEntry.grid(row=2, column=1)
newKeyButton.grid(row=3, column=1)
showEntries.grid(row=4, column=1)
adminExitButton.grid(row=0, column=0)
adminPageHeading.grid(row=0, column=1, columnspan=2)


# Keys in/out Frame

keysFrame = LabelFrame(root, padx=0, pady=175, bg="#1e2022", relief="flat")
keysLabel = Label(keysFrame, text="Sign Keys In or Out?", bg="#1e2022", fg="white", font=customFont)
keysIn = Button(keysFrame, text="Sign Keys In", bg="#eb1d22", fg="white", command=showKeysInFrame, font=customFont)
keysOut = Button(keysFrame, text="Sign Keys Out", bg="#eb1d22", fg="white", font=customFont, command=lambda: [showKeysOutFrame()])
keysLogOutButton = Button(keysFrame, text="LogOut", bg="#eb1d22", fg="white", font=customFont, command=lambda: [showUsersFrame(), logger(selectedUser + " has logged out")])

keysLabel.grid(row=0, column=0, columnspan=2)
keysIn.grid(row=1, column=0, pady=15)
keysOut.grid(row=1, column=1, pady=15)
keysLogOutButton.grid(row=2, column=0, columnspan=2, pady=15)


# keys in frame

keysInFrame = LabelFrame(root, padx=0, pady=150, bg="#1e2022", relief="flat")
keysInLabel = Label(keysInFrame, text='Scan the barcode or type the ID in, then press "search"', bg="#1e2022", fg="white", font=customFont)
keysInTitle = Label(keysInFrame, text="Sign Keys In", bg="#1e2022", fg="white", font=titleFont)
keysBarcodeEntry = Entry(keysInFrame, width=10, font=customFont)
keysSearchButton = Button(keysInFrame, text="Search", command=keyInSearch, font=customFont, bg="#eb1d22", fg="white")
searchFailedLabel = Label(keysInFrame, text="Search Failed, ya done goofed", bg="#1e2022", fg="white", font=customFont)
keysInBackButton = Button(keysInFrame, text="Back", fg="white", bg="#eb1d22", font=customFont, command=lambda: [showKeysFrame(), confirmKeyInButton.grid_forget()])
confirmKeyInButton = Button(keysInFrame, text="Confirm Keys Signed IN", bg="#eb1d22", fg="white", font=customFont, command=lambda: [keyInDataLabel.grid_forget(),
                                                                                                                                    signKeysIn(), confirmKeyInButton.grid_forget()])
clearSearchButton = Button(keysInFrame, text="Clear Search", bg="#eb1d22", fg="white", font=customFont, command=lambda: [keyInDataLabel.grid_forget(), confirmKeyInButton.grid_forget()])

keysInTitle.grid(row=0, column=0, columnspan=2, pady=15)
keysInLabel.grid(row=1, column=1, columnspan=1)
keysBarcodeEntry.grid(row=2, column=1)
keysSearchButton.grid(row=3, column=1, pady=15)
keysInBackButton.grid(row=1, column=0)
clearSearchButton.grid(row=3, column=0)


# Keys In Confirmed Frame
keysInConfirmedFrame = LabelFrame(root, padx=0, pady=150, bg="#1e2022", relief="flat")
keysInConfirmedLabel = Label(keysInConfirmedFrame, text="Keys successfully signed in!\nPlease place the keys on the appropriate hook inside.", bg="#1e2022", fg="white", font=customFont)
keysInConfirmedButton = Button(keysInConfirmedFrame, text="Done!", bg="#eb1d22", fg="white", font=customFont,
                               command=lambda: [showKeysFrame(),
                                    keysBarcodeEntry.delete(0, END)])

keysInConfirmedLabel.grid(row=0, column=0)
keysInConfirmedButton.grid(row=1, column=0)



# "grab" keys frame. Not used any more, no door control
'''
grabKeysFrame = LabelFrame(root, padx=0, pady=175, bg="#1e2022", relief="flat")
grabKeysLabel = Label(grabKeysFrame, text="The door is now open\nGrab all the keys you require", fg="white", bg="#1e2022", font=customFont)
grabKeysButton = Button(grabKeysFrame, text="Done!", bg="#eb1d22", fg="white", font=customFont, command=lambda: [showKeysOutFrame()])

grabKeysLabel.grid(row=0, column=0)
grabKeysButton.grid(row=1, column=0)
'''

# keys out frame

keysOutFrame = LabelFrame(root, padx=0, pady=100, bg="#1e2022", relief="flat")
keysOutTitle = Label(keysOutFrame, text="Sign Keys Out", bg="#1e2022", fg="white", font=titleFont)
keysOutLabel = Label(keysOutFrame, text='Scan the barcode or type the ID in, then press "search"', bg="#1e2022", fg="white", font=customFont)
keysOutBarcodeEntry = Entry(keysOutFrame, width=10, font=customFont)
keysOutSearchButton = Button(keysOutFrame, text="Search", fg="white", bg="#eb1d22", font=customFont, command=keysOutSearch)
searchOutFailedLabel = Label(keysOutFrame, text="Search Failed, ya done goofed", bg="#1e2022", fg="white", font=customFont)
keysOutBackButton = Button(keysOutFrame, text="Back", fg="white", bg="#eb1d22", font=customFont, command=lambda: [showKeysFrame(), confirmKeyOutButton.grid_forget()])
confirmKeyOutButton = Button(keysOutFrame, text="Confirm Keys Signed OUT",
                             bg="#eb1d22", fg="white", font=customFont, command=lambda: [signKeysOut(), keyOutDataLabel.grid_forget(),
                                                                                         confirmKeyOutButton.grid_forget(), showKeysFrame()])
clearSearchButton = Button(keysOutFrame, text="Clear Search", bg="#eb1d22", fg="white", font=customFont, command=lambda: [keyOutDataLabel.grid_forget(), confirmKeyOutButton.grid()])

keysOutLabel.grid(row=1, column=1, columnspan=1)
keysOutTitle.grid(row=0, column=0, columnspan=2, pady=15)
keysOutBarcodeEntry.grid(row=2, column=1)
keysOutSearchButton.grid(row=3, column=1, pady=10)
keysOutBackButton.grid(row=1, column=0)
clearSearchButton.grid(row=3, column=0)

showUsersFrame()
root.mainloop()
