import sqlite3
conn = sqlite3.connect('keys.db')

msg = "1001"

conn = sqlite3.connect('keys.db')
c = conn.cursor()
c.execute("SELECT * FROM keys WHERE id_number = " + msg)
searchResult = c.fetchall()



final_result = [list(i) for i in searchResult]
conn.commit()
conn.close()

print(type(searchResult))
print(searchResult[0])
print(searchResult[1])
