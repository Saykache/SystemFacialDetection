FROM python:3.9

WORKDIR /app

COPY requirements.txt requirements.txt
RUN pip install --upgrade pip && apt update && apt install -y cmake &&  pip install -r requirements.txt

COPY . .

CMD ["python", "main.py"]
