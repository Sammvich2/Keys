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




<?php


$pdo = new PDO('sqlite:keys.db');
$statement = $pdo->query("SELECT * from keys");
$keys = $statement->fetchAll(PDO::FETCH_ASSOC);




foreach ($keys as $row => $key) {
    echo "<tr><h3>";
    echo "<td>" . $key['id_number'] . "</td>";
    echo "<td>" . $key['address'] . "</td>";
    echo "<td>" . $key['key_holder'] . "</td>";
    echo "<td>" . $key['date_of_issue'] . "</td>";
    echo "<td>" . $key['key_provider'] . "</td>";
    echo "<td>" . $key['large'] . "</td>";
    echo "<td>" . $key['fip'] . "</td>";
    echo "<td>" . $key['pump'] . "</td>";
    echo "<td>" . $key['access'] . "</td>";
    echo "<td>" . $key['is_key'] . "</td>";
    echo "</h3></tr>";
}

echo "</table>";
?>
