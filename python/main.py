from flask import Flask, request, jsonify
import base64
from io import BytesIO
from PIL import Image, ImageChops
import io

app = Flask(__name__)

# Decodifica as imagens base64 para formato de imagem
def decode_base64_to_image(base64_string):
    if not base64_string:
        return None
    try:
        image_data = base64.b64decode(base64_string)
        image = Image.open(io.BytesIO(image_data))
        return image
    except Exception as e:
        print(f"Erro ao decodificar a imagem: {e}")
        return None

# Vai comparar as imagens
def compare_images(img1_path, img2_path):
    # Carregar as imagens dos caminhos fornecidos
    img1 = Image.open(img1_path)
    img2 = Image.open(img2_path)

    # Verificar se as imagens foram carregadas corretamente
    if img1 is None or img2 is None:
        raise ValueError("Uma ou ambas as imagens não foram carregadas corretamente.")

    # Calcular a diferença entre as imagens
    diff = ImageChops.difference(img1, img2)

    # Verificar se há diferença
    if diff.getbbox():
        return False  # As imagens são diferentes
    else:
        return True  # As imagens são iguais


@app.route('/reconizer', methods=['POST'])
def submit():
    # Capturar dados do formulário
    image1_base64 = request.form.get('imagemFormForVerify', None)
    image2_base64 = request.form.get('myImage', None)
    
    # Decodificar as imagens
    imagem1 =  decode_base64_to_image(image1_base64)
    imagem2 =  decode_base64_to_image(image2_base64)

    if not image1_base64 or not image2_base64:
        return jsonify({'error': 'Imagens não fornecidas ou inválidas.'}), 400

    sao_iguais = compare_images(imagem1, imagem2)

    response_data = {
        'image1_base64': image1_base64,
        'image2_base64': image2_base64,
        'sao_iguais': sao_iguais
        # 'marcos': '123 ok',
    }
    return jsonify(response_data)


if __name__ == '__main__':
    app.run(debug=False, host='0.0.0.0', port=8000)
