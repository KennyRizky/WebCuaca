import pandas as pd
import matplotlib.pyplot as plt
import numpy as np
import seaborn as sn
from matplotlib import pyplot 
import pickle
from sklearn import preprocessing
from sklearn.feature_selection import SelectKBest
from sklearn.feature_selection import chi2
from sklearn.model_selection import train_test_split

from sklearn.neighbors import KNeighborsClassifier
from sklearn import metrics
from sklearn import tree
from sklearn.tree import export_graphviz
import pydotplus
from sklearn.naive_bayes import GaussianNB

dt_weather = pd.read_csv('weatherAUS.csv')

dt_weather.columns
dt_weather.shape
dt_weather.dtypes
dt_weather.size
dt_weather.isnull().values.any()
dt_weather.describe()
dt_weather.isna().sum()
dt_weather.hist()
pyplot.show()
dt_weather = dt_weather.drop('Date', 1)
dt_weather = dt_weather.drop('Location', 1)
dt_weather = dt_weather.drop('WindGustDir', 1)
dt_weather = dt_weather.drop('WindDir9am' ,1)
dt_weather = dt_weather.drop('WindDir3pm', 1)

dt_weather.dropna(subset=['RainToday', 'RainTomorrow'], inplace=True)
dt_weather = dt_weather.dropna()

le = preprocessing.LabelEncoder()

label_rain_today = dt_weather[['RainToday']]
label_rain_today_np = np.array(label_rain_today.values).ravel()
label_rain_today_en = le.fit_transform(label_rain_today_np)

label_rain_tomorrow = dt_weather[['RainTomorrow']]
label_rain_tomorrow_np = np.array(label_rain_tomorrow.values).ravel()
label_rain_tomorrow_en = le.fit_transform(label_rain_tomorrow_np)

attr = dt_weather.drop('RainToday', 1)
attr = attr.drop('RainTomorrow', 1)

attr['MinTemp']  = attr['MinTemp'] + 6.7
attr['Temp9am']  = attr['Temp9am'] + 0.9

array_attr = np.array(attr)

X = array_attr
Y1 = label_rain_tommorrow_en
Y2 = label_rain_today_en

selector = SelectKBest(score_func=chi2, k = 2)
selector.fit(X, Y2)
cols2 = selector.get_support(indices=True)

selector = SelectKBest(score_func=chi2, k = 2)
selector.fit(X, Y1)
cols1 = selector.get_support(indices=True)

df_features = attr.iloc[:, cols2]

selector = SelectKBest(score_func=chi2, k = 2)
selector.fit(X, Y2)
cols2 = selector.get_support(indices=True)

df_features = attr.iloc[:, cols2]

array_fitur = np.array(df_features.values)

X_train, X_test, Y_train, Y_test = train_test_split(array_fitur, label_rain_today_en,random_state = 3, test_size=0.3)

from sklearn.naive_bayes import GaussianNB

NBC_model_weatherToday = GaussianNB()

NBC_model_weatherToday.fit(X_train, Y_train)

Y_pred = NBC_model_weatherToday.predict(X_test)

weatherToday_classes = label_rain_today.RainToday.unique()
print(weatherToday_classes)

from sklearn.metrics import classification_report
print(classification_report(Y_test, Y_pred, target_names = weatherToday_classes)) 

from sklearn import preprocessing
from sklearn.feature_selection import SelectKBest
from sklearn.feature_selection import chi2
from sklearn.model_selection import train_test_split
from sklearn.neighbors import KNeighborsClassifier
from sklearn import metrics

selector = SelectKBest(score_func=chi2, k = 2)
selector.fit(X, Y2)
cols2 = selector.get_support(indices=True)

df_features = attr.iloc[:, cols2]

array_fitur = np.array(df_features.values)

X_train, X_test, Y_train, Y_test = train_test_split(array_fitur, label_rain_today_en,random_state = 3, test_size=0.3)

k_range = range(3, 50)
scores = []

for k in k_range:
    kNN_model_weatherToday = KNeighborsClassifier(n_neighbors=k)
    kNN_model_weatherToday.fit(X_train, Y_train)
    Y_pred = kNN_model_weatherToday.predict(X_test)
    scores.append(metrics.accuracy_score(Y_test, Y_pred))
    
import matplotlib.pyplot as plt

plt.plot(k_range, scores)
plt.xlabel('Value of K for KNN')
plt.ylabel('Testing Accuracy')    

selector = SelectKBest(score_func=chi2, k = 2)
selector.fit(X, Y2)
cols2 = selector.get_support(indices=True)

df_features = attr.iloc[:, cols2]

array_fitur = np.array(df_features.values)

import numpy as np
import pandas as pd
import pickle
from sklearn.model_selection import train_test_split

from sklearn import tree

from sklearn.tree import export_graphviz
import pydotplus

DT_model_weatherToday = tree.DecisionTreeClassifier(criterion='entropy')
DT_model_weatherToday.fit(X_train,Y_train)

Y_pred = DT_model_weatherToday.predict(X_test)

print("Model accuracy:",metrics.accuracy_score(Y_test, Y_pred))
weatherToday_classes = label_rain_today.RainToday.unique()
print(weatherToday_classes)

from sklearn.metrics import classification_report
print(classification_report(Y_test, Y_pred, target_names = weatherToday_classes)) 

DT_model_weatherToday_final = tree.DecisionTreeClassifier(criterion='entropy')
DT_model_weatherToday_final.fit(X,Y2)

