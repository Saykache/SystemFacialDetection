import face_recognition

def compare_faces(image1_path, image2_path):
    # Carregar as imagens
    image1 = face_recognition.load_image_file(image1_path)
    image2 = face_recognition.load_image_file(image2_path)
    
    # Obter os encodings faciais das imagens
    image1_encodings = face_recognition.face_encodings(image1)
    image2_encodings = face_recognition.face_encodings(image2)
    
    # Verificar se ambas as imagens contêm pelo menos um rosto
    if len(image1_encodings) == 0 or len(image2_encodings) == 0:
        return False, "Uma ou ambas as imagens não contêm nenhum rosto."
    
    # Comparar os rostos
    matches = face_recognition.compare_faces([image1_encodings[0]], image2_encodings[0])
    
    return matches[0]

# Exemplo de uso:
image1_path = './images/fotologin.jpeg'
image2_path = './images/fotomarcela.jpeg'

is_same_person = compare_faces(image1_path, image2_path)

if is_same_person:
    print("A pessoa na foto 1 é a mesma pessoa na foto 2.")
else:
    print("A pessoa na foto 1 não é a mesma pessoa na foto 2.")
