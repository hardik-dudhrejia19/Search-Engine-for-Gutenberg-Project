from flask import *
app = Flask(__name__)


@app.route('/notes',methods=['GET','POST'])
def add_notes():
    operation_type = request.args.get("type")
    if(operation_type == "Submission"):
        content = request.args.get("content")
        keyword = request.args.get("keyword")
        fp = open("all_notes.txt","a")
        line_to_write = str(keyword) + "\t\t"+ str(content) + "\n"
        fp.write(line_to_write)
        fp.close()
        resp = {'completed': True}
        return make_response(jsonify(resp), 201)

    if(operation_type == "Retrieval"):
        keyword = request.args.get("retrieve_keyword")
        fp = open("all_notes.txt","r")
        lines = fp.readlines()
        answer_list = []
        for line in lines:
            words = line.split("\t\t")
            if(words[0] == keyword):
                answer_list.append(words[1])
        answer = json.dumps(answer_list)
        return answer


app.run(debug=True,port=5004,host='0.0.0.0')
