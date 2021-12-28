import sys
import csv
import json

locations = []
with open("weatherAUS.csv", 'r') as file:
    csvreader = csv.reader(file)
    header = next(csvreader)
    for row in csvreader:
        if row[1] not in locations:
            locations.append(row[1])
print(json.dumps(locations))