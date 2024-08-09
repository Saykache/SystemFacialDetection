from flask import Flask, request, jsonify
import face_recognition
import os

app = Flask(__name__)


@app.route('/reconizer', methods=['POST'])  
def submit():
    # Caminho da imagem principal que será comparada
    imagem1_path = request.form.get('caminho_da_imagem_cache', None)
    # Caminho da pasta onde estão as outras imagens
    pasta_de_fotos = request.form.get('pasta_fotos_user', None)

    # Carrega e codifica a imagem principal
    imagem1          = face_recognition.load_image_file(imagem1_path)
    imagem1_encoding = face_recognition.face_encodings(imagem1)[0]

    # Percorre todas as imagens na pasta
    for nome_arquivo in os.listdir(pasta_de_fotos):
        if nome_arquivo.endswith(('.jpg', '.jpeg', '.png')):  # Filtra para apenas imagens
            caminho_imagem_atual = os.path.join(pasta_de_fotos, nome_arquivo)
            
            # Carrega e codifica a imagem atual
            imagem_atual = face_recognition.load_image_file(caminho_imagem_atual)
            encodings_imagem_atual = face_recognition.face_encodings(imagem_atual)
            
            # Verifica se a imagem atual contém ao menos uma face
            if encodings_imagem_atual:
                imagem_atual_encoding = encodings_imagem_atual[0]
                
                # Compara a imagem principal com a imagem atual
                resultados = face_recognition.compare_faces([imagem1_encoding], imagem_atual_encoding)
                
                if resultados[0]:
                    response_data = {
                        'sucess': 'true',
                        'error':  'false',
                        'message': 'IR'
                    }
                else:
                    response_data = {
                        'sucess': 'false',
                        'error':  'true',
                        'message': 'ERROR'
                    }
            else:
                response_data = {
                    'sucess': 'false',
                    'error':  'false',
                    'message': 'INR'
                }
        else:
            response_data = {
                'error':  'erro',
                'message': 'INR'
            }

    return jsonify(response_data)

if __name__ == '__main__':
    app.run(debug=False, host='0.0.0.0', port=8000)
