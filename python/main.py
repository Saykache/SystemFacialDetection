import cv2
import face_recognition
import numpy as np

# Carregar imagens e aprender como reconhecê-las
image1 = face_recognition.load_image_file("foto1.jpg")
image2 = face_recognition.load_image_file("foto2.jpg")
image3 = face_recognition.load_image_file("foto3.jpg")

encoding1 = face_recognition.face_encodings(image1)[0]
encoding2 = face_recognition.face_encodings(image2)[0]
encoding3 = face_recognition.face_encodings(image3)[0]

# Armazenar os encodings conhecidos e seus nomes
known_face_encodings = [encoding1, encoding2, encoding3]
known_face_names = ["Pessoa 1", "Pessoa 2", "Pessoa 3"]

# Inicializar a captura da webcam
webcam = cv2.VideoCapture(0)

while True:
    # Ler a imagem da webcam
    ret, frame = webcam.read()

    if not ret:
        break

    # Reduzir o tamanho do frame para processar mais rapidamente
    small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)
    rgb_small_frame = small_frame[:, :, ::-1]

    # Localizar e encodar os rostos no frame atual
    face_locations = face_recognition.face_locations(rgb_small_frame)
    face_encodings = face_recognition.face_encodings(rgb_small_frame, face_locations)

    face_names = []
    for face_encoding in face_encodings:
        # Comparar o rosto com os encodings conhecidos
        matches = face_recognition.compare_faces(known_face_encodings, face_encoding)
        name = "Desconhecido"

        # Se encontrar um rosto conhecido, usar o primeiro correspondente
        face_distances = face_recognition.face_distance(known_face_encodings, face_encoding)
        best_match_index = np.argmin(face_distances)
        if matches[best_match_index]:
            name = known_face_names[best_match_index]

        face_names.append(name)

    # Mostrar os resultados
    for (top, right, bottom, left), name in zip(face_locations, face_names):
        # Voltar a escala original do frame
        top *= 4
        right *= 4
        bottom *= 4
        left *= 4

        # Desenhar um retângulo ao redor do rosto
        cv2.rectangle(frame, (left, top), (right, bottom), (0, 0, 255), 2)

        # Desenhar uma etiqueta com o nome abaixo do rosto
        cv2.rectangle(frame, (left, bottom - 35), (right, bottom), (0, 0, 255), cv2.FILLED)
        font = cv2.FONT_HERSHEY_DUPLEX
        cv2.putText(frame, name, (left + 6, bottom - 6), font, 1.0, (255, 255, 255), 1)

    # Mostrar a imagem resultante
    cv2.imshow('Reconhecimento de Rosto', frame)

    # Sair do loop quando a tecla 'ESC' for pressionada
    if cv2.waitKey(1) & 0xFF == 27:
        break

# Liberar a webcam e fechar as janelas
webcam.release()
cv2.destroyAllWindows()
