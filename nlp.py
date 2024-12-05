import nltk 
nltk.download('wordnet')
from nltk.stem import WordNetLemmatizer
Lem = WordNetLemmatizer()
print(Lem.lemmatize("believes"))
print(Lem.lemmatize("stripes"))