import sys
import numpy as np
from elasticsearch import Elasticsearch
from sentence_transformers import SentenceTransformer

from secret.key import ENDPOINT, USERNAME, PASSWORD, CERT_FINGERPRINT

class Tokenizer(object):
    def __init__(self):
        self.model = SentenceTransformer('all-MiniLM-L6-v2')

    def get_token(self, documents):
        sentences  = [documents]
        sentence_embeddings = self.model.encode(sentences)
        _ = list(sentence_embeddings.flatten())
        encod_np_array = np.array(_)
        encod_list = encod_np_array.tolist()
        return encod_list
    
es = Elasticsearch(ENDPOINT, ssl_assert_fingerprint=CERT_FINGERPRINT, basic_auth=(USERNAME, PASSWORD))

param = sys.argv[1]
type_search = sys.argv[2]

def course_suggestion(input):
    helper_token = Tokenizer()
    token_vector = helper_token.get_token(input)

    query  ={
        "knn": {
        "field": "vector",
        "query_vector": token_vector,
        "k": 5,
        "num_candidates": 50,
        },
        "_source": ["title"]
    }

    res = es.search(index='course',
                body=query,
                size=50,
                request_timeout=55)

    title = [x['_source']  for x in res['hits']['hits']]
    return title


def job_suggestion(input):
    helper_token = Tokenizer()
    token_vector = helper_token.get_token(input)

    query  ={
        "knn": {
        "field": "vector",
        "query_vector": token_vector,
        "k": 5,
        "num_candidates": 50,
        },
        "_source": ["title"]
    }

    res = es.search(index='posting2',
                body=query,
                size=50,
                request_timeout=55)

    title = [x['_source']  for x in res['hits']['hits']]
    return title

result = []
if type_search == "courses":
    result = course_suggestion(param)
else:
    result = job_suggestion(param)

print(result)