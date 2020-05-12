import requests
from flask import *

app = Flask(__name__)


@app.route('/service',methods=["GET", "POST"])
def start_service():
    name = request.args.get("entered_text")
    task_type = request.args.get("task")
    if(task_type == "searching"):
        x = requests.get('http://54.152.253.247:5002/search?keyword=' + str(name))
        data = requests.get('http://54.152.253.247:5003/catalogue?keyword={}'.format(name)).content.decode('utf-8')
        return make_response(jsonify(data),201)
    if(task_type == "addnotes"):
        type = request.args.get("type")
        if(type=="Submission"):
            content = request.args.get("added_notes")
            keyword = request.args.get("keyword")
            data = requests.get('http://54.152.253.247:5004/notes?content={}&keyword={}&type={}'.format(content,keyword,type)).content.decode('utf-8')
            return make_response(jsonify(data), 201)
        if(type == "Retrieval"):

            retrieve_keyword = request.args.get("retrieve_keyword")
            data = requests.get('http://54.152.253.247:5004/notes?retrieve_keyword={}&type={}'.format(retrieve_keyword,type)).content.decode('utf-8')
            return data

app.run(debug=True,port=5001,host='0.0.0.0')
