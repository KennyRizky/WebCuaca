import sys
import csv
import json

location = str(sys.argv[1])

dates = []
with open("weatherAUS.csv", 'r') as file:
    csvreader = csv.reader(file)
    header = next(csvreader)
    for row in csvreader:
        if row[1] == location:
            dates.append(row[0])
arrRes = []
arrRes.append(dates[0]);
arrRes.append(dates[-1]);
print(json.dumps(arrRes))