int_class_names=DT_model_weatherToday_final.classes_
str_class_names = int_class_names.astype(str)

dot_data = export_graphviz(DT_model_weatherToday_final,feature_names=attr.columns, class_names=str_class_names, filled=True,rounded=True,special_characters=True)
graph = pydotplus.graph_from_dot_data(dot_data)
graph.write_png("Dtree_weatherToday_model.png")

pkl_filename = "DT_model_weatherToday.pkl"  
with open(pkl_filename, 'wb') as file:  
    pickle.dump(DT_model_weatherToday_final, file)

with open(pkl_filename, 'rb') as file:  
    loaded_DT_model_weatherToday_final = pickle.load(file)

import pandas as pd
df_akurasi = pd.read_csv('TestRainToday.csv')
test_prediktor = df_akurasi[['Rainfall','Humidity3pm']].values

Y_pred_new = loaded_DT_model_weatherToday_final.predict(test_prediktor)
print(Y_pred_new)

selector = SelectKBest(score_func=chi2, k = 2)
selector.fit(X, Y1)
cols1 = selector.get_support(indices=True)

df_features = attr.iloc[:, cols1]

array_fitur = np.array(df_features.values)

X_train, X_test, Y_train, Y_test = train_test_split(array_fitur, label_rain_tomorrow_en,random_state = 3, test_size=0.3)

from sklearn.naive_bayes import GaussianNB

NBC_model_weatherTomorrow = GaussianNB()

NBC_model_weatherTomorrow.fit(X_train, Y_train)

Y_pred = NBC_model_weatherTomorrow.predict(X_test)

weatherTomorrow_classes = label_rain_tomorrow.RainTomorrow.unique()
print(weatherTomorrow_classes)

from sklearn.metrics import classification_report
print(classification_report(Y_test, Y_pred, target_names = weatherTomorrow_classes)) 

from sklearn import preprocessing
from sklearn.feature_selection import SelectKBest
from sklearn.feature_selection import chi2
from sklearn.model_selection import train_test_split
from sklearn.neighbors import KNeighborsClassifier
from sklearn import metrics

selector = SelectKBest(score_func=chi2, k = 2)
selector.fit(X, Y1)
cols1 = selector.get_support(indices=True)

df_features = attr.iloc[:, cols1]

array_fitur = np.array(df_features.values)

X_train, X_test, Y_train, Y_test = train_test_split(array_fitur, label_rain_tomorrow_en,random_state = 3, test_size=0.3)

k_range = range(3, 50)
scores = []

for k in k_range:
    kNN_model_weatherTomorrow = KNeighborsClassifier(n_neighbors=k)
    kNN_model_weatherTomorrow.fit(X_train, Y_train)
    Y_pred = kNN_model_weatherTomorrow.predict(X_test)
    scores.append(metrics.accuracy_score(Y_test, Y_pred))
    
kNN_model_weatherTomorrow = KNeighborsClassifier(n_neighbors=45)
kNN_model_weatherTomorrow.fit(X_train, Y_train)
Y_pred = kNN_model_weatherTomorrow.predict(X_test)
scores.append(metrics.accuracy_score(Y_test, Y_pred))

import matplotlib.pyplot as plt

plt.plot(k_range, scores)
plt.xlabel('Value of K for KNN')
plt.ylabel('Testing Accuracy')    

selector = SelectKBest(score_func=chi2, k = 2)
selector.fit(X, Y1)
cols1 = selector.get_support(indices=True)

df_features = attr.iloc[:, cols1]

array_fitur = np.array(df_features.values)

import numpy as np
import pandas as pd
import pickle
from sklearn.model_selection import train_test_split

from sklearn import tree

from sklearn.tree import export_graphviz
import pydotplus

DT_model_weatherTomorrow = tree.DecisionTreeClassifier(criterion='entropy')
DT_model_weatherTomorrow.fit(X_train,Y_train)

Y_pred = DT_model_weatherTomorrow.predict(X_test)

print("Model accuracy:",metrics.accuracy_score(Y_test, Y_pred))
weatherTomorrow_classes = label_rain_tomorrow.RainTomorrow.unique()
print(weatherTomorrow_classes)

from sklearn.metrics import classification_report
print(classification_report(Y_test, Y_pred, target_names = weatherTomorrow_classes)) 

DT_model_weatherTomorrow_final = tree.DecisionTreeClassifier(criterion='entropy')
DT_model_weatherTomorrow_final.fit(X,Y2)

int_class_names=DT_model_weatherTomorrow_final.classes_
str_class_names = int_class_names.astype(str)

dot_data = export_graphviz(DT_model_weatherTomorrow_final,feature_names=attr.columns, class_names=str_class_names, filled=True,rounded=True,special_characters=True)
graph = pydotplus.graph_from_dot_data(dot_data)
graph.write_png("Dtree_weatherTomorrow_model.png")

pkl_filename = "kNN_model_weatherTomorrow.pkl"  
with open(pkl_filename, 'wb') as file:  
    pickle.dump(kNN_model_weatherTomorrow, file)
    
with open(pkl_filename, 'rb') as file:  
    loaded_kNN_model_weatherTomorrow = pickle.load(file)
    
df_akurasi = pd.read_csv('TestRainTomorrow.csv')
test_prediktor = df_akurasi[['Rainfall','Humidity3pm']].values

Y_pred_new = loaded_kNN_model_weatherToday_final.predict(test_prediktor)
print(Y_pred_new)
