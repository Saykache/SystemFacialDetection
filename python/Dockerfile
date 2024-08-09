FROM python:3.10

WORKDIR /app

# Instale as dependências do sistema necessárias para o face_recognition
RUN apt-get update && \
    apt-get install -y \
    build-essential \
    cmake \
    libopenblas-dev \
    liblapack-dev \
    libx11-dev \
    libgtk-3-dev \
    libboost-python-dev \
    libboost-thread-dev \
    libatlas-base-dev \
    libdlib-dev \
    python3-dev \
    && rm -rf /var/lib/apt/lists/*

# Instale a biblioteca face_recognition e suas dependências
RUN pip install --no-cache-dir dlib face_recognition flask

COPY . .

CMD ["python", "main.py"]
