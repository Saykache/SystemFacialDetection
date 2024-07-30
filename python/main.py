from flask import Flask, request, redirect, url_for, flash, jsonify
import face_recognition
import os

app = Flask(__name__)

@app.route('/reconizer', methods=['GET', 'POST'])
def hello():
    return jsonify(message="olá")

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=8000)
