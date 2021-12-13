import csv

with open('weatherAUS.csv', 'r') as csv_file:
    csv_reader = csv.reader(csv_file)

    Location = []
    for line in csv_reader:
        if line[1] not in Location:
            Location.append(line[1])

    print(Location)