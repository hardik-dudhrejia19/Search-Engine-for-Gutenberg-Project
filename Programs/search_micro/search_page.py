import datetime
import fileinput
from flask import *
app = Flask(__name__)


@app.route('/search',methods=["GET", "POST"])
def data_search():
    key = request.args.get("keyword")
    flag = 0
    with fileinput.FileInput("log.txt", inplace=True) as file:
        for line in file:
            words = line.split("\t")
            if (words[1] == key):
                currentDT = datetime.datetime.now()
                count = int(words[2]) + 1
                original = words[0] + "\t" + words[1] + "\t" + words[2].strip()
                line_to_write = str(currentDT) + "\t" + key + "\t" + str(count)
                print(line.replace(original, line_to_write), end="")
                flag = 1
            else:
                print(line, end="")
    if (flag == 0):
        fp = open("log.txt", "a")
        currentDT = datetime.datetime.now()
        line_to_write = str(currentDT) + "\t" + key + "\t" + str(1) + "\n"
        fp.write(line_to_write)
        fp.close()
    resp={'completed':True}
    return make_response(jsonify(resp),201)


app.run(debug=True,port=5002,host='0.0.0.0')
