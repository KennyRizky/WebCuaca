import sys
import pandas as pd
import numpy as np
import pickle
from sklearn.feature_selection import SelectKBest
from sklearn.feature_selection import chi2
from sklearn.model_selection import train_test_split
from sklearn.neighbors import KNeighborsClassifier as KNN
from sklearn.metrics import accuracy_score
from sklearn.feature_selection import f_classif

dataFrame_cuaca = pd.read_csv("weatherAUS.csv")
dataFrame_cuaca.head()

dataFrame_cuaca_baru = dataFrame_cuaca

from sklearn import preprocessing
le = preprocessing.LabelEncoder()


str_cols = []
dataFrame_cuaca_baru = dataFrame_cuaca.iloc[:, 2:23]

for i, type in zip(np.arange(len(dataFrame_cuaca_baru.columns)), dataFrame_cuaca_baru.dtypes):
  if type == "O":
    str_cols.append(i)

for col in str_cols:
  dataFrame_cuaca_baru.iloc[:,col]= le.fit_transform(np.array(dataFrame_cuaca_baru.iloc[:,col].values.astype("str")).ravel())

dataFrame_cuaca_baru.head()

dataFrame_cuaca_baru = dataFrame_cuaca_baru.fillna(dataFrame_cuaca_baru.median())
dataFrame_cuaca_baru.head()

dataFrame_fiturCuaca = dataFrame_cuaca_baru.iloc[:, 0:19]
dataFrame_fiturCuaca.head(1)

df_label_today = dataFrame_cuaca_baru['RainToday']
df_label_today.head(1)

selectorToday = SelectKBest(score_func = f_classif, k = 3)
selectorToday.fit(dataFrame_fiturCuaca, df_label_today)

sel_features_today = selectorToday.get_support(indices = 3)

kolom_sel_features_today = dataFrame_fiturCuaca.iloc[:, sel_features_today]
kolom_sel_features_today.head()

x_train_today, x_test_today, y_train_today, y_test_today = train_test_split(kolom_sel_features_today, df_label_today, test_size = 0.3, random_state = 1)

list_hasilToday = []
for i in range(3, 5):

 Model_Today = KNN(n_neighbors=i)


 Model_Today.fit(x_train_today, y_train_today)

 
 y_pred_today = Model_Today.predict(x_test_today)

 
 acc_today = accuracy_score(y_test_today, y_pred_today)
 list_hasilToday.append(acc_today)


bestKToday = np.argmax(list_hasilToday)


best_modelToday = KNN(n_neighbors= 9).fit(x_train_today, y_train_today)
pkl_filename = "Today.pkl"
with open(pkl_filename, "wb") as file:
  pickle.dump(best_modelToday, file)


with open(pkl_filename, "rb") as file:
  loaded_model_KNN_Today = pickle.load(file)

predict_dataToday = {'Rainfall':[sys.argv[1]], 'Humidity9am':[sys.argv[2]], 'Humidity3pm':[sys.argv[3]]}
today = pd.DataFrame(predict_dataToday)
today.head()

y_pred_new_KNN_Today = loaded_model_KNN_Today.predict(today)
print(y_pred_new_KNN_Today)
