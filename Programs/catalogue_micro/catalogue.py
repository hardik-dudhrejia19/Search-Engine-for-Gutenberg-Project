import os
import json
from flask import Flask, request
from pymongo import MongoClient
app = Flask(__name__)


@app.route('/catalogue',methods=['GET','POST'])
def database_search():
    client = MongoClient('mongodb://localhost:27017/')
    #client = MongoClient(os.environ['DB_PORT_27017_TCP_ADDR'], 27017)
    db = client["assignment3"]
    table = db["books"]
    name = request.args.get("keyword")
    result = table.find({'$or': [{"book_name": name}, {"author_name": name}]}, {'_id': False})
    answer_list = []
    for row in result:
        answer_list.append(row)
    answer = json.dumps(answer_list)
    return answer


app.run(debug=True,port=5003,host='0.0.0.0')
