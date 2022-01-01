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

df_label_tomorrow = dataFrame_cuaca_baru['RainTomorrow']
df_label_tomorrow.head(1)

selectorTomorrow = SelectKBest(score_func = f_classif, k = 3)
selectorTomorrow.fit(dataFrame_fiturCuaca, df_label_tomorrow)

sel_features_Tomorrow = selectorTomorrow.get_support(indices = 3)

kolom_sel_features_Tomorrow = dataFrame_fiturCuaca.iloc[:, sel_features_Tomorrow]
kolom_sel_features_Tomorrow.head()

x_train_tomorrow, x_test_tomorrow, y_train_tomorrow, y_test_tomorrow = train_test_split(kolom_sel_features_Tomorrow, df_label_tomorrow, test_size = 0.3, random_state = 1)

list_hasilTmr = []
for i in range(3, 5):
 KNN_MODEL_tomorrow  = KNN(n_neighbors=i)

 KNN_MODEL_tomorrow.fit(x_train_tomorrow, y_train_tomorrow)

 y_pred_tomorrow = KNN_MODEL_tomorrow.predict(x_test_tomorrow)

 acc_tomorrow = accuracy_score(y_test_tomorrow, y_pred_tomorrow)
 list_hasilTmr.append(acc_tomorrow)

bestK_tomorrow = np.argmax(list_hasilTmr)

best_modelTmr = KNN(n_neighbors= 50).fit(x_train_tomorrow, y_train_tomorrow)
pkl_filename_tomorrow = "Tomorrow.pkl"
with open(pkl_filename_tomorrow, "wb") as file:
  pickle.dump(best_modelTmr, file)

with open(pkl_filename_tomorrow, "rb") as file:
  loaded_model_KNN_tomorrow = pickle.load(file)

test_new_data_tomorrow = {'Sunshine':[sys.argv[1]], 'Humidity3pm':[sys.argv[2]], 'Cloud3pm':[sys.argv[3]]}
test_tomorrow = pd.DataFrame(test_new_data_tomorrow)
test_tomorrow.head()

y_pred_new_KNN_tomorrow = loaded_model_KNN_tomorrow.predict(test_tomorrow)
print(y_pred_new_KNN_tomorrow)