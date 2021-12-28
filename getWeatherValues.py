import sys
import csv
import json

location = str(sys.argv[1])
dateFrom = str(sys.argv[2])
dateTo = str(sys.argv[3])

rows = []
with open("weatherAUS.csv", 'r') as file:
    csvreader = csv.reader(file)
    header = next(csvreader)
    for row in csvreader:
        if(row[0] >= dateFrom and row[0] <= dateTo):
            if(row[1] == location):
                rows.append(row)
print(json.dumps(rows))